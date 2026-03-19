<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — {{ $panel === 'admin' ? 'Admin Panel' : 'Branch Panel' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">

        {{-- Panel badge --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 shadow-lg
                {{ $panel === 'admin' ? 'bg-amber-500' : 'bg-teal-500' }}">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Forgot Password</h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $panel === 'admin' ? 'Admin Panel' : 'Branch Admin Panel' }}
            </p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">

            @if (session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 rounded-xl p-3 flex items-center gap-3">
                    <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-3 flex items-center gap-3">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <p class="text-sm text-gray-500 mb-6">Enter your email address and we'll send you a 6-digit OTP code.</p>

            <form method="POST" action="{{ route("filament.{$panel}.auth.send-otp") }}" id="otpForm" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all
                            {{ $panel === 'admin' ? 'focus:ring-amber-500' : 'focus:ring-teal-500' }}"
                        placeholder="you@example.com"
                    >
                </div>

                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold transition-all disabled:opacity-50 disabled:cursor-not-allowed
                        {{ $panel === 'admin'
                            ? 'bg-amber-500 hover:bg-amber-600 text-white'
                            : 'bg-teal-500 hover:bg-teal-600 text-white' }}"
                >
                    <span id="btnText">Send OTP Code</span>
                    <span id="btnLoading" class="hidden items-center justify-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>

            <div class="mt-5 text-center">
                <a href="{{ route("filament.{$panel}.auth.login") }}"
                   class="text-sm font-medium transition-colors
                       {{ $panel === 'admin' ? 'text-amber-600 hover:text-amber-700' : 'text-teal-600 hover:text-teal-700' }}">
                    &larr; Back to Sign In
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('otpForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            document.getElementById('btnText').classList.add('hidden');
            const loading = document.getElementById('btnLoading');
            loading.classList.remove('hidden');
            loading.classList.add('inline-flex');
        });
    </script>
</body>
</html>
