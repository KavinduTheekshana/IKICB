@extends('layouts.guest')

@section('title', '503 - Service Unavailable | IKICBC')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Animated Illustration -->
        <div class="mb-8 animate-float">
            <div class="relative inline-block">
                <!-- 503 Text -->
                <div class="text-[200px] sm:text-[280px] font-black leading-none">
                    <span class="text-gradient opacity-20">503</span>
                </div>

                <!-- Floating Tools Icon -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-2xl animate-float">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-gray-900 mb-4">
                Under Maintenance
            </h1>
            <p class="text-xl sm:text-2xl text-gray-600 mb-4">
                We're temporarily unavailable.
            </p>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                We're performing scheduled maintenance to improve your experience. We'll be back online shortly. Thank you for your patience!
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
        </div>

        <!-- Status Info -->
        <div class="mt-12 pt-8 border-t border-gray-200 animate-fade-in" style="animation-delay: 0.6s;">
            <p class="text-sm font-semibold text-gray-500 mb-4">Check Back Soon</p>
            <p class="text-sm text-gray-400">
                Estimated maintenance time: 15-30 minutes
            </p>
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
