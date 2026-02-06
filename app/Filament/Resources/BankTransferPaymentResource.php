<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankTransferPaymentResource\Pages;
use App\Models\BankTransferPayment;
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

class BankTransferPaymentResource extends Resource
{
    protected static ?string $model = BankTransferPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Bank Transfers';

    protected static ?string $navigationGroup = 'Payments';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'reference_number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Student Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('user.email')
                            ->label('Student Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('reference_number')
                            ->label('Reference Number')
                            ->disabled(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount (LKR)')
                            ->disabled()
                            ->prefix('LKR'),
                    ])->columns(2),

                Forms\Components\Section::make('Course/Module Information')
                    ->schema([
                        Forms\Components\TextInput::make('course.title')
                            ->label('Course')
                            ->disabled()
                            ->hidden(fn ($record) => !$record->course_id),
                        Forms\Components\TextInput::make('module.title')
                            ->label('Module')
                            ->disabled()
                            ->hidden(fn ($record) => !$record->module_id),
                    ]),

                Forms\Components\Section::make('Receipt')
                    ->schema([
                        Forms\Components\FileUpload::make('receipt_path')
                            ->label('Payment Receipt')
                            ->disk('public')
                            ->disabled()
                            ->downloadable()
                            ->openable()
                            ->image()
                            ->imagePreviewHeight('250'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Student Notes')
                            ->disabled()
                            ->rows(2),
                    ]),

                Forms\Components\Section::make('Admin Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->reactive(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3)
                            ->placeholder('Add notes about approval/rejection...'),
                        Forms\Components\TextInput::make('approvedBy.name')
                            ->label('Approved/Rejected By')
                            ->disabled()
                            ->hidden(fn ($record) => !$record->approved_by),
                        Forms\Components\DateTimePicker::make('approved_at')
                            ->label('Approved/Rejected At')
                            ->disabled()
                            ->hidden(fn ($record) => !$record->approved_at),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('Reference #')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course/Module')
                    ->formatStateUsing(fn ($record) => $record->course ? $record->course->title : ($record->module ? $record->module->title : '-'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->course ? $record->course->title : ($record->module ? $record->module->title : null)),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('receipt_path')
                    ->label('Receipt')
                    ->disk('public')
                    ->size(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->after(function (BankTransferPayment $record) {
                        // Process approval/rejection
                        if ($record->wasChanged('status')) {
                            if ($record->status === 'approved' && $record->approved_at === null) {
                                self::processApproval($record);
                            } elseif ($record->status === 'rejected' && $record->approved_at === null) {
                                self::processRejection($record);
                            }
                        }
                    }),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (BankTransferPayment $record) => $record->status === 'pending')
                    ->action(function (BankTransferPayment $record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        self::processApproval($record);

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
                    ->visible(fn (BankTransferPayment $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Reason for Rejection')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (BankTransferPayment $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        self::processRejection($record);

                        Notification::make()
                            ->title('Payment Rejected')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function processApproval(BankTransferPayment $record)
    {
        // Create enrollment/unlock for course or module
        if ($record->course_id) {
            // Create enrollment
            Enrollment::firstOrCreate(
                [
                    'user_id' => $record->user_id,
                    'course_id' => $record->course_id,
                ],
                [
                    'enrolled_at' => now(),
                ]
            );

            // Create payment record first
            $payment = Payment::create([
                'user_id' => $record->user_id,
                'course_id' => $record->course_id,
                'amount' => $record->amount,
                'transaction_id' => 'BANK-' . $record->reference_number,
                'payment_method' => 'bank_transfer',
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Unlock all modules in the course with payment_id
            $modules = $record->course->modules;
            foreach ($modules as $module) {
                ModuleUnlock::firstOrCreate(
                    [
                        'user_id' => $record->user_id,
                        'module_id' => $module->id,
                    ],
                    [
                        'payment_id' => $payment->id,
                        'unlocked_at' => now(),
                    ]
                );
            }
        } elseif ($record->module_id) {
            // Create payment record first
            $payment = Payment::create([
                'user_id' => $record->user_id,
                'module_id' => $record->module_id,
                'amount' => $record->amount,
                'transaction_id' => 'BANK-' . $record->reference_number,
                'payment_method' => 'bank_transfer',
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Unlock module with payment_id
            ModuleUnlock::firstOrCreate(
                [
                    'user_id' => $record->user_id,
                    'module_id' => $record->module_id,
                ],
                [
                    'payment_id' => $payment->id,
                    'unlocked_at' => now(),
                ]
            );
        }
    }

    protected static function processRejection(BankTransferPayment $record)
    {
        // Notify user about rejection (can be implemented via email/notification)
        // For now, just update the record
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankTransferPayments::route('/'),
            'view' => Pages\ViewBankTransferPayment::route('/{record}'),
            'edit' => Pages\EditBankTransferPayment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
