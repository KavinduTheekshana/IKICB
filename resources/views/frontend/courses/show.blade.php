@extends('layouts.guest')

@section('title', $course->title . ' - IKICB LMS')

@section('content')
<!-- Course Hero Header -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6">
                <!-- Back Button -->
                <a href="{{ route('courses.index') }}" class="inline-flex items-center text-yellow-500 hover:text-yellow-400 font-bold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Courses
                </a>

                <h1 class="text-4xl sm:text-5xl font-black text-white leading-tight">
                    {{ $course->title }}
                </h1>

                <p class="text-xl text-gray-300 leading-relaxed">
                    {{ $course->description }}
                </p>

                <!-- Course Meta -->
                <div class="flex flex-wrap gap-6 pt-4">
                    <div class="flex items-center text-gray-300">
                        <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Instructor</div>
                            <div class="font-bold text-white">{{ $course->instructor->name }}</div>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-300">
                        <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Modules</div>
                            <div class="font-bold text-white">{{ $course->modules->count() }} Modules</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div class="mt-10 lg:mt-0">
                @if($course->thumbnail)
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                @else
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <div class="gradient-animated h-80 flex items-center justify-center">
                            <svg class="h-32 w-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Course Content -->
<div class="bg-gradient-to-br from-gray-50 via-white to-yellow-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Modules List -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-black text-gray-900">Course Modules</h2>
                    <div class="px-4 py-2 rounded-xl bg-yellow-100 border border-yellow-300">
                        <span class="text-sm font-bold text-gray-900">{{ $course->modules->count() }} Modules</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($course->modules as $index => $module)
                        <div class="group bg-white rounded-2xl shadow-lg overflow-hidden border-2 {{ $isEnrolled && $unlockedModules->contains($module->id) ? 'border-yellow-300 hover:border-yellow-400' : 'border-gray-200 hover:border-gray-300' }} transition-all hover:shadow-xl">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl gradient-primary text-white font-black text-base mr-4 shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                            <h3 class="text-xl font-black text-gray-900 group-hover:text-yellow-600 transition-colors">
                                                {{ $module->title }}
                                            </h3>
                                        </div>
                                        <p class="text-gray-600 ml-14 mb-4">
                                            {{ $module->description }}
                                        </p>

                                        @if($isEnrolled && $unlockedModules->contains($module->id))
                                            <div class="ml-14">
                                                <a href="{{ route('courses.module', $module) }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold shadow-lg hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Start Learning
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-shrink-0">
                                        @if($isEnrolled && $completedModules->contains($module->id))
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 border border-green-300">
                                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Completed
                                            </span>
                                        @elseif($isEnrolled && $unlockedModules->contains($module->id))
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                                In Progress
                                            </span>
                                        @elseif($module->module_price)
                                            <div class="text-right">
                                                <div class="text-2xl font-black text-gradient mb-2">
                                                    LKR {{ number_format($module->module_price, 2) }}
                                                </div>
                                                @auth
                                                    <form action="{{ route('payment.module', $module) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold text-sm shadow-lg hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                                            </svg>
                                                            Unlock Module
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('login') }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-bold">
                                                        Login to unlock
                                                    </a>
                                                @endauth
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gray-100 text-gray-800 border border-gray-300">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <div class="text-center py-16 bg-white rounded-2xl shadow-lg border-2 border-gray-200">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <p class="text-xl font-bold text-gray-900 mb-2">No modules available yet</p>
                            <p class="text-gray-500">Check back soon for new content!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="mt-12 lg:mt-0">
                <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 sticky top-24 overflow-hidden">
                    <!-- Price Header -->
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 text-center">
                        <div class="text-sm font-bold text-gray-900 mb-2">Full Course Access</div>
                        <div class="text-4xl font-black text-white">
                            LKR {{ number_format($course->full_price, 2) }}
                        </div>
                    </div>

                    <div class="p-6">
                        @if($isEnrolled)
                            <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-4 mb-6">
                                <div class="flex items-center justify-center">
                                    <svg class="h-6 w-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-800 font-black text-lg">You're Enrolled!</span>
                                </div>
                            </div>
                            <a href="{{ route('dashboard.my-courses') }}" class="block w-full text-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                Go to Dashboard
                            </a>
                        @else
                            @auth
                                <form action="{{ route('payment.course', $course) }}" method="POST" class="mb-4">
                                    @csrf
                                    <button type="submit" class="block w-full text-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Buy Full Course
                                        </span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all mb-4">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        Login to Enroll
                                    </span>
                                </a>
                            @endauth

                            <div class="border-t-2 border-gray-200 pt-4">
                                <p class="text-sm text-gray-600 text-center font-semibold">
                                    Or unlock modules individually as you progress
                                </p>
                            </div>
                        @endif

                        <!-- Course Features -->
                        <div class="mt-6 pt-6 border-t-2 border-gray-200">
                            <h4 class="text-lg font-black text-gray-900 mb-4">This course includes:</h4>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 font-semibold">{{ $course->modules->count() }} comprehensive modules</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 font-semibold">HD video lessons</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 font-semibold">Downloadable resources</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 font-semibold">Interactive quizzes & exams</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 font-semibold">Lifetime access</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 font-semibold">Certificate of completion</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gradient-animated {
    background: linear-gradient(-45deg, #FFD700, #FDB931, #B8860B, #1a1a1a);
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
}

.gradient-primary {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
}

.text-gradient {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>
@endsection
