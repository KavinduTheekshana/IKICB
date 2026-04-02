<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
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
                        Forms\Components\Select::make('user_id')
                            ->label('Student')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
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
                                'payhere' => 'PayHere',
                                'bank_transfer' => 'Bank Transfer',
                                'webxpay' => 'WebXPay',
                                'cash' => 'Cash',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Select::make('payment_gateway')
                            ->label('Payment Gateway')
                            ->options([
                                'payhere' => 'PayHere',
                                'bank_transfer' => 'Bank Transfer',
                                'webxpay' => 'WebXPay',
                                'manual' => 'Manual',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('currency')
                            ->label('Currency')
                            ->default('LKR')
                            ->maxLength(10),
                    ])->columns(2),

                Forms\Components\Section::make('Course/Module Assignment')
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
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('module_id', null);
                                if ($state) {
                                    $course = \App\Models\Course::find($state);
                                    if ($course && $course->full_price) {
                                        $set('amount', $course->full_price);
                                    }
                                }
                            }),
                        Forms\Components\Select::make('module_id')
                            ->label('Module (leave empty for full course)')
                            ->relationship('module', 'title')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $module = \App\Models\Module::find($state);
                                    if ($module && $module->module_price) {
                                        $set('amount', $module->module_price);
                                        if ($module->course_id) {
                                            $set('course_id', $module->course_id);
                                        }
                                    }
                                } else {
                                    // Module cleared — refill course full price
                                    $courseId = $get('course_id');
                                    if ($courseId) {
                                        $course = \App\Models\Course::find($courseId);
                                        if ($course && $course->full_price) {
                                            $set('amount', $course->full_price);
                                        }
                                    }
                                }
                            }),
                    ])->columns(2)
                    ->description('Assign a course (full purchase) or specific module (module-wise purchase). Amount will auto-fill from selected course/module price.'),

                Forms\Components\Section::make('Bank Transfer Details')
                    ->schema([
                        Forms\Components\TextInput::make('reference_number')
                            ->label('Reference Number')
                            ->maxLength(255),
                        Forms\Components\Placeholder::make('receipt_display')
                            ->label('Receipt')
                            ->content(function ($record) {
                                if (!$record || !$record->receipt_path) {
                                    return 'No receipt uploaded';
                                }
                                $url = asset('storage/' . $record->receipt_path);
                                $extension = pathinfo($record->receipt_path, PATHINFO_EXTENSION);

                                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                    // Display inline image preview with lightbox
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="space-y-2">
                                            <div class="mt-2">
                                                <a href="' . $url . '"
                                                   onclick="openReceiptModal(\'' . $url . '\'); return false;"
                                                   class="cursor-pointer block">
                                                    <img src="' . $url . '"
                                                         alt="Receipt"
                                                         class="max-w-md rounded-lg shadow-sm border hover:shadow-md transition-shadow cursor-pointer" />
                                                </a>
                                                <p class="text-sm text-gray-500 mt-1">Click image to view full size</p>
                                            </div>
                                        </div>
                                        <div id="receipt-modal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-75 z-50 items-center justify-center p-4" onclick="closeReceiptModal()">
                                            <div class="relative max-w-7xl max-h-full">
                                                <button onclick="closeReceiptModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                                <img id="receipt-modal-img" src="" alt="Receipt Full Size" class="max-w-full max-h-screen rounded-lg" onclick="event.stopPropagation()">
                                            </div>
                                        </div>
                                        <script>
                                        function openReceiptModal(url) {
                                            const modal = document.getElementById("receipt-modal");
                                            document.getElementById("receipt-modal-img").src = url;
                                            modal.style.display = "flex";
                                            document.body.style.overflow = "hidden";
                                        }
                                        function closeReceiptModal() {
                                            const modal = document.getElementById("receipt-modal");
                                            modal.style.display = "none";
                                            document.body.style.overflow = "auto";
                                        }
                                        document.addEventListener("keydown", function(e) {
                                            if (e.key === "Escape") closeReceiptModal();
                                        });
                                        </script>'
                                    );
                                } else {
                                    // Display embedded PDF viewer
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="space-y-2">
                                            <div class="border rounded-lg overflow-hidden" style="height: 600px;">
                                                <iframe src="' . $url . '"
                                                        class="w-full h-full"
                                                        frameborder="0">
                                                </iframe>
                                            </div>
                                            <p class="text-sm text-gray-500">PDF Receipt Preview</p>
                                        </div>'
                                    );
                                }
                            })
                            ->visible(fn ($record) => $record && $record->receipt_path),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3)
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
                        'warning' => 'webxpay',
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
                        'webxpay' => 'WebXPay',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Payment')
                    ->modalDescription('Are you sure you want to delete this payment? This action cannot be undone.')
                    ->successNotificationTitle('Payment deleted successfully'),
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

        static::handlePaymentCompleted($payment);
    }

    public static function handlePaymentCompleted(Payment $payment): void
    {
        // Refresh from DB to clear any stale relationship cache and get latest field values
        $payment->refresh();
        $payment->load('course.modules', 'module');

        // Set completion timestamps if not already set
        if (!$payment->completed_at) {
            $payment->update([
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'completed_at' => now(),
            ]);
        }

        // Check module_id FIRST — if module_id is set it is a module-wise purchase.
        // Never treat it as full course even if course_id is also set.
        if ($payment->module_id) {
            // Module-wise purchase: unlock that single module only
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

            // Enroll in the course as module_wise so the student can access the course area
            if ($payment->course_id) {
                Enrollment::firstOrCreate(
                    [
                        'user_id' => $payment->user_id,
                        'course_id' => $payment->course_id,
                    ],
                    [
                        'purchase_type' => 'module_wise',
                        'enrolled_at' => now(),
                    ]
                );
            }
        } elseif ($payment->course_id && $payment->course) {
            // Full course purchase: enroll + unlock ALL modules in the course
            Enrollment::firstOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                ],
                [
                    'purchase_type' => 'full_course',
                    'enrolled_at' => now(),
                ]
            );

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
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
