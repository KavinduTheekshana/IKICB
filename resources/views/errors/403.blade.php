@extends('layouts.guest')

@section('title', '403 - Access Denied | IKICBC')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Animated Illustration -->
        <div class="mb-8 animate-float">
            <div class="relative inline-block">
                <!-- 403 Text -->
                <div class="text-[200px] sm:text-[280px] font-black leading-none">
                    <span class="text-gradient opacity-20">403</span>
                </div>

                <!-- Floating Lock Icon -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 bg-gradient-to-br from-red-500 to-orange-600 rounded-3xl flex items-center justify-center shadow-2xl animate-float">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-gray-900 mb-4">
                Access Denied
            </h1>
            <p class="text-xl sm:text-2xl text-gray-600 mb-4">
                You don't have permission to access this page.
            </p>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                @if($exception->getMessage())
                    {{ $exception->getMessage() }}
                @else
                    This area is restricted. If you believe this is an error, please contact support.
                @endif
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up" style="animation-delay: 0.4s;">
            @auth
                <a href="{{ route('dashboard') }}" class="relative px-8 py-4 text-base font-black text-white btn-primary rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Go to Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="relative px-8 py-4 text-base font-black text-white btn-primary rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Login</span>
                </a>
            @endauth

            <a href="{{ route('home') }}" class="px-8 py-4 text-base font-bold text-gray-700 bg-white hover:bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-yellow-300 transition-all duration-300 transform hover:scale-105 inline-flex items-center space-x-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Go to Homepage</span>
            </a>
        </div>

        <!-- Support Info -->
        <div class="mt-12 pt-8 border-t border-gray-200 animate-fade-in" style="animation-delay: 0.6s;">
            <p class="text-sm font-semibold text-gray-500 mb-4">Need Access?</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Contact Us</span>
                </a>
                <a href="{{ route('about') }}" class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Learn More</span>
                </a>
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
