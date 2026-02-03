@extends('layouts.guest')

@section('title', 'All Courses - Discover Your Next Learning Journey | IKICB')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 mb-6">
            <span class="text-sm font-bold text-yellow-500">🎓 {{ $courses->total() }} Courses Available</span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6 animate-fade-in-up">
            Discover Your Next <br class="hidden sm:block">Learning Journey
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8 animate-fade-in">
            Choose from expert-led courses designed to help you master new skills and advance your career
        </p>
    </div>
</div>

<!-- Courses Section -->
<section class="py-16 bg-gradient-to-br from-gray-50 via-white to-yellow-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="group card-hover bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                    <!-- Course Image -->
                    <div class="relative h-56 overflow-hidden">
                        @if($course->thumbnail)
                            <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                        @else
                            <div class="w-full h-full gradient-animated flex items-center justify-center">
                                <svg class="h-24 w-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                        <!-- Instructor Badge -->
                        {{-- <div class="absolute top-4 left-4">
                            <div class="px-4 py-2 rounded-full glass-effect border border-white/20 backdrop-blur-md">
                                <span class="text-xs font-bold text-gray">{{ $course->instructor->name }}</span>
                            </div>
                        </div> --}}
                        @if($course->is_published)
                            <div class="absolute top-4 right-4">
                                <div class="px-3 py-1 rounded-full bg-green-500 text-white text-xs font-bold shadow-lg">
                                    Published
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Course Content -->
                    <div class="p-6">
                        <a href="{{ route('courses.show', $course) }}" class="block">
                            <h3 class="text-xl font-black text-gray-900 mb-3 line-clamp-2 group-hover:text-yellow-600 transition-colors">
                                {{ $course->title }}
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                {{ $course->description ?? 'Comprehensive course covering all essential topics.' }}
                            </p>
                        </a>

                        <!-- Course Meta -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span class="text-sm font-semibold">{{ $course->modules_count }} Modules</span>
                            </div>
                            <div class="flex items-center space-x-1 text-yellow-500">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <span class="text-sm font-bold text-gray-900">4.9</span>
                            </div>
                        </div>

                        <!-- Price and CTA -->
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-3xl font-black text-gradient">
                                    LKR {{ number_format($course->full_price) }}
                                </div>
                            </div>
                            <a href="{{ route('courses.show', $course) }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold text-sm transition-all transform hover:scale-105 shadow-lg hover:shadow-yellow-500/50">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-3">No Courses Available Yet</h3>
                        <p class="text-gray-600 text-lg mb-8">We're working on adding exciting new courses. Check back soon!</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Home
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="mt-16">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-gray-900 via-black to-gray-900 rounded-3xl p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
            </div>
            <div class="relative">
                <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">
                    Can't Find What You're Looking For?
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Get in touch with us to suggest a course or learn about upcoming offerings
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black text-lg shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                    Contact Us
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
