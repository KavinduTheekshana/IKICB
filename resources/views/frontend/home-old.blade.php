@extends('layouts.app')

@section('title', 'Home - IKICB LMS')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="text-center">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block">Learn at Your Own Pace</span>
                        <span class="block text-indigo-200">with IKICB LMS</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-indigo-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Access world-class courses from expert instructors. Learn new skills, advance your career, and achieve your goals.
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        <div class="rounded-md shadow">
                            <a href="{{ route('courses.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                Browse Courses
                            </a>
                        </div>
                        @guest
                        <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                            <a href="{{ route('filament.admin.auth.login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 md:py-4 md:text-lg md:px-10">
                                Sign Up
                            </a>
                        </div>
                        @endguest
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<!-- Featured Courses -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Featured Courses</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Start Learning Today
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Explore our most popular courses and start your learning journey
            </p>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($courses as $course)
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        @if($course->thumbnail)
                            <img class="h-48 w-full object-cover" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                        @else
                            <div class="h-48 w-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                <svg class="h-20 w-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-indigo-600">
                                {{ $course->instructor->name }}
                            </p>
                            <a href="{{ route('courses.show', $course) }}" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900 hover:text-indigo-600">
                                    {{ $course->title }}
                                </p>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                    {{ $course->description ?? 'No description available' }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $course->modules_count }} Modules
                            </div>
                            <div class="text-lg font-bold text-indigo-600">
                                LKR {{ number_format($course->full_price, 2) }}
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('courses.show', $course) }}" class="block w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                View Course
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">No courses available at the moment.</p>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Features Section -->
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Why Choose IKICB LMS?</h2>
        </div>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-medium text-gray-900">Expert Instructors</h3>
                <p class="mt-2 text-base text-gray-500">
                    Learn from industry professionals with years of experience
                </p>
            </div>

            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-medium text-gray-900">Learn at Your Pace</h3>
                <p class="mt-2 text-base text-gray-500">
                    Study whenever and wherever you want with lifetime access
                </p>
            </div>

            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-medium text-gray-900">Flexible Payment</h3>
                <p class="mt-2 text-base text-gray-500">
                    Pay for full course or unlock modules one at a time
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
