<?php

namespace App\Filament\Branch\Pages;

use App\Models\MeetingAttendance;
use App\Models\Module;
use App\Models\ModuleMeeting;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendanceReport extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon    = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel   = 'Attendance Report';
    protected static ?string $navigationGroup   = 'Student Management';
    protected static ?int    $navigationSort    = 6;
    protected static string  $view              = 'filament.pages.attendance-report';
    protected static ?string $title             = 'Student Attendance Report';

    public ?string $selectedModuleId = null;

    protected function getForms(): array
    {
        return ['filterForm'];
    }

    public function filterForm(Form $form): Form
    {
        $branchId = auth()->user()->branch_id;

        // Only show modules from courses that have this branch's students enrolled
        $moduleOptions = Module::with('course')
            ->whereHas('course.enrollments.user', fn ($q) => $q->where('branch_id', $branchId))
            ->get()
            ->mapWithKeys(fn ($m) => [
                $m->id => ($m->course->title ?? 'Unknown Course') . '  —  ' . $m->title,
            ]);

        return $form
            ->schema([
                Select::make('selectedModuleId')
                    ->label('Select Module')
                    ->options($moduleOptions)
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function (?string $state): void {
                        $this->selectedModuleId = $state;
                        $this->resetTable();
                    })
                    ->placeholder('Choose a module to view attendance breakdown')
                    ->columnSpanFull(),
            ])
            ->statePath('');
    }

    public function table(Table $table): Table
    {
        $moduleId      = $this->selectedModuleId ? (int) $this->selectedModuleId : null;
        $branchId      = auth()->user()->branch_id;

        $totalOnline   = $moduleId ? ModuleMeeting::where('module_id', $moduleId)->where('class_type', 'online')->where('is_active', true)->count() : 0;
        $totalPhysical = $moduleId ? ModuleMeeting::where('module_id', $moduleId)->where('class_type', 'physical')->where('is_active', true)->count() : 0;
        $totalSessions = $totalOnline + $totalPhysical;

        return $table
            ->query($this->studentsQuery())
            ->columns([
                TextColumn::make('name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('online_attended')
                    ->label("Online  / {$totalOnline}")
                    ->getStateUsing(function (User $record) use ($moduleId): int|string {
                        if (!$moduleId) return '-';
                        return MeetingAttendance::where('user_id', $record->id)
                            ->whereHas('meeting', fn ($q) => $q->where('module_id', $moduleId)->where('class_type', 'online'))
                            ->count();
                    })
                    ->badge()
                    ->color('info'),

                TextColumn::make('physical_attended')
                    ->label("Physical  / {$totalPhysical}")
                    ->getStateUsing(function (User $record) use ($moduleId): int|string {
                        if (!$moduleId) return '-';
                        return MeetingAttendance::where('user_id', $record->id)
                            ->whereHas('meeting', fn ($q) => $q->where('module_id', $moduleId)->where('class_type', 'physical'))
                            ->count();
                    })
                    ->badge()
                    ->color('warning'),

                TextColumn::make('total_attended')
                    ->label("Total  / {$totalSessions}")
                    ->getStateUsing(function (User $record) use ($moduleId): int|string {
                        if (!$moduleId) return '-';
                        return MeetingAttendance::where('user_id', $record->id)
                            ->whereHas('meeting', fn ($q) => $q->where('module_id', $moduleId))
                            ->count();
                    })
                    ->badge()
                    ->color('success'),

                TextColumn::make('attendance_pct')
                    ->label('Attendance %')
                    ->getStateUsing(function (User $record) use ($moduleId, $totalSessions): string {
                        if (!$moduleId || $totalSessions === 0) return '—';
                        $attended = MeetingAttendance::where('user_id', $record->id)
                            ->whereHas('meeting', fn ($q) => $q->where('module_id', $moduleId))
                            ->count();
                        return round(($attended / $totalSessions) * 100) . '%';
                    })
                    ->badge()
                    ->color(function (User $record) use ($moduleId, $totalSessions): string {
                        if (!$moduleId || $totalSessions === 0) return 'gray';
                        $attended = MeetingAttendance::where('user_id', $record->id)
                            ->whereHas('meeting', fn ($q) => $q->where('module_id', $moduleId))
                            ->count();
                        $pct = ($attended / $totalSessions) * 100;
                        return $pct >= 75 ? 'success' : ($pct >= 50 ? 'warning' : 'danger');
                    }),
            ])
            ->emptyStateHeading($moduleId ? 'No enrolled students found' : 'Select a module above')
            ->emptyStateDescription($moduleId ? 'No branch students are enrolled in this module.' : 'Choose a module to see attendance percentages.')
            ->emptyStateIcon('heroicon-o-academic-cap')
            ->paginated([25, 50, 100]);
    }

    private function studentsQuery(): Builder
    {
        if (!$this->selectedModuleId) {
            return User::query()->whereRaw('1 = 0');
        }

        $moduleId = (int) $this->selectedModuleId;
        $branchId = auth()->user()->branch_id;
        $module   = Module::find($moduleId);

        if (!$module) {
            return User::query()->whereRaw('1 = 0');
        }

        return User::query()
            ->where('role', 'student')
            ->where('branch_id', $branchId)
            ->where(function ($q) use ($module, $moduleId) {
                $q->whereHas('enrollments', fn ($q2) => $q2
                    ->where('course_id', $module->course_id)
                    ->where('status', 'active'))
                  ->orWhereHas('moduleUnlocks', fn ($q2) => $q2
                    ->where('module_id', $moduleId));
            })
            ->orderBy('name');
    }
}
