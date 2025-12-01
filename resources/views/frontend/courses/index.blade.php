@extends('layouts.app')

@section('title', 'All Courses - IKICB LMS')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Explore Our Courses
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                Choose from our wide range of professional courses
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($courses as $course)
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex-shrink-0">
                        @if($course->thumbnail)
                            <img class="h-56 w-full object-cover" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                        @else
                            <div class="h-56 w-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center">
                                <svg class="h-24 w-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $course->instructor->name }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $course->modules_count }} modules
                                </span>
                            </div>
                            <a href="{{ route('courses.show', $course) }}" class="block mt-2">
                                <h3 class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                                    {{ $course->title }}
                                </h3>
                                <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                                    {{ $course->description ?? 'No description available.' }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-2xl font-bold text-indigo-600">
                                    LKR {{ number_format($course->full_price, 2) }}
                                </div>
                            </div>
                            <a href="{{ route('courses.show', $course) }}" class="block w-full text-center px-4 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No courses found</h3>
                        <p class="mt-2 text-sm text-gray-500">Check back later for new courses.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
