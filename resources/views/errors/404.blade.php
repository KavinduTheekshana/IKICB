@extends('layouts.guest')

@section('title', '404 - Page Not Found | IKICBC')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Animated Illustration -->
        <div class="mb-8 animate-float">
            <div class="relative inline-block">
                <!-- 404 Text -->
                <div class="text-[200px] sm:text-[280px] font-black leading-none">
                    <span class="text-gradient opacity-20">404</span>
                </div>

                <!-- Floating Book Icon -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 gradient-animated rounded-3xl flex items-center justify-center shadow-2xl animate-float">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-gray-900 mb-4">
                Oops! Page Not Found
            </h1>
            <p class="text-xl sm:text-2xl text-gray-600 mb-4">
                The page you're looking for seems to have wandered off.
            </p>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Don't worry though! You can explore our courses or head back to the homepage to continue your learning journey.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up" style="animation-delay: 0.4s;">
            <a href="{{ route('home') }}" class="relative px-8 py-4 text-base font-black text-white btn-primary rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Go to Homepage</span>
            </a>

            <a href="{{ route('courses.index') }}" class="px-8 py-4 text-base font-bold text-gray-700 bg-white hover:bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-yellow-300 transition-all duration-300 transform hover:scale-105 inline-flex items-center space-x-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Browse Courses</span>
            </a>
        </div>

        <!-- Quick Links -->
        <div class="mt-12 pt-8 border-t border-gray-200 animate-fade-in" style="animation-delay: 0.6s;">
            <p class="text-sm font-semibold text-gray-500 mb-4">Popular Pages</p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ route('about') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                    About Us
                </a>
                <a href="{{ route('contact') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                    Contact
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}
</style>
@endsection
