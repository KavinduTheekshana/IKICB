@extends('layouts.guest')

@section('title', $module->title . ' - ' . $module->course->title)

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-yellow-50 min-h-screen">
    <!-- Breadcrumb Header -->
    <div class="bg-gradient-to-r from-gray-900 to-black py-6 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="mb-2">
                <ol class="flex items-center space-x-3 text-sm">
                    <li>
                        <a href="{{ route('courses.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">
                            Courses
                        </a>
                    </li>
                    <li><span class="text-gray-500">/</span></li>
                    <li>
                        <a href="{{ route('courses.show', $module->course) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">
                            {{ $module->course->title }}
                        </a>
                    </li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><span class="text-gray-300 font-semibold">{{ $module->title }}</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-300 rounded-2xl p-4 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-green-800 font-bold text-lg">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Module Header with Completion Status -->
                <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-8">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-4xl font-black text-gray-900 mb-3">{{ $module->title }}</h1>
                            <p class="text-lg text-gray-600">{{ $module->description }}</p>
                        </div>
                        @if($isCompleted)
                            <span class="inline-flex items-center px-5 py-3 rounded-2xl text-sm font-black bg-green-100 text-green-800 border-2 border-green-300 shadow-lg">
                                <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Completed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Video Lessons (multiple, with expiry support) -->
                @if($module->activeVideos->count() > 0)
                    @foreach($module->activeVideos as $moduleVideo)
                        <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4 flex items-center justify-between">
                                <h2 class="text-2xl font-black text-gray-900 flex items-center">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $moduleVideo->title }}
                                </h2>
                                @if($moduleVideo->expires_at)
                                    <span class="text-xs font-semibold bg-white/30 text-gray-900 px-3 py-1 rounded-full">
                                        Expires {{ $moduleVideo->expires_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                            @if($moduleVideo->description)
                                <div class="px-8 pt-4 text-gray-600">{{ $moduleVideo->description }}</div>
                            @endif
                            <div class="p-6">
                                <div class="video-protected-wrapper bg-black rounded-2xl overflow-hidden shadow-2xl" style="position:relative;padding-bottom:56.25%;height:0;">
                                    <iframe
                                        class="protected-video-iframe"
                                        src="{{ $moduleVideo->video_url }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                        style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                    </iframe>
                                    <!-- Transparent overlay to block right-click/drag on iframe -->
                                    <div class="video-overlay" style="position:absolute;top:0;left:0;width:100%;height:calc(100% - 48px);z-index:10;pointer-events:none;"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @elseif($module->video_url && trim($module->video_url) !== '')
                    {{-- Backward compat: show legacy single video --}}
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                            <h2 class="text-2xl font-black text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Video Lesson
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="video-protected-wrapper bg-black rounded-2xl overflow-hidden shadow-2xl" style="position:relative;padding-bottom:56.25%;height:0;">
                                <iframe
                                    class="protected-video-iframe"
                                    src="{{ $module->video_url }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                </iframe>
                                <div class="video-overlay" style="position:absolute;top:0;left:0;width:100%;height:calc(100% - 48px);z-index:10;pointer-events:none;"></div>
                                <div class="video-blocked-overlay" style="display:none;position:absolute;top:0;left:0;width:100%;height:100%;z-index:50;background:rgba(0,0,0,0.92);align-items:center;justify-content:center;flex-direction:column;">
                                    <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                    </svg>
                                    <p class="text-white font-black text-xl mb-2">Content Protected</p>
                                    <p class="text-gray-400 text-sm text-center px-8">Close developer tools to continue watching.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Materials -->
                @if($module->materials->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                            <h2 class="text-2xl font-black text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Learning Materials
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($module->materials->sortBy('order') as $material)
                                    <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-yellow-400 hover:shadow-xl transition-all">
                                        <div class="mb-3">
                                            @if($material->type === 'image')
                                                <img src="{{ Storage::url($material->file_path) }}" alt="{{ $material->title }}" class="w-full h-56 object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-32 bg-gradient-to-br
                                                    {{ $material->type === 'pdf' ? 'from-red-100 to-red-200' : 'from-blue-100 to-blue-200' }}">
                                                    @if($material->type === 'pdf')
                                                        <svg class="h-20 w-20 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="h-20 w-20 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-black text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors">{{ $material->title }}</h3>
                                            @if($material->description)
                                                <p class="text-sm text-gray-600 mb-4">{{ $material->description }}</p>
                                            @endif
                                            <a href="{{ Storage::url($material->file_path) }}" download class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold shadow-lg hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- MCQ Quiz -->
                @if($mcqQuestions->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                            <h2 class="text-2xl font-black text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                Practice Quiz (MCQ)
                            </h2>
                        </div>
                        <div class="p-6">
                            <!-- Quiz Results -->
                            @if(session('quiz_results'))
                                <div class="mb-8 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-3xl p-8 shadow-xl">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-2xl font-black text-gray-900">Quiz Results</h3>
                                        <div class="text-5xl font-black text-gradient">
                                            {{ number_format(session('quiz_results')['score'], 1) }}%
                                        </div>
                                    </div>
                                    <div class="flex items-center text-gray-900 mb-6 text-lg font-bold">
                                        <svg class="h-6 w-6 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ session('quiz_results')['correct'] }} out of {{ session('quiz_results')['total'] }} correct</span>
                                    </div>

                                    <!-- Detailed Results -->
                                    <div class="space-y-4">
                                        @foreach($mcqQuestions as $index => $question)
                                            @php
                                                $result = session('quiz_results')['results'][$question->id] ?? null;
                                            @endphp
                                            @if($result)
                                                <div class="border-l-4 {{ $result['is_correct'] ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-5 rounded-r-2xl shadow-md">
                                                    <p class="font-black text-gray-900 mb-3 text-base">
                                                        {{ $index + 1 }}. {{ $question->question }}
                                                    </p>
                                                    <div class="text-sm font-semibold">
                                                        <p class="text-gray-700">
                                                            <strong>Your answer:</strong> {{ $result['user_answer'] ?? 'Not answered' }}
                                                            @if($result['is_correct'])
                                                                <span class="text-green-600 font-black ml-2">✓ Correct!</span>
                                                            @else
                                                                <span class="text-red-600 font-black ml-2">✗ Incorrect</span>
                                                            @endif
                                                        </p>
                                                        @if(!$result['is_correct'])
                                                            <p class="text-green-700 mt-2">
                                                                <strong>Correct answer:</strong> {{ $result['correct_answer'] }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Previous Attempts -->
                            @if($quizAttempts->count() > 0)
                                <div class="mb-8">
                                    <h3 class="text-lg font-black text-gray-900 mb-4">Previous Attempts</h3>
                                    <div class="space-y-3">
                                        @foreach($quizAttempts->take(5) as $attempt)
                                            <div class="flex items-center justify-between bg-gradient-to-r from-yellow-50 to-white border-2 border-yellow-200 rounded-2xl p-4 hover:border-yellow-400 transition-all">
                                                <div class="flex items-center space-x-4">
                                                    <span class="text-3xl font-black text-gradient">{{ number_format($attempt->score, 1) }}%</span>
                                                    <div class="text-sm text-gray-700 font-semibold">
                                                        <div>{{ $attempt->correct_answers }}/{{ $attempt->total_questions }} correct</div>
                                                        <div class="text-gray-500">{{ $attempt->completed_at->format('M d, Y h:i A') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Quiz Form -->
                            @if($hasAttempted)
                                <div class="mt-4 p-6 bg-gray-100 border-2 border-gray-300 rounded-2xl text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <p class="text-gray-700 font-black text-lg">Quiz Already Submitted</p>
                                    <p class="text-gray-500 font-semibold mt-1">You have already completed this quiz. Only one attempt is allowed.</p>
                                </div>
                            @else
                                <form action="{{ route('courses.module.quiz', $module) }}" method="POST" id="quizForm">
                                    @csrf
                                    <div class="space-y-8">
                                        @foreach($mcqQuestions as $index => $question)
                                            <div class="border-b-2 border-gray-200 pb-8 last:border-0">
                                                <p class="font-black text-gray-900 mb-4 text-lg">
                                                    {{ $index + 1 }}. {{ $question->question }}
                                                    <span class="text-sm text-yellow-600 font-bold ml-2">({{ $question->marks }} marks)</span>
                                                </p>
                                                @if($question->mcq_options)
                                                    <div class="space-y-3 ml-6">
                                                        @foreach($question->mcq_options as $option)
                                                            @php $optionText = is_array($option) ? ($option['option'] ?? '') : $option; @endphp
                                                            @if($optionText)
                                                            <label class="flex items-center space-x-4 p-4 rounded-2xl border-2 border-gray-200 hover:bg-yellow-50 hover:border-yellow-400 cursor-pointer transition-all group">
                                                                <input
                                                                    type="radio"
                                                                    name="answers[{{ $question->id }}]"
                                                                    value="{{ $optionText }}"
                                                                    class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 focus:ring-2"
                                                                    required>
                                                                <span class="text-gray-700 font-semibold flex-1 group-hover:text-gray-900">{{ $optionText }}</span>
                                                            </label>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-8 pt-8 border-t-2 border-gray-200">
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                            <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Submit Quiz
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Module Completion Button -->
                @if(!$isCompleted)
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-green-200 p-8">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Complete This Module</h3>
                        <p class="text-gray-600 mb-6 text-lg">Once you've finished all the materials and completed the quiz, mark this module as complete.</p>
                        <form action="{{ route('courses.module.complete', $module) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-black text-lg shadow-xl hover:shadow-green-500/50 transform hover:scale-105 transition-all">
                                <svg class="h-6 w-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Mark as Complete
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 sticky top-24 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-xl font-black text-gray-900">Course Modules</h3>
                    </div>

                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($module->course->modules->sortBy('order') as $courseModule)
                                @php
                                    $moduleUnlocked = auth()->user()->moduleUnlocks()->where('module_id', $courseModule->id)->exists();
                                    $moduleCompleted = auth()->user()->hasCompletedModule($courseModule->id);
                                @endphp
                                <a href="{{ $moduleUnlocked ? route('courses.module', $courseModule) : '#' }}"
                                   class="block p-4 rounded-2xl transition-all {{ $courseModule->id === $module->id ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 border-2 border-yellow-400 shadow-lg' : ($moduleUnlocked ? 'bg-gray-50 hover:bg-yellow-50 border-2 border-gray-200 hover:border-yellow-300' : 'bg-gray-100 opacity-50 cursor-not-allowed border-2 border-gray-200') }}">
                                    <div class="flex items-center">
                                        <span class="flex-shrink-0 h-8 w-8 rounded-xl {{ $moduleCompleted ? 'bg-green-500' : ($moduleUnlocked ? 'gradient-primary' : 'bg-gray-400') }} flex items-center justify-center mr-3 shadow-lg">
                                            @if($moduleCompleted)
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($moduleUnlocked)
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </span>
                                        <span class="text-sm font-bold {{ $courseModule->id === $module->id ? 'text-gray-900' : 'text-gray-700' }}">
                                            {{ $courseModule->title }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('courses.show', $module->course) }}" class="block w-full text-center px-6 py-3 rounded-2xl border-2 border-gray-300 text-gray-900 bg-white hover:bg-gray-50 hover:border-yellow-400 font-bold shadow-lg transform hover:scale-105 transition-all">
                                Back to Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gradient-primary {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
}

.text-gradient {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Video Protection ─────────────────────────────── */
.video-protected-wrapper {
    -webkit-user-select: none;
    user-select: none;
}
.video-protected-wrapper * {
    -webkit-user-drag: none;
}

/* Watermark chips inside the video box */
.video-watermark {
    position: absolute;
    z-index: 20;
    pointer-events: none;
    user-select: none;
    font-size: 12px;
    font-weight: 800;
    color: rgba(255, 255, 255, 0.30);
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
    white-space: nowrap;
    transform: rotate(-20deg);
    transition: top 3s ease, left 3s ease;
    letter-spacing: 0.06em;
}

/* Full-screen persistent watermark overlay (covers whole viewport) */
#fs-watermark-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2147483647;   /* highest possible */
    pointer-events: none;
    user-select: none;
    overflow: hidden;
}
#fs-watermark-overlay .fs-wm-chip {
    position: absolute;
    font-size: 14px;
    font-weight: 800;
    color: rgba(255, 255, 255, 0.35);
    text-shadow: 0 1px 4px rgba(0,0,0,0.7);
    white-space: nowrap;
    transform: rotate(-20deg);
    letter-spacing: 0.06em;
    transition: top 4s ease, left 4s ease;
}

/* Screen-share blocked warning */
#screenshare-blocked {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2147483646;
    background: rgba(0,0,0,0.93);
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
</style>

<!-- Full-screen watermark overlay (always in DOM, shown on fullscreen) -->
<div id="fs-watermark-overlay">
    <span class="fs-wm-chip" id="fs-wm-0"></span>
    <span class="fs-wm-chip" id="fs-wm-1"></span>
    <span class="fs-wm-chip" id="fs-wm-2"></span>
    <span class="fs-wm-chip" id="fs-wm-3"></span>
</div>

<!-- Screen-share blocked notice -->
<div id="screenshare-blocked">
    <svg style="width:64px;height:64px;color:#ef4444;margin-bottom:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
    </svg>
    <p style="color:#fff;font-size:20px;font-weight:900;margin-bottom:8px;">Screen Recording Blocked</p>
    <p style="color:#9ca3af;font-size:14px;text-align:center;max-width:360px;padding:0 16px;">
        Screen capture of this content is not permitted.<br>Please close any recording tool and reload.
    </p>
    <button onclick="document.getElementById('screenshare-blocked').style.display='none';"
        style="margin-top:24px;padding:10px 28px;background:#eab308;color:#111;font-weight:900;border:none;border-radius:12px;cursor:pointer;font-size:15px;">
        Dismiss
    </button>
</div>

<script>
(function () {
    'use strict';

    var USER_LABEL = '{{ auth()->user()->email }}';

    // ── 1. Right-click block on video wrappers ───────────────
    document.querySelectorAll('.video-protected-wrapper').forEach(function (w) {
        w.addEventListener('contextmenu', function (e) { e.preventDefault(); });
    });

    // ── 2. Multiple in-video watermarks (3 per wrapper) ──────
    function makeWatermarks() {
        document.querySelectorAll('.video-protected-wrapper').forEach(function (wrapper) {
            // Remove existing watermarks first (idempotent)
            wrapper.querySelectorAll('.video-watermark').forEach(function (el) { el.remove(); });
            for (var i = 0; i < 3; i++) {
                var wm = document.createElement('span');
                wm.className = 'video-watermark';
                wm.textContent = USER_LABEL;
                wrapper.appendChild(wm);
            }
        });
        repositionInVideoWatermarks();
    }

    function repositionInVideoWatermarks() {
        var slots = [[5,5],[35,40],[65,15],[20,65],[55,55],[80,30]];
        var used = [];
        document.querySelectorAll('.video-watermark').forEach(function (wm) {
            var slot;
            do { slot = slots[Math.floor(Math.random() * slots.length)]; }
            while (used.indexOf(slot) !== -1 && used.length < slots.length);
            used.push(slot);
            wm.style.top  = slot[0] + '%';
            wm.style.left = slot[1] + '%';
        });
    }

    makeWatermarks();
    setInterval(repositionInVideoWatermarks, 7000);

    // ── 3. Full-screen watermark overlay ─────────────────────
    var fsOverlay = document.getElementById('fs-watermark-overlay');
    var fsChips   = [
        document.getElementById('fs-wm-0'),
        document.getElementById('fs-wm-1'),
        document.getElementById('fs-wm-2'),
        document.getElementById('fs-wm-3'),
    ];
    fsChips.forEach(function (c) { if (c) c.textContent = USER_LABEL; });

    function repositionFsWatermarks() {
        var positions = [[8,5],[45,50],[75,10],[25,70]];
        fsChips.forEach(function (c, i) {
            if (!c) return;
            c.style.top  = positions[i][0] + '%';
            c.style.left = positions[i][1] + '%';
        });
    }

    function shuffleFsWatermarks() {
        fsChips.forEach(function (c) {
            if (!c) return;
            c.style.top  = (Math.random() * 80 + 5) + '%';
            c.style.left = (Math.random() * 75 + 5) + '%';
        });
    }

    repositionFsWatermarks();
    var fsWmInterval = null;

    // Show overlay whenever ANY element (including iframes) goes fullscreen
    function onFullscreenChange() {
        var isFs = !!(document.fullscreenElement ||
                      document.webkitFullscreenElement ||
                      document.mozFullScreenElement ||
                      document.msFullscreenElement);
        if (isFs) {
            fsOverlay.style.display = 'block';
            repositionFsWatermarks();
            fsWmInterval = setInterval(shuffleFsWatermarks, 6000);
        } else {
            fsOverlay.style.display = 'none';
            clearInterval(fsWmInterval);
        }
    }

    document.addEventListener('fullscreenchange',       onFullscreenChange);
    document.addEventListener('webkitfullscreenchange', onFullscreenChange);
    document.addEventListener('mozfullscreenchange',    onFullscreenChange);
    document.addEventListener('MSFullscreenChange',     onFullscreenChange);

    // ── 4. Browser screen-share interception (getDisplayMedia) ──
    // Catches Chrome extensions, browser-based recorders, and web-based tools.
    // Does NOT stop OBS or OS-level capture — nothing browser-side can.
    if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
        var _original = navigator.mediaDevices.getDisplayMedia.bind(navigator.mediaDevices);
        navigator.mediaDevices.getDisplayMedia = function (constraints) {
            // Blank all protected iframes
            document.querySelectorAll('.protected-video-iframe').forEach(function (iframe) {
                if (!iframe.dataset.origSrc) iframe.dataset.origSrc = iframe.src;
                iframe.src = 'about:blank';
            });
            // Show warning
            var blocked = document.getElementById('screenshare-blocked');
            if (blocked) blocked.style.display = 'flex';
            return Promise.reject(new DOMException('Screen capture blocked by content policy.', 'NotAllowedError'));
        };
    }

    // ── 5. Keyboard shortcut blocking ───────────────────────
    document.addEventListener('keydown', function (e) {
        if (e.key === 'F12') { e.preventDefault(); return false; }
        if (e.ctrlKey && e.shiftKey && 'ijusc'.indexOf(e.key.toLowerCase()) !== -1) {
            e.preventDefault(); return false;
        }
        if (e.ctrlKey && e.key.toLowerCase() === 'u') { e.preventDefault(); return false; }
    });

})();
</script>
@endsection
