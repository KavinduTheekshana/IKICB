@extends('layouts.guest')

@section('title', 'Sign In - IKICB')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-3xl shadow-2xl mb-6 transform hover:scale-105 transition-transform">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">Welcome Back</h1>
            <p class="text-lg text-gray-600">Sign in to continue your learning journey</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 p-8 md:p-10">

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-2xl p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-red-800">Login Failed</h3>
                            <div class="mt-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all font-medium text-gray-900"
                        placeholder="you@example.com"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-900 mb-2">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all font-medium text-gray-900"
                        placeholder="Enter your password"
                    >
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500 cursor-pointer">
                        <span class="ml-2 text-sm font-semibold text-gray-700 group-hover:text-gray-900">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black py-4 px-6 rounded-xl shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300 text-lg"
                >
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t-2 border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-600 font-semibold">Don't have an account?</span>
                </div>
            </div>

            <!-- Register Link -->
            <a
                href="{{ route('register') }}"
                class="block w-full text-center bg-gradient-to-br from-gray-50 to-yellow-50 hover:from-yellow-50 hover:to-yellow-100 text-gray-900 font-bold py-4 px-6 rounded-xl border-2 border-gray-200 hover:border-yellow-300 transition-all duration-300 transform hover:scale-105"
            >
                Create Account
            </a>
        </div>

        <!-- Footer Text -->
        <p class="text-center text-sm text-gray-600 mt-8">
            By signing in, you agree to our
            <a href="{{ route('terms') }}" class="text-yellow-600 hover:text-yellow-700 font-bold">Terms of Service</a>
            and
            <a href="{{ route('privacy') }}" class="text-yellow-600 hover:text-yellow-700 font-bold">Privacy Policy</a>
        </p>
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endsection
