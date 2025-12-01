<div class="space-y-4">
    <div class="grid grid-cols-1 gap-4">
        @forelse($course->modules->sortBy('order') as $module)
            @php
                $isUnlocked = $student->moduleUnlocks()->where('module_id', $module->id)->exists();
                $isCompleted = $student->hasCompletedModule($module->id);
                $quizAttempts = $student->quizAttempts()->where('module_id', $module->id)->get();
                $bestScore = $quizAttempts->max('score');
                $attemptCount = $quizAttempts->count();
            @endphp

            <div class="border rounded-lg p-4 {{ $isCompleted ? 'bg-green-50 border-green-300' : ($isUnlocked ? 'bg-blue-50 border-blue-300' : 'bg-gray-50 border-gray-300') }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <h4 class="font-semibold text-gray-900">
                                Module {{ $module->order }}: {{ $module->title }}
                            </h4>

                            @if($isCompleted)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Completed
                                </span>
                            @elseif($isUnlocked)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                    </svg>
                                    In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Locked
                                </span>
                            @endif
                        </div>

                        @if($module->description)
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($module->description, 100) }}</p>
                        @endif

                        @if($isUnlocked)
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="bg-white rounded-md p-3 border">
                                    <div class="text-xs text-gray-500 mb-1">Quiz Attempts</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $attemptCount }}</div>
                                </div>

                                <div class="bg-white rounded-md p-3 border">
                                    <div class="text-xs text-gray-500 mb-1">Best Score</div>
                                    <div class="text-lg font-semibold {{ $bestScore >= 80 ? 'text-green-600' : ($bestScore >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $bestScore ? number_format($bestScore, 1) . '%' : 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            @if($quizAttempts->isNotEmpty())
                                <div class="mt-3">
                                    <details class="text-sm">
                                        <summary class="cursor-pointer text-gray-600 hover:text-gray-900 font-medium">
                                            View Quiz History ({{ $attemptCount }} attempts)
                                        </summary>
                                        <div class="mt-2 space-y-2">
                                            @foreach($quizAttempts->sortByDesc('completed_at')->take(5) as $attempt)
                                                <div class="flex items-center justify-between bg-white rounded p-2 text-xs border">
                                                    <span class="text-gray-600">
                                                        {{ $attempt->completed_at->format('M d, Y h:i A') }}
                                                    </span>
                                                    <span class="font-semibold {{ $attempt->score >= 80 ? 'text-green-600' : ($attempt->score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                                        {{ number_format($attempt->score, 1) }}%
                                                        ({{ $attempt->correct_answers }}/{{ $attempt->total_questions }})
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </details>
                                </div>
                            @endif

                            @if($isCompleted)
                                @php
                                    $completion = $student->moduleCompletions()->where('module_id', $module->id)->first();
                                @endphp
                                <div class="mt-3 text-xs text-gray-600">
                                    <strong>Completed on:</strong> {{ $completion->completed_at->format('M d, Y h:i A') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No modules found for this course.
            </div>
        @endforelse
    </div>
</div>
