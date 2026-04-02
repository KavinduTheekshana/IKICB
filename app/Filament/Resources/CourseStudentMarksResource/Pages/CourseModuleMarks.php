<?php

namespace App\Filament\Resources\CourseStudentMarksResource\Pages;

use App\Filament\Resources\CourseStudentMarksResource;
use App\Models\Enrollment;
use App\Models\ModuleCompletion;
use App\Models\QuizAttempt;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class CourseModuleMarks extends Page
{
    use InteractsWithRecord;

    protected static string $resource = CourseStudentMarksResource::class;

    protected static string $view = 'filament.resources.course-student-marks-resource.pages.course-module-marks';

    public ?int $selectedModuleId = null;
    public string $search = '';
    public string $statusFilter = 'all';
    public int $page = 1;
    public int $perPage = 20;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $firstModule = $this->record->modules()->orderBy('order')->first();
        $this->selectedModuleId = $firstModule?->id;
    }

    public function getTitle(): string
    {
        return 'Student Marks: ' . $this->record->title;
    }

    public function selectModule(int $moduleId): void
    {
        $this->selectedModuleId = $moduleId;
        $this->page = 1;
        $this->search = '';
        $this->statusFilter = 'all';
    }

    public function updatedSearch(): void
    {
        $this->page = 1;
    }

    public function updatedStatusFilter(): void
    {
        $this->page = 1;
    }

    public function getModuleTabsData(): array
    {
        $modules = $this->record->modules()->orderBy('order')->get();
        $enrolledUserIds = Enrollment::where('course_id', $this->record->id)->pluck('user_id');
        $totalEnrolled = $enrolledUserIds->count();

        $moduleIds = $modules->pluck('id');
        $completionCounts = ModuleCompletion::whereIn('module_id', $moduleIds)
            ->whereIn('user_id', $enrolledUserIds)
            ->selectRaw('module_id, COUNT(*) as count')
            ->groupBy('module_id')
            ->pluck('count', 'module_id');

        return [
            'modules' => $modules->map(fn ($m) => [
                'id'              => $m->id,
                'title'           => $m->title,
                'order'           => $m->order,
                'completed_count' => $completionCounts[$m->id] ?? 0,
                'total_enrolled'  => $totalEnrolled,
            ])->toArray(),
            'total_students' => $totalEnrolled,
            'total_modules'  => $modules->count(),
        ];
    }

    public function getSelectedModuleData(): ?array
    {
        if (! $this->selectedModuleId) {
            return null;
        }

        $module = $this->record->modules()->find($this->selectedModuleId);
        if (! $module) {
            return null;
        }

        $enrolledUserIds = Enrollment::where('course_id', $this->record->id)->pluck('user_id');

        $userQuery = \App\Models\User::whereIn('id', $enrolledUserIds)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name');

        $allStudents = $userQuery->get();
        $studentIds  = $allStudents->pluck('id');

        $allAttempts = QuizAttempt::where('module_id', $module->id)
            ->whereIn('user_id', $studentIds)
            ->get()
            ->groupBy('user_id');

        $allCompletions = ModuleCompletion::where('module_id', $module->id)
            ->whereIn('user_id', $studentIds)
            ->get()
            ->groupBy('user_id');

        $studentData = $allStudents->map(function ($student) use ($allAttempts, $allCompletions) {
            $attempts    = $allAttempts[$student->id] ?? collect();
            $completion  = ($allCompletions[$student->id] ?? collect())->first();
            $bestScore   = $attempts->max('score');
            $avgScore    = $attempts->avg('score');
            $attemptCount = $attempts->count();
            $isCompleted  = (bool) $completion;
            $status = $isCompleted ? 'completed' : ($attemptCount > 0 ? 'in_progress' : 'not_started');

            return [
                'id'           => $student->id,
                'name'         => $student->name,
                'email'        => $student->email,
                'status'       => $status,
                'completed'    => $isCompleted,
                'attempts'     => $attemptCount,
                'best_score'   => $bestScore !== null ? number_format($bestScore, 1) . '%' : null,
                'avg_score'    => $avgScore !== null ? number_format($avgScore, 1) . '%' : null,
                'completed_at' => $completion?->completed_at?->format('M d, Y'),
            ];
        });

        if ($this->statusFilter !== 'all') {
            $studentData = $studentData->filter(fn ($s) => $s['status'] === $this->statusFilter);
        }

        $studentData = $studentData->sortBy([
            fn ($a, $b) => $b['completed'] <=> $a['completed'],
            fn ($a, $b) => floatval($b['best_score']) <=> floatval($a['best_score']),
        ])->values();

        $total    = $studentData->count();
        $lastPage = max(1, (int) ceil($total / $this->perPage));
        $students = $studentData->slice(($this->page - 1) * $this->perPage, $this->perPage)->values();

        $completedCount = ModuleCompletion::where('module_id', $module->id)
            ->whereIn('user_id', $enrolledUserIds)
            ->count();

        return [
            'module'          => $module,
            'students'        => $students->toArray(),
            'total'           => $total,
            'total_enrolled'  => $enrolledUserIds->count(),
            'completed_count' => $completedCount,
            'current_page'    => $this->page,
            'last_page'       => $lastPage,
            'per_page'        => $this->perPage,
        ];
    }

    public function exportExcel(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (! $this->selectedModuleId) {
            Notification::make()->title('No module selected')->warning()->send();
        }

        $module = $this->record->modules()->find($this->selectedModuleId);

        $enrolledUserIds = Enrollment::where('course_id', $this->record->id)->pluck('user_id');

        $userQuery = \App\Models\User::whereIn('id', $enrolledUserIds)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name');

        $allStudents = $userQuery->get();
        $studentIds  = $allStudents->pluck('id');

        $allAttempts = QuizAttempt::where('module_id', $module->id)
            ->whereIn('user_id', $studentIds)
            ->get()
            ->groupBy('user_id');

        $allCompletions = ModuleCompletion::where('module_id', $module->id)
            ->whereIn('user_id', $studentIds)
            ->get()
            ->groupBy('user_id');

        $studentData = $allStudents->map(function ($student) use ($allAttempts, $allCompletions) {
            $attempts    = $allAttempts[$student->id] ?? collect();
            $completion  = ($allCompletions[$student->id] ?? collect())->first();
            $bestScore   = $attempts->max('score');
            $avgScore    = $attempts->avg('score');
            $attemptCount = $attempts->count();
            $isCompleted  = (bool) $completion;
            $status = $isCompleted ? 'Completed' : ($attemptCount > 0 ? 'In Progress' : 'Not Started');

            return [
                $student->name,
                $student->email,
                $status,
                $attemptCount,
                $bestScore !== null ? number_format($bestScore, 1) . '%' : '',
                $avgScore !== null ? number_format($avgScore, 1) . '%' : '',
                $completion?->completed_at?->format('Y-m-d H:i') ?? '',
            ];
        });

        if ($this->statusFilter !== 'all') {
            $statusMap = ['completed' => 'Completed', 'in_progress' => 'In Progress', 'not_started' => 'Not Started'];
            $label = $statusMap[$this->statusFilter] ?? '';
            $studentData = $studentData->filter(fn ($row) => $row[2] === $label);
        }

        $courseName = $this->record->title;
        $moduleName = $module->title;
        $filename   = 'marks_' . \Str::slug($courseName) . '_' . \Str::slug($moduleName) . '.csv';

        $rows = $studentData->values()->toArray();
        array_unshift($rows, ['Student Name', 'Email', 'Status', 'Attempts', 'Best Score', 'Avg Score', 'Completed On']);
        array_unshift($rows, ["Course: {$courseName}", '', '', '', '', '', '']);
        array_unshift($rows, ["Module: {$moduleName}", '', '', '', '', '', '']);

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function deleteAttempts(int $moduleId, int $userId): void
    {
        $deleted = QuizAttempt::where('module_id', $moduleId)
            ->where('user_id', $userId)
            ->delete();

        if ($deleted) {
            Notification::make()
                ->title('Attempts deleted')
                ->body('The student\'s quiz attempts have been deleted. They can now attempt the quiz again.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('No attempts found')
                ->warning()
                ->send();
        }
    }
}
