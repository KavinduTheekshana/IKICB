@extends('layouts.guest')

@section('title', 'Verify OTP - IKICB')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-3xl shadow-2xl mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">Enter OTP</h1>
            <p class="text-lg text-gray-600">We sent a 6-digit code to</p>
            <p class="text-base font-bold text-yellow-600 mt-1">{{ $email }}</p>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 p-8 md:p-10">

            @if (session('success'))
                <div class="mb-6 bg-green-50 border-2 border-green-200 rounded-2xl p-4 flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-2xl p-4 flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm font-semibold text-red-800">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify-otp') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label for="otp" class="block text-sm font-bold text-gray-900 mb-2">OTP Code</label>
                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        value="{{ old('otp') }}"
                        required
                        maxlength="6"
                        autocomplete="one-time-code"
                        autofocus
                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all font-black text-gray-900 text-center text-3xl tracking-[1rem]"
                        placeholder="------"
                    >
                    <p class="mt-2 text-xs text-gray-500 text-center">This code expires in 10 minutes</p>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black py-4 px-6 rounded-xl shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300 text-lg"
                >
                    Verify OTP
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                <p class="text-sm text-gray-600">Didn't receive the code?</p>
                <form method="POST" action="{{ route('password.send-otp') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" class="text-sm font-bold text-yellow-600 hover:text-yellow-700 transition-colors underline underline-offset-2">
                        Resend OTP
                    </button>
                </form>
                <div class="pt-2">
                    <a href="{{ route('password.forgot') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                        &larr; Change Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
