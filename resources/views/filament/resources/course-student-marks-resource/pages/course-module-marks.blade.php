<x-filament-panels::page>
    @php
        $data = $this->getModuleMarksData();
        $modules = $data['modules'];
        $totalStudents = $data['total_students'];
    @endphp

    {{-- Summary Bar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="fi-stats-card rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 flex items-center gap-3">
            <div class="flex-shrink-0 rounded-full bg-primary-50 dark:bg-primary-950 p-3">
                <x-heroicon-o-book-open class="w-5 h-5 text-primary-600 dark:text-primary-400" />
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Total Modules</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ count($modules) }}</p>
            </div>
        </div>
        <div class="fi-stats-card rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 flex items-center gap-3">
            <div class="flex-shrink-0 rounded-full bg-success-50 dark:bg-success-950 p-3">
                <x-heroicon-o-academic-cap class="w-5 h-5 text-success-600 dark:text-success-400" />
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Enrolled Students</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="fi-stats-card rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 flex items-center gap-3">
            <div class="flex-shrink-0 rounded-full bg-info-50 dark:bg-info-950 p-3">
                <x-heroicon-o-chart-bar class="w-5 h-5 text-info-600 dark:text-info-400" />
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Course</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $data['course']->title }}</p>
            </div>
        </div>
    </div>

    {{-- Module Sections --}}
    @forelse ($modules as $module)
        <div class="mb-6 rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">

            {{-- Module Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 text-sm font-bold">
                        {{ $module['order'] }}
                    </span>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $module['title'] }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Module {{ $module['order'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Completion badge --}}
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium
                        {{ $module['completed_count'] === $module['total_enrolled'] && $module['total_enrolled'] > 0
                            ? 'bg-success-100 text-success-700 dark:bg-success-950 dark:text-success-300'
                            : 'bg-warning-100 text-warning-700 dark:bg-warning-950 dark:text-warning-300' }}">
                        <x-heroicon-o-check-circle class="w-3.5 h-3.5" />
                        {{ $module['completed_count'] }} / {{ $module['total_enrolled'] }} Completed
                    </span>
                </div>
            </div>

            {{-- Students Table --}}
            @if (count($module['students']) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Student</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Attempts</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Best Score</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg Score</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed On</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach ($module['students'] as $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    {{-- Student --}}
                                    <td class="px-6 py-3">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $student['name'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student['email'] }}</div>
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-4 py-3">
                                        @if ($student['completed'])
                                            <span class="inline-flex items-center gap-1 rounded-full bg-success-100 dark:bg-success-950 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:text-success-300">
                                                <x-heroicon-o-check-circle class="w-3.5 h-3.5" /> Completed
                                            </span>
                                        @elseif ($student['attempts'] > 0)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-warning-100 dark:bg-warning-950 px-2.5 py-0.5 text-xs font-medium text-warning-700 dark:text-warning-300">
                                                <x-heroicon-o-clock class="w-3.5 h-3.5" /> In Progress
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:text-gray-400">
                                                <x-heroicon-o-lock-closed class="w-3.5 h-3.5" /> Not Started
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Attempts --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['attempts'] > 0)
                                            <span class="inline-flex items-center justify-center rounded-full bg-primary-100 dark:bg-primary-950 px-2.5 py-0.5 text-xs font-medium text-primary-700 dark:text-primary-300">
                                                {{ $student['attempts'] }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    {{-- Best Score --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['best_score'])
                                            @php $score = floatval($student['best_score']); @endphp
                                            <span class="inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                                {{ $score >= 80 ? 'bg-success-100 text-success-700 dark:bg-success-950 dark:text-success-300'
                                                    : ($score >= 60 ? 'bg-warning-100 text-warning-700 dark:bg-warning-950 dark:text-warning-300'
                                                    : 'bg-danger-100 text-danger-700 dark:bg-danger-950 dark:text-danger-300') }}">
                                                {{ $student['best_score'] }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    {{-- Avg Score --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['avg_score'])
                                            @php $avg = floatval($student['avg_score']); @endphp
                                            <span class="inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                {{ $avg >= 80 ? 'bg-success-50 text-success-600 dark:bg-success-950/50 dark:text-success-400'
                                                    : ($avg >= 60 ? 'bg-warning-50 text-warning-600 dark:bg-warning-950/50 dark:text-warning-400'
                                                    : 'bg-danger-50 text-danger-600 dark:bg-danger-950/50 dark:text-danger-400') }}">
                                                {{ $student['avg_score'] }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    {{-- Completed On --}}
                                    <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $student['completed_at'] ?? '—' }}
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['attempts'] > 0)
                                            <button
                                                wire:click="deleteAttempts({{ $module['id'] }}, {{ $student['id'] }})"
                                                wire:confirm="Are you sure you want to delete all attempts for {{ $student['name'] }}? This will allow them to attempt the quiz again."
                                                class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-danger-600 dark:text-danger-400 hover:bg-danger-50 dark:hover:bg-danger-950/50 transition-colors"
                                            >
                                                <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                                Delete Attempt
                                            </button>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                    No students enrolled in this course yet.
                </div>
            @endif
        </div>
    @empty
        <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 px-6 py-12 text-center">
            <x-heroicon-o-book-open class="mx-auto w-10 h-10 text-gray-300 dark:text-gray-600 mb-3" />
            <p class="text-sm text-gray-500 dark:text-gray-400">No modules found for this course.</p>
        </div>
    @endforelse
</x-filament-panels::page>
