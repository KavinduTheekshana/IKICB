<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP — {{ $panel === 'admin' ? 'Admin Panel' : 'Branch Panel' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 shadow-lg
                {{ $panel === 'admin' ? 'bg-amber-500' : 'bg-teal-500' }}">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Enter OTP</h1>
            <p class="text-sm text-gray-500 mt-1">Code sent to</p>
            <p class="text-sm font-semibold mt-0.5 {{ $panel === 'admin' ? 'text-amber-600' : 'text-teal-600' }}">
                {{ $email }}
            </p>
        </div>

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

            <form method="POST" action="{{ route("filament.{$panel}.auth.verify-otp.submit") }}" class="space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-1.5">OTP Code</label>
                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        value="{{ old('otp') }}"
                        required
                        maxlength="6"
                        autocomplete="one-time-code"
                        autofocus
                        class="w-full px-3.5 py-3 bg-white border border-gray-300 rounded-xl text-gray-900 text-center text-2xl font-bold tracking-[0.6em] placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition-all
                            {{ $panel === 'admin' ? 'focus:ring-amber-500' : 'focus:ring-teal-500' }}"
                        placeholder="──────"
                    >
                    <p class="mt-1.5 text-xs text-gray-400 text-center">Valid for 10 minutes</p>
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold transition-all
                        {{ $panel === 'admin'
                            ? 'bg-amber-500 hover:bg-amber-600 text-white'
                            : 'bg-teal-500 hover:bg-teal-600 text-white' }}"
                >
                    Verify OTP
                </button>
            </form>

            <div class="mt-5 space-y-3 text-center">
                <p class="text-xs text-gray-400">Didn't receive the code?</p>
                <form method="POST" action="{{ route("filament.{$panel}.auth.send-otp") }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit"
                        class="text-sm font-medium transition-colors underline underline-offset-2
                            {{ $panel === 'admin' ? 'text-amber-600 hover:text-amber-700' : 'text-teal-600 hover:text-teal-700' }}">
                        Resend OTP
                    </button>
                </form>
                <div>
                    <a href="{{ route("filament.{$panel}.auth.forgot-password") }}"
                       class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        &larr; Change Email
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
