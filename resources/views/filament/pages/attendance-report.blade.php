<x-filament-panels::page>

    {{-- Module selector --}}
    <x-filament::section>
        <x-slot name="heading">Filter by Module</x-slot>
        {{ $this->filterForm }}
    </x-filament::section>

    {{-- Summary stats (only when a module is selected) --}}
    @if($this->selectedModuleId)
    @php
        $mid           = (int) $this->selectedModuleId;
        $mod           = \App\Models\Module::with('course')->find($mid);
        $totalOnline   = \App\Models\ModuleMeeting::where('module_id', $mid)->where('class_type','online')->where('is_active',true)->count();
        $totalPhysical = \App\Models\ModuleMeeting::where('module_id', $mid)->where('class_type','physical')->where('is_active',true)->count();
        $totalSessions = $totalOnline + $totalPhysical;
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-200 flex items-center justify-center flex-shrink-0">
                <x-heroicon-o-video-camera class="w-6 h-6 text-blue-700"/>
            </div>
            <div>
                <p class="text-2xl font-black text-blue-700">{{ $totalOnline }}</p>
                <p class="text-xs font-bold text-blue-500 uppercase tracking-wide">Online Sessions</p>
            </div>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-200 flex items-center justify-center flex-shrink-0">
                <x-heroicon-o-building-office class="w-6 h-6 text-amber-700"/>
            </div>
            <div>
                <p class="text-2xl font-black text-amber-700">{{ $totalPhysical }}</p>
                <p class="text-xs font-bold text-amber-500 uppercase tracking-wide">Physical Classes</p>
            </div>
        </div>

        <div class="rounded-2xl border border-yellow-300 bg-yellow-50 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-200 flex items-center justify-center flex-shrink-0">
                <x-heroicon-o-academic-cap class="w-6 h-6 text-yellow-700"/>
            </div>
            <div>
                <p class="text-2xl font-black text-yellow-700">{{ $totalSessions }}</p>
                <p class="text-xs font-bold text-yellow-600 uppercase tracking-wide">Total Sessions</p>
            </div>
        </div>

    </div>

    <x-filament::section>
        <x-slot name="heading">
            Student Attendance — {{ $mod?->course?->title }} &rsaquo; {{ $mod?->title }}
        </x-slot>
        <x-slot name="description">
            Percentage = (Online attended + Physical attended) ÷ {{ $totalSessions }} total sessions × 100
        </x-slot>

        {{ $this->table }}
    </x-filament::section>

    @else
    {{-- Empty state before module is chosen --}}
    <x-filament::section>
        {{ $this->table }}
    </x-filament::section>
    @endif

</x-filament-panels::page>
