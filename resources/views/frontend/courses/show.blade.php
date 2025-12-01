@extends('layouts.app')

@section('title', $course->title . ' - IKICB LMS')

@section('content')
<div class="bg-white">
    <!-- Course Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div>
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">
                        {{ $course->title }}
                    </h1>
                    <p class="mt-4 text-xl text-indigo-100">
                        {{ $course->description }}
                    </p>
                    <div class="mt-6 flex items-center text-indigo-100">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                        <span>Instructor: {{ $course->instructor->name }}</span>
                    </div>
                    <div class="mt-2 flex items-center text-indigo-100">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>{{ $course->modules->count() }} Modules</span>
                    </div>
                </div>
                <div class="mt-8 lg:mt-0">
                    @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="rounded-lg shadow-2xl">
                    @else
                        <div class="bg-white bg-opacity-10 rounded-lg h-64 flex items-center justify-center">
                            <svg class="h-32 w-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Modules List -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Modules</h2>

                <div class="space-y-4">
                    @forelse($course->modules as $index => $module)
                        <div class="border border-gray-200 rounded-lg overflow-hidden {{ $isEnrolled && $unlockedModules->contains($module->id) ? 'bg-white' : 'bg-gray-50' }}">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mr-3">
                                                {{ $index + 1 }}
                                            </span>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $module->title }}
                                            </h3>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600 ml-11">
                                            {{ $module->description }}
                                        </p>

                                        @if($isEnrolled && $unlockedModules->contains($module->id))
                                            <div class="mt-4 ml-11">
                                                <a href="{{ route('courses.module', $module) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Start Learning
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-shrink-0">
                                        @if($isEnrolled && $unlockedModules->contains($module->id))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Unlocked
                                            </span>
                                        @elseif($module->module_price)
                                            <div class="text-right">
                                                <div class="text-lg font-bold text-indigo-600">
                                                    LKR {{ number_format($module->module_price, 2) }}
                                                </div>
                                                @auth
                                                    <form action="{{ route('payment.module', $module) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                            Unlock Module
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('filament.admin.auth.login') }}" class="text-xs text-indigo-600 hover:text-indigo-700">
                                                        Login to unlock
                                                    </a>
                                                @endauth
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                                Locked
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">No modules available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="mt-12 lg:mt-0">
                <div class="bg-white border border-gray-200 rounded-lg shadow-lg sticky top-4">
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <div class="text-3xl font-extrabold text-gray-900">
                                LKR {{ number_format($course->full_price, 2) }}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Full Course Access</p>
                        </div>

                        @if($isEnrolled)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-800 font-medium">You're enrolled!</span>
                                </div>
                            </div>
                            <a href="{{ route('dashboard.my-courses') }}" class="block w-full text-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Go to Dashboard
                            </a>
                        @else
                            @auth
                                <form action="{{ route('payment.course', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 mb-4">
                                        Buy Full Course
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('filament.admin.auth.login') }}" class="block w-full text-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 mb-4">
                                    Login to Enroll
                                </a>
                            @endauth

                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-sm text-gray-600 text-center">
                                    Or unlock modules individually as you progress
                                </p>
                            </div>
                        @endif

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-900 mb-4">This course includes:</h4>
                            <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $course->modules->count() }} modules
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Video lessons
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Downloadable resources
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Quizzes and exams
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lifetime access
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
