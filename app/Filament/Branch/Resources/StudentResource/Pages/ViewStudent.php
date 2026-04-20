<?php

namespace App\Filament\Branch\Resources\StudentResource\Pages;

use App\Filament\Branch\Resources\StudentResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ModuleUnlock;
use App\Models\Payment;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('add_enrollment')
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
                        'user_id'   => $this->record->id,
                        'course_id' => $data['course_id'],
                    ], [
                        'enrolled_at' => now(),
                    ]);

                    if ($enrollment->wasRecentlyCreated) {
                        Notification::make()->title('Enrollment Added')->success()->send();
                    } else {
                        Notification::make()->title('Student Already Enrolled')->warning()->send();
                    }
                }),
            Action::make('view_progress')
                ->label('View Progress')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->url(fn () => StudentResource::getUrl('progress', ['record' => $this->record])),
            Actions\EditAction::make(),
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
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'success' => 'active',
                                        'info'    => 'completed',
                                        'danger'  => 'cancelled',
                                    ]),
                                Infolists\Components\TextEntry::make('enrolled_at')
                                    ->label('Enrolled Date')
                                    ->dateTime('M d, Y h:i A')
                                    ->placeholder('N/A'),
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
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('activate')
                                        ->label('Activate')
                                        ->icon('heroicon-o-check-circle')
                                        ->color('success')
                                        ->visible(fn ($record) => $record->status !== 'active')
                                        ->requiresConfirmation()
                                        ->action(function ($record) {
                                            $record->update(['status' => 'active']);
                                            Notification::make()->title('Enrollment Activated')->success()->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('deactivate')
                                        ->label('Cancel')
                                        ->icon('heroicon-o-x-circle')
                                        ->color('danger')
                                        ->visible(fn ($record) => $record->status === 'active')
                                        ->requiresConfirmation()
                                        ->action(function ($record) {
                                            $record->update(['status' => 'cancelled']);
                                            Notification::make()->title('Enrollment Cancelled')->warning()->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('complete')
                                        ->label('Mark Complete')
                                        ->icon('heroicon-o-academic-cap')
                                        ->color('info')
                                        ->visible(fn ($record) => $record->status === 'active')
                                        ->requiresConfirmation()
                                        ->action(function ($record) {
                                            $record->update(['status' => 'completed']);
                                            Notification::make()->title('Enrollment Marked as Completed')->success()->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('delete')
                                        ->label('Remove')
                                        ->icon('heroicon-o-trash')
                                        ->color('danger')
                                        ->requiresConfirmation()
                                        ->modalHeading('Remove Enrollment')
                                        ->modalDescription('Are you sure you want to remove this enrollment?')
                                        ->action(function ($record) {
                                            $record->delete();
                                            Notification::make()->title('Enrollment Removed')->success()->send();
                                        }),
                                ])->alignEnd(),
                            ])
                            ->columns(5)
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
                                    ->weight('bold')
                                    ->columnSpan(2),
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
                                        'info'    => 'bank_transfer',
                                        'success' => 'cash',
                                        'primary' => 'webxpay',
                                    ]),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'warning' => 'pending',
                                        'success' => 'completed',
                                        'danger'  => 'failed',
                                    ]),
                                Infolists\Components\TextEntry::make('completed_at')
                                    ->label('Date')
                                    ->dateTime('M d, Y h:i A')
                                    ->placeholder(fn ($record) => $record->created_at->format('M d, Y h:i A')),
                                Infolists\Components\Actions::make([
                                    Infolists\Components\Actions\Action::make('approve')
                                        ->label('Approve')
                                        ->icon('heroicon-o-check-circle')
                                        ->color('success')
                                        ->requiresConfirmation()
                                        ->visible(fn ($record) => $record->payment_method === 'bank_transfer' && $record->status === 'pending')
                                        ->action(function ($record) {
                                            $this->processPaymentApproval($record);
                                            Notification::make()->title('Payment Approved')->success()->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('reject')
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
                                                'status'      => 'failed',
                                                'admin_notes' => $data['admin_notes'],
                                                'approved_by' => auth()->id(),
                                                'approved_at' => now(),
                                            ]);
                                            Notification::make()->title('Payment Rejected')->danger()->send();
                                        }),
                                    Infolists\Components\Actions\Action::make('view_receipt')
                                        ->label('View Receipt')
                                        ->icon('heroicon-o-document-text')
                                        ->color('info')
                                        ->visible(fn ($record) => $record->payment_method === 'bank_transfer' && $record->receipt_path)
                                        ->url(fn ($record) => asset('storage/' . $record->receipt_path))
                                        ->openUrlInNewTab(),
                                ])->alignEnd(),
                            ])
                            ->columns(8)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->payments()->count() > 0),
            ]);
    }

    protected function processPaymentApproval(Payment $payment): void
    {
        $payment->update([
            'status'       => 'completed',
            'approved_by'  => auth()->id(),
            'approved_at'  => now(),
            'completed_at' => now(),
        ]);

        $payment->refresh();
        $payment->load('course.modules', 'module');

        if ($payment->module_id) {
            ModuleUnlock::firstOrCreate(
                ['user_id' => $payment->user_id, 'module_id' => $payment->module_id],
                ['payment_id' => $payment->id, 'unlocked_at' => now()]
            );

            if ($payment->course_id) {
                Enrollment::firstOrCreate(
                    ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                    ['purchase_type' => 'module_wise', 'enrolled_at' => now()]
                );
            }
        } elseif ($payment->course_id && $payment->course) {
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
}
