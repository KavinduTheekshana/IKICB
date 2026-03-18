<?php

namespace App\Filament\Branch\Resources;

use App\Filament\Branch\Resources\PaymentResource\Pages;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\ModuleUnlock;
use App\Models\Payment;
use App\Models\User;
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
        return parent::getEloquentQuery()
            ->with(['user', 'course', 'module'])
            ->whereHas('user', fn ($q) => $q->where('branch_id', auth()->user()->branch_id));
    }

    public static function form(Form $form): Form
    {
        $branchId = auth()->user()->branch_id;

        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Student')
                            ->options(
                                User::where('role', 'student')
                                    ->where('branch_id', $branchId)
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount')
                            ->required()
                            ->numeric()
                            ->prefix('LKR')
                            ->minValue(0),
                        Forms\Components\Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'bank_transfer' => 'Bank Transfer',
                                'cash'          => 'Cash',
                                'other'         => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending'   => 'Pending',
                                'completed' => 'Completed',
                                'failed'    => 'Failed',
                                'refunded'  => 'Refunded',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\TextInput::make('currency')
                            ->label('Currency')
                            ->default('LKR')
                            ->maxLength(10),
                    ])->columns(2),

                Forms\Components\Section::make('Course / Module')
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('amount', $state ? Course::find($state)?->full_price : null)
                            ),
                        Forms\Components\Select::make('module_id')
                            ->label('Module (optional)')
                            ->relationship('module', 'title')
                            ->searchable()
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('amount', $state ? Module::find($state)?->module_price : null)
                            ),
                    ])->columns(2),

                Forms\Components\Section::make('Bank Transfer Details')
                    ->schema([
                        Forms\Components\TextInput::make('reference_number')
                            ->label('Reference Number')
                            ->nullable(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Notes')
                            ->rows(3)
                            ->nullable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course / Module')
                    ->getStateUsing(fn (Payment $record) =>
                        $record->course?->title ?? $record->module?->title ?? '—'
                    )
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bank_transfer' => 'info',
                        'cash'          => 'success',
                        default         => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'pending'   => 'warning',
                        'failed'    => 'danger',
                        'refunded'  => 'gray',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'completed' => 'Completed',
                        'failed'    => 'Failed',
                        'refunded'  => 'Refunded',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'cash'          => 'Cash',
                        'other'         => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Payment $record): bool =>
                        $record->status === 'pending' && $record->payment_method === 'bank_transfer'
                    )
                    ->requiresConfirmation()
                    ->action(fn (Payment $record) => static::processPaymentApproval($record)),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Payment $record): bool =>
                        $record->status === 'pending' && $record->payment_method === 'bank_transfer'
                    )
                    ->requiresConfirmation()
                    ->action(function (Payment $record) {
                        $record->update(['status' => 'failed']);
                        Notification::make()->title('Payment rejected')->warning()->send();
                    }),
                Tables\Actions\Action::make('view_receipt')
                    ->label('Receipt')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->visible(fn (Payment $record): bool => filled($record->receipt_path))
                    ->url(fn (Payment $record): string => asset('storage/' . $record->receipt_path), shouldOpenInNewTab: true),
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
        $payment->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        if ($payment->course_id && !Enrollment::where('user_id', $payment->user_id)->where('course_id', $payment->course_id)->exists()) {
            Enrollment::create([
                'user_id'       => $payment->user_id,
                'course_id'     => $payment->course_id,
                'purchase_type' => 'full_course',
                'status'        => 'active',
                'enrolled_at'   => now(),
            ]);
        }

        if ($payment->module_id) {
            ModuleUnlock::firstOrCreate([
                'user_id'   => $payment->user_id,
                'module_id' => $payment->module_id,
            ]);
        }

        Notification::make()->title('Payment approved successfully')->success()->send();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view'   => Pages\ViewPayment::route('/{record}'),
            'edit'   => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
