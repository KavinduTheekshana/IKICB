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

                <!-- Video Player -->
                @if($module->video_url)
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
                            <div class="aspect-w-16 aspect-h-9 bg-black rounded-2xl overflow-hidden shadow-2xl">
                                <iframe
                                    src="{{ $module->video_url }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    class="w-full h-96">
                                </iframe>
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
                                                    @foreach($question->mcq_options as $optionKey => $option)
                                                        <label class="flex items-center space-x-4 p-4 rounded-2xl border-2 border-gray-200 hover:bg-yellow-50 hover:border-yellow-400 cursor-pointer transition-all group">
                                                            <input
                                                                type="radio"
                                                                name="answers[{{ $question->id }}]"
                                                                value="{{ $optionKey }}"
                                                                class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 focus:ring-2"
                                                                required>
                                                            <span class="text-gray-700 font-semibold flex-1 group-hover:text-gray-900">{{ is_array($option) ? ($option['option'] ?? $option[0] ?? '') : $option }}</span>
                                                        </label>
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
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
