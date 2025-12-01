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

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Module Header -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }}</h1>
                    <p class="mt-2 text-gray-600">{{ $module->description }}</p>
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
                                    <!-- Material Preview/Icon -->
                                    <div class="mb-3">
                                        @if($material->type === 'image')
                                            <img src="{{ Storage::url($material->file_path) }}" alt="{{ $material->title }}" class="w-full h-48 object-cover rounded-lg">
                                        @else
                                            <div class="flex items-center justify-center h-24 bg-gradient-to-br
                                                {{ $material->type === 'pdf' ? 'from-red-50 to-red-100' : '' }}
                                                {{ $material->type === 'video' ? 'from-purple-50 to-purple-100' : '' }}
                                                {{ $material->type === 'document' ? 'from-blue-50 to-blue-100' : '' }}
                                                {{ $material->type === 'other' ? 'from-gray-50 to-gray-100' : '' }}
                                                rounded-lg">
                                                @if($material->type === 'pdf')
                                                    <svg class="h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif($material->type === 'video')
                                                    <svg class="h-16 w-16 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                @elseif($material->type === 'document')
                                                    <svg class="h-16 w-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="h-16 w-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Material Info -->
                                    <div class="mb-3">
                                        <h3 class="text-base font-semibold text-gray-900 mb-1">{{ $material->title }}</h3>
                                        @if($material->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ $material->description }}</p>
                                        @endif
                                        <div class="flex items-center space-x-3 text-xs text-gray-500">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full font-medium
                                                {{ $material->type === 'pdf' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $material->type === 'image' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $material->type === 'video' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $material->type === 'document' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $material->type === 'other' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ strtoupper($material->type) }}
                                            </span>
                                            @if($material->file_size)
                                                <span>{{ $material->file_size_formatted }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        @if($material->type === 'image')
                                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                        @endif
                                        <a href="{{ Storage::url($material->file_path) }}" download class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Questions (MCQ) -->
                @if($module->questions->where('type', 'mcq')->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Practice Questions</h2>
                        <div class="space-y-6">
                            @foreach($module->questions->where('type', 'mcq') as $index => $question)
                                <div class="border-b border-gray-200 pb-6 last:border-0">
                                    <p class="font-medium text-gray-900 mb-3">
                                        {{ $index + 1 }}. {{ $question->question }}
                                        <span class="text-sm text-gray-500">({{ $question->marks }} marks)</span>
                                    </p>
                                    @if($question->mcq_options)
                                        <div class="space-y-2 ml-6">
                                            @foreach($question->mcq_options as $option)
                                                <label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <input type="radio" name="question_{{ $question->id }}" class="h-4 w-4 text-indigo-600">
                                                    <span class="text-gray-700">{{ $option['option'] ?? $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Theory Exams -->
                @if($module->theoryExams->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Theory Exams</h2>
                        <div class="space-y-4">
                            @foreach($module->theoryExams as $exam)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $exam->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-600">{{ $exam->description }}</p>
                                            <p class="mt-2 text-sm text-gray-500">Total Marks: {{ $exam->total_marks }}</p>
                                        </div>
                                        @if($exam->exam_paper_path)
                                            <a href="{{ Storage::url($exam->exam_paper_path) }}" target="_blank" class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download Paper
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Upload Answer -->
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Submit Your Answer</h4>
                                        <form action="#" method="POST" enctype="multipart/form-data" class="flex items-center space-x-3">
                                            @csrf
                                            <input type="file" name="answer" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                                Upload
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Progress</h3>

                    <div class="space-y-3">
                        @foreach($module->course->modules->sortBy('order') as $courseModule)
                            <a href="{{ auth()->user()->moduleUnlocks()->where('module_id', $courseModule->id)->exists() ? route('courses.module', $courseModule) : '#' }}"
                               class="block p-3 rounded-lg {{ $courseModule->id === $module->id ? 'bg-indigo-50 border-2 border-indigo-500' : 'bg-gray-50 hover:bg-gray-100' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <span class="flex-shrink-0 h-6 w-6 rounded-full {{ auth()->user()->moduleUnlocks()->where('module_id', $courseModule->id)->exists() ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center mr-2">
                                            @if(auth()->user()->moduleUnlocks()->where('module_id', $courseModule->id)->exists())
                                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
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
