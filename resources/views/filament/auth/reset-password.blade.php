<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — {{ $panel === 'admin' ? 'Admin Panel' : 'Branch Panel' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 shadow-lg
                {{ $panel === 'admin' ? 'bg-amber-500' : 'bg-teal-500' }}">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">New Password</h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $panel === 'admin' ? 'Admin Panel' : 'Branch Admin Panel' }}
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-3 flex items-start gap-3">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route("filament.{$panel}.auth.reset-password.submit") }}" class="space-y-5">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autofocus
                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all
                            {{ $panel === 'admin' ? 'focus:ring-amber-500' : 'focus:ring-teal-500' }}"
                        placeholder="Minimum 8 characters"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all
                            {{ $panel === 'admin' ? 'focus:ring-amber-500' : 'focus:ring-teal-500' }}"
                        placeholder="Re-enter your new password"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold transition-all
                        {{ $panel === 'admin'
                            ? 'bg-amber-500 hover:bg-amber-600 text-white'
                            : 'bg-teal-500 hover:bg-teal-600 text-white' }}"
                >
                    Reset Password
                </button>
            </form>
        </div>
    </div>

</body>
</html>
