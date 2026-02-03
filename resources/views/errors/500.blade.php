@extends('layouts.guest')

@section('title', '500 - Server Error | IKICBC')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Animated Illustration -->
        <div class="mb-8 animate-float">
            <div class="relative inline-block">
                <!-- 500 Text -->
                <div class="text-[200px] sm:text-[280px] font-black leading-none">
                    <span class="text-gradient opacity-20">500</span>
                </div>

                <!-- Floating Alert Icon -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 bg-gradient-to-br from-red-500 to-red-600 rounded-3xl flex items-center justify-center shadow-2xl animate-float">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-gray-900 mb-4">
                Something Went Wrong
            </h1>
            <p class="text-xl sm:text-2xl text-gray-600 mb-4">
                We're experiencing technical difficulties.
            </p>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Our team has been notified and is working to fix the issue. Please try again in a few moments.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up" style="animation-delay: 0.4s;">
            <button onclick="location.reload()" class="relative px-8 py-4 text-base font-black text-white btn-primary rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Try Again</span>
            </button>

            <a href="{{ route('home') }}" class="px-8 py-4 text-base font-bold text-gray-700 bg-white hover:bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-yellow-300 transition-all duration-300 transform hover:scale-105 inline-flex items-center space-x-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Go to Homepage</span>
            </a>
        </div>

        <!-- Support Info -->
        <div class="mt-12 pt-8 border-t border-gray-200 animate-fade-in" style="animation-delay: 0.6s;">
            <p class="text-sm font-semibold text-gray-500 mb-4">Need Immediate Help?</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Contact Support</span>
                </a>
                <a href="tel:0777155515" class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span>Call: 0777155515</span>
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
