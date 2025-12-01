@extends('layouts.app')

@section('title', $module->title . ' - ' . $module->course->title)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('courses.index') }}" class="text-indigo-600 hover:text-indigo-700">Courses</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('courses.show', $module->course) }}" class="text-indigo-600 hover:text-indigo-700">{{ $module->course->title }}</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-gray-500">{{ $module->title }}</span></li>
            </ol>
        </nav>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Module Header with Completion Status -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }}</h1>
                            <p class="mt-2 text-gray-600">{{ $module->description }}</p>
                        </div>
                        @if($isCompleted)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Completed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Video Player -->
                @if($module->video_url)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Video Lesson</h2>
                        <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                            <iframe
                                src="{{ $module->video_url }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="w-full h-96">
                            </iframe>
                        </div>
                    </div>
                @endif

                <!-- Materials -->
                @if($module->materials->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Learning Materials</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($module->materials->sortBy('order') as $material)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="mb-3">
                                        @if($material->type === 'image')
                                            <img src="{{ Storage::url($material->file_path) }}" alt="{{ $material->title }}" class="w-full h-48 object-cover rounded-lg">
                                        @else
                                            <div class="flex items-center justify-center h-24 bg-gradient-to-br
                                                {{ $material->type === 'pdf' ? 'from-red-50 to-red-100' : '' }}
                                                {{ $material->type === 'document' ? 'from-blue-50 to-blue-100' : '' }}
                                                rounded-lg">
                                                @if($material->type === 'pdf')
                                                    <svg class="h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="h-16 w-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <h3 class="text-base font-semibold text-gray-900 mb-1">{{ $material->title }}</h3>
                                        @if($material->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ $material->description }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ Storage::url($material->file_path) }}" download class="w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- MCQ Quiz -->
                @if($mcqQuestions->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Practice Quiz (MCQ)</h2>

                        <!-- Quiz Results -->
                        @if(session('quiz_results'))
                            <div class="mb-6 bg-indigo-50 border-2 border-indigo-200 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-indigo-900">Quiz Results</h3>
                                    <div class="text-3xl font-bold text-indigo-600">
                                        {{ number_format(session('quiz_results')['score'], 1) }}%
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-700 mb-4">
                                    <svg class="h-5 w-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ session('quiz_results')['correct'] }} out of {{ session('quiz_results')['total'] }} correct</span>
                                </div>

                                <!-- Detailed Results -->
                                <div class="space-y-4 mt-4">
                                    @foreach($mcqQuestions as $index => $question)
                                        @php
                                            $result = session('quiz_results')['results'][$question->id] ?? null;
                                        @endphp
                                        @if($result)
                                            <div class="border-l-4 {{ $result['is_correct'] ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-4 rounded-r">
                                                <p class="font-medium text-gray-900 mb-2">
                                                    {{ $index + 1 }}. {{ $question->question }}
                                                </p>
                                                <div class="text-sm">
                                                    <p class="text-gray-700">
                                                        <strong>Your answer:</strong> {{ $result['user_answer'] ?? 'Not answered' }}
                                                        @if($result['is_correct'])
                                                            <span class="text-green-600 font-semibold">✓ Correct!</span>
                                                        @else
                                                            <span class="text-red-600 font-semibold">✗ Incorrect</span>
                                                        @endif
                                                    </p>
                                                    @if(!$result['is_correct'])
                                                        <p class="text-green-700 mt-1">
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
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-700 mb-3">Previous Attempts</h3>
                                <div class="space-y-2">
                                    @foreach($quizAttempts->take(5) as $attempt)
                                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($attempt->score, 1) }}%</span>
                                                <div class="text-sm text-gray-600">
                                                    <div>{{ $attempt->correct_answers }}/{{ $attempt->total_questions }} correct</div>
                                                    <div>{{ $attempt->completed_at->format('M d, Y h:i A') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quiz Form -->
                        <form action="{{ route('courses.module.quiz', $module) }}" method="POST" id="quizForm">
                            @csrf
                            <div class="space-y-6">
                                @foreach($mcqQuestions as $index => $question)
                                    <div class="border-b border-gray-200 pb-6 last:border-0">
                                        <p class="font-medium text-gray-900 mb-3">
                                            {{ $index + 1 }}. {{ $question->question }}
                                            <span class="text-sm text-indigo-600">({{ $question->marks }} marks)</span>
                                        </p>
                                        @if($question->mcq_options)
                                            <div class="space-y-2 ml-6">
                                                @foreach($question->mcq_options as $optionKey => $option)
                                                    <label class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-300 cursor-pointer transition">
                                                        <input
                                                            type="radio"
                                                            name="answers[{{ $question->id }}]"
                                                            value="{{ $optionKey }}"
                                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                            required>
                                                        <span class="text-gray-700 flex-1">{{ is_array($option) ? ($option['option'] ?? $option[0] ?? '') : $option }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Submit Quiz
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Module Completion Button -->
                @if(!$isCompleted)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Complete This Module</h3>
                        <p class="text-gray-600 mb-4">Once you've finished all the materials and completed the quiz, mark this module as complete.</p>
                        <form action="{{ route('courses.module.complete', $module) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
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
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Modules</h3>

                    <div class="space-y-3">
                        @foreach($module->course->modules->sortBy('order') as $courseModule)
                            @php
                                $moduleUnlocked = auth()->user()->moduleUnlocks()->where('module_id', $courseModule->id)->exists();
                                $moduleCompleted = auth()->user()->hasCompletedModule($courseModule->id);
                            @endphp
                            <a href="{{ $moduleUnlocked ? route('courses.module', $courseModule) : '#' }}"
                               class="block p-3 rounded-lg transition {{ $courseModule->id === $module->id ? 'bg-indigo-50 border-2 border-indigo-500' : ($moduleUnlocked ? 'bg-gray-50 hover:bg-gray-100' : 'bg-gray-50 opacity-50 cursor-not-allowed') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <span class="flex-shrink-0 h-6 w-6 rounded-full {{ $moduleCompleted ? 'bg-green-500' : ($moduleUnlocked ? 'bg-indigo-500' : 'bg-gray-300') }} flex items-center justify-center mr-2">
                                            @if($moduleCompleted)
                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($moduleUnlocked)
                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </span>
                                        <span class="text-sm font-medium {{ $courseModule->id === $module->id ? 'text-indigo-600' : 'text-gray-700' }}">
                                            {{ $courseModule->title }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.show', $module->course) }}" class="block w-full text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Back to Course
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
