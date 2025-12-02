@extends('layouts.guest')

@section('title', 'My Courses - Dashboard')

@section('content')
<!-- Hero Header -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-white mb-2">
                    My Courses
                </h1>
                <p class="text-lg text-gray-300">All courses you've enrolled in</p>
            </div>
            <a href="{{ route('courses.index') }}" class="hidden sm:inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl text-gray-900 font-bold shadow-lg hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Browse More Courses
            </a>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
            <a href="{{ route('dashboard') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                Overview
            </a>
            <a href="{{ route('dashboard.my-courses') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-yellow-500 text-yellow-600 font-black text-sm">
                My Courses
            </a>
            <a href="{{ route('dashboard.payments') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                Payments
            </a>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Courses Grid -->
        @if($enrollments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($enrollments as $enrollment)
                    <div class="group card-hover bg-white rounded-3xl shadow-lg overflow-hidden border-2 border-yellow-200 hover:border-yellow-400 transition-all">
                        <!-- Course Image -->
                        <div class="relative h-56 overflow-hidden">
                            @if($enrollment->course->thumbnail)
                                <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full gradient-animated flex items-center justify-center">
                                    <svg class="h-24 w-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Enrolled Badge -->
                            <div class="absolute top-4 right-4">
                                <div class="px-3 py-1 rounded-full bg-green-500 text-white text-xs font-bold shadow-lg">
                                    Enrolled
                                </div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-black text-gray-900 mb-2 line-clamp-2 group-hover:text-yellow-600 transition-colors">
                                {{ $enrollment->course->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $enrollment->course->description ?? 'Continue your learning journey with this course.' }}
                            </p>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                                <div class="flex items-center space-x-2 text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ $enrollment->course->modules->count() }} Modules</span>
                                </div>
                                <div class="text-xs text-gray-400 font-medium">
                                    Enrolled {{ $enrollment->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('courses.show', $enrollment->course) }}" class="block w-full text-center px-6 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold text-sm transition-all transform hover:scale-105 shadow-lg hover:shadow-yellow-500/50">
                                Continue Learning
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200 mb-6">
                        <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 mb-3">No Courses Yet</h3>
                    <p class="text-gray-600 text-lg mb-8">You haven't enrolled in any courses. Start your learning journey today!</p>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Browse Courses
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(251, 191, 36, 0.1);
}

.gradient-animated {
    background: linear-gradient(-45deg, #FFD700, #FDB931, #B8860B, #1a1a1a);
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>
@endsection
