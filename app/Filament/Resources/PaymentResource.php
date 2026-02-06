<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Enrollment;
use App\Models\ModuleUnlock;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Payments';

    protected static ?string $navigationGroup = 'Payments';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'course', 'module']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('student_name')
                            ->label('Student')
                            ->formatStateUsing(fn ($record) => $record->user?->name ?? 'N/A')
                            ->disabled(),
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->disabled(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount')
                            ->disabled()
                            ->prefix('LKR'),
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Payment Method')
                            ->disabled(),
                        Forms\Components\TextInput::make('status')
                            ->label('Status')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Course/Module')
                    ->schema([
                        Forms\Components\TextInput::make('course_title')
                            ->label('Course')
                            ->formatStateUsing(fn ($record) => $record->course?->title ?? 'N/A')
                            ->disabled(),
                        Forms\Components\TextInput::make('module_title')
                            ->label('Module')
                            ->formatStateUsing(fn ($record) => $record->module?->title ?? 'N/A')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Bank Transfer Details')
                    ->schema([
                        Forms\Components\TextInput::make('reference_number')
                            ->label('Reference Number')
                            ->disabled(),
                        Forms\Components\FileUpload::make('receipt_path')
                            ->label('Receipt')
                            ->disabled()
                            ->visibility('public'),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3),
                    ])
                    ->visible(fn ($record) => $record && $record->payment_method === 'bank_transfer'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->default(fn ($record) => $record->module ? $record->module->title : '-'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->colors([
                        'primary' => 'payhere',
                        'success' => 'bank_transfer',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'failed',
                        'gray' => 'refunded',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'payhere' => 'PayHere',
                        'bank_transfer' => 'Bank Transfer',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->payment_method === 'bank_transfer' && $record->status === 'pending')
                    ->action(function ($record) {
                        self::processPaymentApproval($record);
                        Notification::make()
                            ->title('Payment Approved')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->payment_method === 'bank_transfer' && $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Reason for Rejection')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'failed',
                            'admin_notes' => $data['admin_notes'],
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                        Notification::make()
                            ->title('Payment Rejected')
                            ->danger()
                            ->send();
                    }),
                Tables\Actions\Action::make('view_receipt')
                    ->label('View Receipt')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->visible(fn ($record) => $record->payment_method === 'bank_transfer' && $record->receipt_path)
                    ->url(fn ($record) => asset('storage/' . $record->receipt_path))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected static function processPaymentApproval(Payment $payment): void
    {
        // Update payment status
        $payment->update([
            'status' => 'completed',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'completed_at' => now(),
        ]);

        // Create enrollment/unlock for course or module
        if ($payment->course_id) {
            // Create enrollment
            Enrollment::firstOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                ],
                [
                    'enrolled_at' => now(),
                ]
            );

            // Unlock all modules in the course
            $modules = $payment->course->modules;
            foreach ($modules as $module) {
                ModuleUnlock::firstOrCreate(
                    [
                        'user_id' => $payment->user_id,
                        'module_id' => $module->id,
                    ],
                    [
                        'payment_id' => $payment->id,
                        'unlocked_at' => now(),
                    ]
                );
            }
        } elseif ($payment->module_id) {
            // Unlock single module
            ModuleUnlock::firstOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'module_id' => $payment->module_id,
                ],
                [
                    'payment_id' => $payment->id,
                    'unlocked_at' => now(),
                ]
            );
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
