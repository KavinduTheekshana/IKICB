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
            ->whereHas('user', fn ($q) => $q->where('branch_id', auth()->user()->branch_id))
            ->where('status', '!=', 'initiated');
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
                                'webxpay'       => 'WebXPay',
                                'other'         => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Select::make('payment_gateway')
                            ->label('Payment Gateway')
                            ->options([
                                'bank_transfer' => 'Bank Transfer',
                                'webxpay'       => 'WebXPay',
                                'manual'        => 'Manual',
                            ])
                            ->nullable(),
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

                Forms\Components\Section::make('Course/Module Assignment')
                    ->description('Assign a course (full purchase) or specific module (module-wise purchase). Amount will auto-fill from selected course/module price.')
                    ->schema([
                        Forms\Components\Placeholder::make('full_course_badge')
                            ->label('')
                            ->content(fn (callable $get) => new \Illuminate\Support\HtmlString(
                                '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    &#10003; Full Course &mdash; All modules will be unlocked
                                </span>'
                            ))
                            ->visible(fn (callable $get) => $get('course_id') && !$get('module_id'))
                            ->columnSpanFull(),
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('module_id', null);
                                if ($state) {
                                    $course = Course::find($state);
                                    if ($course && $course->full_price) {
                                        $set('amount', $course->full_price);
                                    }
                                }
                            }),
                        Forms\Components\Select::make('module_id')
                            ->label('Module (leave empty for full course)')
                            ->relationship('module', 'title')
                            ->searchable()
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $module = Module::find($state);
                                    if ($module && $module->module_price) {
                                        $set('amount', $module->module_price);
                                        if ($module->course_id) {
                                            $set('course_id', $module->course_id);
                                        }
                                    }
                                } else {
                                    $courseId = $get('course_id');
                                    if ($courseId) {
                                        $course = Course::find($courseId);
                                        if ($course && $course->full_price) {
                                            $set('amount', $course->full_price);
                                        }
                                    }
                                }
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Bank Transfer Details')
                    ->schema([
                        Forms\Components\TextInput::make('reference_number')
                            ->label('Reference Number')
                            ->nullable(),
                        Forms\Components\Placeholder::make('receipt_display')
                            ->label('Receipt')
                            ->content(function ($record) {
                                if (!$record || !$record->receipt_path) {
                                    return 'No receipt uploaded';
                                }
                                $url = asset('storage/' . $record->receipt_path);
                                $ext = strtolower(pathinfo($record->receipt_path, PATHINFO_EXTENSION));

                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="space-y-2">
                                            <a href="' . $url . '" target="_blank" class="block">
                                                <img src="' . $url . '" alt="Receipt"
                                                     class="max-w-md rounded-lg shadow-sm border hover:shadow-md transition-shadow cursor-pointer" />
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">Click image to open full size</p>
                                        </div>'
                                    );
                                }

                                return new \Illuminate\Support\HtmlString(
                                    '<div class="border rounded-lg overflow-hidden" style="height:500px;">
                                        <iframe src="' . $url . '" class="w-full h-full" frameborder="0"></iframe>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">PDF Receipt Preview</p>'
                                );
                            })
                            ->visible(fn ($record) => $record && $record->receipt_path),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Notes')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
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
                        $record->module?->title
                            ? $record->course?->title . ' › ' . $record->module->title
                            : ($record->course?->title ?? '—')
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
                        'webxpay'       => 'primary',
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
                        'webxpay'       => 'WebXPay',
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
                    ->visible(fn (Payment $record): bool => $record->payment_method === 'bank_transfer' && $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn (Payment $record) => static::processPaymentApproval($record)),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Payment $record): bool => $record->payment_method === 'bank_transfer' && $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Reason for Rejection')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Payment $record, array $data) {
                        $record->update([
                            'status'      => 'failed',
                            'admin_notes' => $data['admin_notes'],
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                        Notification::make()->title('Payment Rejected')->danger()->send();
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

    public static function processPaymentApproval(Payment $payment): void
    {
        $payment->update([
            'status'       => 'completed',
            'approved_by'  => auth()->id(),
            'approved_at'  => now(),
            'completed_at' => now(),
        ]);

        static::handlePaymentCompleted($payment);

        Notification::make()->title('Payment approved successfully')->success()->send();
    }

    protected static function handlePaymentCompleted(Payment $payment): void
    {
        $payment->refresh();
        $payment->load('course.modules', 'module');

        if ($payment->module_id) {
            // Module-wise purchase: unlock that single module
            ModuleUnlock::firstOrCreate(
                ['user_id' => $payment->user_id, 'module_id' => $payment->module_id],
                ['payment_id' => $payment->id, 'unlocked_at' => now()]
            );

            // Enroll in course as module_wise so student can access the course area
            if ($payment->course_id) {
                Enrollment::firstOrCreate(
                    ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                    ['purchase_type' => 'module_wise', 'enrolled_at' => now()]
                );
            }
        } elseif ($payment->course_id && $payment->course) {
            // Full course purchase: enroll + unlock ALL modules
            Enrollment::firstOrCreate(
                ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                ['purchase_type' => 'full_course', 'enrolled_at' => now()]
            );

            foreach ($payment->course->modules as $module) {
                ModuleUnlock::firstOrCreate(
                    ['user_id' => $payment->user_id, 'module_id' => $module->id],
                    ['payment_id' => $payment->id, 'unlocked_at' => now()]
                );
            }
        }
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
