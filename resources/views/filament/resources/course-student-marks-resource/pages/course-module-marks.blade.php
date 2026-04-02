<x-filament-panels::page>
    @php
        $tabsData      = $this->getModuleTabsData();
        $modules       = $tabsData['modules'];
        $totalStudents = $tabsData['total_students'];
        $totalModules  = $tabsData['total_modules'];
        $moduleData    = $this->getSelectedModuleData();
    @endphp

    {{-- Summary Bar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="fi-stats-card rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 flex items-center gap-3">
            <div class="flex-shrink-0 rounded-full bg-primary-50 dark:bg-primary-950 p-3">
                <x-heroicon-o-book-open class="w-5 h-5 text-primary-600 dark:text-primary-400" />
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Total Modules</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalModules }}</p>
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
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $this->record->title }}</p>
            </div>
        </div>
    </div>

    {{-- Module Tabs --}}
    @if (count($modules) > 0)
        <div class="mb-4 rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">
            <div class="px-4 pt-4">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Select Module</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 pb-4">
                    @foreach ($modules as $tab)
                        @php
                            $isActive = $this->selectedModuleId === $tab['id'];
                            $pct = $tab['total_enrolled'] > 0
                                ? round(($tab['completed_count'] / $tab['total_enrolled']) * 100)
                                : 0;
                        @endphp
                        <button
                            wire:click="selectModule({{ $tab['id'] }})"
                            class="flex flex-col items-start w-full rounded-lg border px-3 py-2.5 text-left transition-all
                                {{ $isActive
                                    ? 'border-primary-500 bg-primary-50 dark:bg-primary-950/50 shadow-sm'
                                    : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary-300 hover:bg-primary-50/50 dark:hover:bg-primary-950/30' }}"
                        >
                            <div class="flex items-center gap-2 w-full">
                                <span class="inline-flex items-center justify-center w-5 h-5 shrink-0 rounded-full text-xs font-bold
                                    {{ $isActive
                                        ? 'bg-primary-600 text-white'
                                        : 'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300' }}">
                                    {{ $tab['order'] }}
                                </span>
                                <span class="text-sm font-medium leading-tight
                                    {{ $isActive ? 'text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ Str::limit($tab['title'], 22) }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center gap-2 w-full">
                                <div class="flex-1 h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-full rounded-full transition-all
                                        {{ $pct === 100 ? 'bg-success-500' : ($pct > 0 ? 'bg-warning-500' : 'bg-gray-300 dark:bg-gray-600') }}"
                                        style="width: {{ $pct }}%">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0">{{ $pct }}%</span>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Selected Module Content --}}
    @if ($moduleData)
        @php $mod = $moduleData['module']; @endphp

        <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">

            {{-- Module Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 text-sm font-bold">
                        {{ $mod->order }}
                    </span>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $mod->title }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Module {{ $mod->order }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium
                    {{ $moduleData['completed_count'] === $moduleData['total_enrolled'] && $moduleData['total_enrolled'] > 0
                        ? 'bg-success-100 text-success-700 dark:bg-success-950 dark:text-success-300'
                        : 'bg-warning-100 text-warning-700 dark:bg-warning-950 dark:text-warning-300' }}">
                    <x-heroicon-o-check-circle class="w-3.5 h-3.5" />
                    {{ $moduleData['completed_count'] }} / {{ $moduleData['total_enrolled'] }} Completed
                </span>
            </div>

            {{-- Search & Filter Bar --}}
            <div class="flex flex-wrap items-center gap-3 px-6 py-3 border-b border-gray-100 dark:border-gray-800">

                {{-- Search --}}
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search students..."
                    style="width: 16rem;"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                />

                {{-- Status Filter --}}
                <select
                    wire:model.live="statusFilter"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 py-2 pl-3 pr-8 text-sm text-gray-700 dark:text-gray-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 cursor-pointer"
                >
                    <option value="all">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="in_progress">In Progress</option>
                    <option value="not_started">Not Started</option>
                </select>

                {{-- Result count --}}
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $moduleData['total'] }} student{{ $moduleData['total'] !== 1 ? 's' : '' }}
                    @if ($this->search || $this->statusFilter !== 'all')
                        <span class="text-primary-600 dark:text-primary-400">(filtered)</span>
                    @endif
                </span>

                {{-- Export Button --}}
                <div class="ml-auto">
                    <button
                        wire:click="exportExcel"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-success-300 dark:border-success-700 bg-success-50 dark:bg-success-950/40 px-3 py-2 text-xs font-medium text-success-700 dark:text-success-300 hover:bg-success-100 dark:hover:bg-success-950/70 transition-colors disabled:opacity-60"
                    >
                        <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                        <span wire:loading.remove wire:target="exportExcel">Export Excel</span>
                        <span wire:loading wire:target="exportExcel">Exporting…</span>
                    </button>
                </div>
            </div>

            {{-- Students Table --}}
            @if (count($moduleData['students']) > 0)
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
                            @foreach ($moduleData['students'] as $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $student['name'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student['email'] }}</div>
                                    </td>
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
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['attempts'] > 0)
                                            <span class="inline-flex items-center justify-center rounded-full bg-primary-100 dark:bg-primary-950 px-2.5 py-0.5 text-xs font-medium text-primary-700 dark:text-primary-300">
                                                {{ $student['attempts'] }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
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
                                    <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $student['completed_at'] ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['attempts'] > 0)
                                            <button
                                                wire:click="deleteAttempts({{ $moduleData['module']->id }}, {{ $student['id'] }})"
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

                {{-- Pagination --}}
                @if ($moduleData['last_page'] > 1)
                    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-3 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Showing {{ (($moduleData['current_page'] - 1) * $moduleData['per_page']) + 1 }}–{{ min($moduleData['current_page'] * $moduleData['per_page'], $moduleData['total']) }}
                            of {{ $moduleData['total'] }} students
                        </p>
                        <div class="flex items-center gap-1">
                            <button
                                wire:click="$set('page', {{ max(1, $moduleData['current_page'] - 1) }})"
                                @disabled($moduleData['current_page'] === 1)
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm border border-gray-200 dark:border-gray-700
                                    {{ $moduleData['current_page'] === 1
                                        ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed'
                                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
                            >
                                <x-heroicon-o-chevron-left class="w-4 h-4" />
                            </button>

                            @php
                                $start = max(1, $moduleData['current_page'] - 2);
                                $end   = min($moduleData['last_page'], $moduleData['current_page'] + 2);
                            @endphp
                            @if ($start > 1)
                                <button wire:click="$set('page', 1)" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">1</button>
                                @if ($start > 2)<span class="px-1 text-gray-400">…</span>@endif
                            @endif
                            @for ($p = $start; $p <= $end; $p++)
                                <button
                                    wire:click="$set('page', {{ $p }})"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm border
                                        {{ $p === $moduleData['current_page']
                                            ? 'border-primary-500 bg-primary-50 dark:bg-primary-950/50 text-primary-700 dark:text-primary-300 font-semibold'
                                            : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
                                >{{ $p }}</button>
                            @endfor
                            @if ($end < $moduleData['last_page'])
                                @if ($end < $moduleData['last_page'] - 1)<span class="px-1 text-gray-400">…</span>@endif
                                <button wire:click="$set('page', {{ $moduleData['last_page'] }})" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">{{ $moduleData['last_page'] }}</button>
                            @endif

                            <button
                                wire:click="$set('page', {{ min($moduleData['last_page'], $moduleData['current_page'] + 1) }})"
                                @disabled($moduleData['current_page'] === $moduleData['last_page'])
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm border border-gray-200 dark:border-gray-700
                                    {{ $moduleData['current_page'] === $moduleData['last_page']
                                        ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed'
                                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
                            >
                                <x-heroicon-o-chevron-right class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                @endif

            @else
                <div class="px-6 py-10 text-center">
                    <x-heroicon-o-magnifying-glass class="mx-auto w-8 h-8 text-gray-300 dark:text-gray-600 mb-2" />
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        @if ($this->search || $this->statusFilter !== 'all')
                            No students match your search or filter.
                        @else
                            No students enrolled in this course yet.
                        @endif
                    </p>
                    @if ($this->search || $this->statusFilter !== 'all')
                        <button
                            wire:click="$set('search', ''); $set('statusFilter', 'all')"
                            class="mt-2 text-xs text-primary-600 dark:text-primary-400 hover:underline"
                        >Clear filters</button>
                    @endif
                </div>
            @endif
        </div>

    @elseif (count($modules) === 0)
        <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 px-6 py-12 text-center">
            <x-heroicon-o-book-open class="mx-auto w-10 h-10 text-gray-300 dark:text-gray-600 mb-3" />
            <p class="text-sm text-gray-500 dark:text-gray-400">No modules found for this course.</p>
        </div>
    @endif
</x-filament-panels::page>
