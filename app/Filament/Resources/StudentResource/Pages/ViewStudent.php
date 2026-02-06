<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\BankTransferPayment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ModuleUnlock;
use App\Models\Payment;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('add_enrollment')
                ->label('Add Course Enrollment')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->form([
                    Forms\Components\Select::make('course_id')
                        ->label('Course')
                        ->options(Course::where('is_published', true)->pluck('title', 'id'))
                        ->required()
                        ->searchable()
                        ->preload(),
                ])
                ->action(function (array $data) {
                    $enrollment = Enrollment::firstOrCreate([
                        'user_id' => $this->record->id,
                        'course_id' => $data['course_id'],
                    ], [
                        'enrolled_at' => now(),
                    ]);

                    if ($enrollment->wasRecentlyCreated) {
                        Notification::make()
                            ->title('Enrollment Added')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Student Already Enrolled')
                            ->warning()
                            ->send();
                    }
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Student Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Name'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('branch.name')
                            ->label('Branch')
                            ->default('N/A'),
                        Infolists\Components\TextEntry::make('course.title')
                            ->label('Registered Course')
                            ->default('N/A'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Registered')
                            ->dateTime('M d, Y h:i A'),
                    ])->columns(3),

                Infolists\Components\Section::make('Statistics')
                    ->schema([
                        Infolists\Components\TextEntry::make('enrollments_count')
                            ->label('Total Enrollments')
                            ->getStateUsing(fn ($record) => $record->enrollments()->count())
                            ->badge()
                            ->color('success'),
                        Infolists\Components\TextEntry::make('completed_payments')
                            ->label('Completed Payments')
                            ->getStateUsing(fn ($record) => $record->payments()->where('status', 'completed')->count())
                            ->badge()
                            ->color('info'),
                        Infolists\Components\TextEntry::make('module_completions')
                            ->label('Modules Completed')
                            ->getStateUsing(fn ($record) => $record->moduleCompletions()->count())
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('quiz_attempts')
                            ->label('Quiz Attempts')
                            ->getStateUsing(fn ($record) => $record->quizAttempts()->count())
                            ->badge()
                            ->color('warning'),
                        Infolists\Components\TextEntry::make('average_score')
                            ->label('Average Quiz Score')
                            ->getStateUsing(function ($record) {
                                $avg = $record->quizAttempts()->avg('score');
                                return $avg ? number_format($avg, 1) . '%' : 'N/A';
                            })
                            ->badge()
                            ->color('success'),
                    ])->columns(5),

                Infolists\Components\Section::make('Enrolled Courses')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('enrollments')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('course.title')
                                    ->label('Course')
                                    ->weight('bold'),
                                Infolists\Components\TextEntry::make('enrolled_at')
                                    ->label('Enrolled Date')
                                    ->dateTime('M d, Y h:i A'),
                                Infolists\Components\TextEntry::make('progress')
                                    ->label('Progress')
                                    ->getStateUsing(function ($record) {
                                        $totalModules = $record->course->modules()->count();
                                        if ($totalModules === 0) return '0%';

                                        $completedModules = $record->user->moduleCompletions()
                                            ->whereIn('module_id', $record->course->modules()->pluck('id'))
                                            ->count();

                                        return round(($completedModules / $totalModules) * 100) . '%';
                                    })
                                    ->badge()
                                    ->color('info'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->enrollments()->count() > 0),

                Infolists\Components\Section::make('Payment History')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('payments')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('transaction_id')
                                    ->label('Transaction ID')
                                    ->copyable()
                                    ->weight('bold'),
                                Infolists\Components\TextEntry::make('course.title')
                                    ->label('Course')
                                    ->default(fn ($record) => $record->module ? $record->module->title : 'N/A'),
                                Infolists\Components\TextEntry::make('amount')
                                    ->label('Amount')
                                    ->money('LKR'),
                                Infolists\Components\TextEntry::make('payment_method')
                                    ->label('Method')
                                    ->badge()
                                    ->colors([
                                        'primary' => 'payhere',
                                        'success' => 'bank_transfer',
                                    ]),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'warning' => 'pending',
                                        'success' => 'completed',
                                        'danger' => 'failed',
                                    ]),
                                Infolists\Components\TextEntry::make('completed_at')
                                    ->label('Date')
                                    ->dateTime('M d, Y h:i A')
                                    ->default(fn ($record) => $record->created_at->format('M d, Y h:i A')),
                            ])
                            ->columns(6)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->payments()->count() > 0),

                Infolists\Components\Section::make('Bank Transfer Submissions')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('bankTransferPayments')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('reference_number')
                                    ->label('Reference #')
                                    ->copyable()
                                    ->weight('bold'),
                                Infolists\Components\TextEntry::make('course.title')
                                    ->label('Course')
                                    ->default(fn ($record) => $record->module ? $record->module->title : 'N/A'),
                                Infolists\Components\TextEntry::make('amount')
                                    ->label('Amount')
                                    ->money('LKR'),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'warning' => 'pending',
                                        'success' => 'approved',
                                        'danger' => 'rejected',
                                    ]),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Submitted')
                                    ->dateTime('M d, Y h:i A'),
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('approve')
                                        ->label('Approve')
                                        ->icon('heroicon-o-check-circle')
                                        ->color('success')
                                        ->requiresConfirmation()
                                        ->visible(fn ($record) => $record->status === 'pending')
                                        ->action(function ($record) {
                                            $record->update([
                                                'status' => 'approved',
                                                'approved_by' => auth()->id(),
                                                'approved_at' => now(),
                                            ]);

                                            $this->processApproval($record);

                                            Notification::make()
                                                ->title('Payment Approved')
                                                ->success()
                                                ->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('reject')
                                        ->label('Reject')
                                        ->icon('heroicon-o-x-circle')
                                        ->color('danger')
                                        ->requiresConfirmation()
                                        ->visible(fn ($record) => $record->status === 'pending')
                                        ->form([
                                            Forms\Components\Textarea::make('admin_notes')
                                                ->label('Reason for Rejection')
                                                ->required()
                                                ->rows(3),
                                        ])
                                        ->action(function ($record, array $data) {
                                            $record->update([
                                                'status' => 'rejected',
                                                'admin_notes' => $data['admin_notes'],
                                                'approved_by' => auth()->id(),
                                                'approved_at' => now(),
                                            ]);

                                            Notification::make()
                                                ->title('Payment Rejected')
                                                ->danger()
                                                ->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('view_receipt')
                                        ->label('View Receipt')
                                        ->icon('heroicon-o-document-text')
                                        ->color('info')
                                        ->url(fn ($record) => asset('storage/' . $record->receipt_path))
                                        ->openUrlInNewTab(),
                                ])
                                ->alignEnd(),
                            ])
                            ->columns(6)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->bankTransferPayments()->count() > 0),
            ]);
    }

    protected function processApproval(BankTransferPayment $record)
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
}
