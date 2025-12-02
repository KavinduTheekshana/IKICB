@extends('layouts.guest')

@section('title', 'IKICB - Transform Your Future with Quality Education')

@section('content')
<!-- Hero Section with Floating Shapes -->
<div class="relative overflow-hidden bg-gradient-to-br from-yellow-50 via-white to-gray-50 py-20 sm:py-32">
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left space-y-8 animate-fade-in-up">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-yellow-100 to-yellow-200 border border-yellow-300">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                    <span class="text-sm font-bold text-gray-900">50,000+ Students Learning Online</span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-tight">
                    <span class="block text-gray-900">Transform Your</span>
                    <span class="block text-gradient">Future Today</span>
                </h1>

                <p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
                    Join thousands of learners advancing their careers with expert-led courses. Learn at your own pace, earn certificates, and unlock your potential.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('courses.index') }}" class="group relative px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black text-lg shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300 overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center space-x-2">
                            <span>Explore Courses</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white rounded-2xl text-gray-900 font-black text-lg border-2 border-gray-200 hover:border-yellow-400 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Start Free Trial
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div class="text-center lg:text-left">
                        <div class="text-4xl font-black text-gradient">500+</div>
                        <div class="text-sm text-gray-600 font-semibold">Expert Courses</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-4xl font-black text-gradient">50K+</div>
                        <div class="text-sm text-gray-600 font-semibold">Active Students</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-4xl font-black text-gradient">4.9★</div>
                        <div class="text-sm text-gray-600 font-semibold">Average Rating</div>
                    </div>
                </div>
            </div>

            <!-- Right Image/Illustration -->
            <div class="relative animate-float hidden lg:block">
                <div class="relative z-10">
                    <div class="aspect-square rounded-3xl bg-gradient-to-br from-yellow-100 to-yellow-200 p-8">
                        <div class="w-full h-full rounded-2xl bg-white shadow-2xl p-8 flex items-center justify-center">
                            <svg class="w-full h-full text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Floating Cards -->
                    <div class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-2xl p-4 animate-float" style="animation-delay: -1s;">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-black text-gray-900">98%</div>
                                <div class="text-xs text-gray-600">Success Rate</div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-2xl p-4 animate-float" style="animation-delay: -2s;">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-black text-gray-900">24/7</div>
                                <div class="text-xs text-gray-600">Support</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Courses Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-fade-in-up">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                <span class="text-sm font-bold text-gray-900">POPULAR COURSES</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                Start Learning <span class="text-gradient">Today</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Choose from our most popular courses and start your learning journey with expert instructors
            </p>
        </div>

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
                        <div class="absolute top-4 left-4">
                            <div class="px-4 py-2 rounded-full glass-effect border border-white/20 backdrop-blur-md">
                                <span class="text-xs font-bold text-white">{{ $course->instructor->name }}</span>
                            </div>
                        </div>
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
                <div class="col-span-3 text-center py-16">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No courses available yet</h3>
                    <p class="text-gray-600">Check back soon for exciting new courses!</p>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                Why Choose <span class="text-gradient">IKICB</span>?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Everything you need to succeed in your learning journey
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Expert Instructors</h3>
                <p class="text-gray-600 leading-relaxed">
                    Learn from industry professionals with years of real-world experience and proven teaching expertise.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                <div class="w-16 h-16 rounded-2xl gradient-secondary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Learn at Your Pace</h3>
                <p class="text-gray-600 leading-relaxed">
                    Study whenever and wherever you want with lifetime access to course materials and resources.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                <div class="w-16 h-16 rounded-2xl gradient-success flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Verified Certificates</h3>
                <p class="text-gray-600 leading-relaxed">
                    Earn industry-recognized certificates upon completion to showcase your newly acquired skills.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Flexible Payment</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pay for the full course or unlock modules one at a time based on your budget and learning goals.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-cyan-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Interactive Quizzes</h3>
                <p class="text-gray-600 leading-relaxed">
                    Test your knowledge with interactive MCQ quizzes and get instant feedback on your performance.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">24/7 Support</h3>
                <p class="text-gray-600 leading-relaxed">
                    Get help whenever you need it with our dedicated support team available round the clock.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-gray-900 via-black to-gray-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6">
            Ready to Start Learning?
        </h2>
        <p class="text-xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
            Join thousands of students who are already transforming their careers. Start your journey today with a free trial.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('register') }}" class="group px-10 py-5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black text-lg shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300">
                <span class="flex items-center justify-center space-x-2">
                    <span>Get Started Free</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </span>
            </a>
            <a href="{{ route('courses.index') }}" class="px-10 py-5 bg-transparent border-2 border-yellow-500 rounded-2xl text-yellow-500 font-black text-lg hover:bg-yellow-500 hover:text-gray-900 transform hover:scale-105 transition-all duration-300">
                Browse All Courses
            </a>
        </div>
    </div>
</section>
@endsection
