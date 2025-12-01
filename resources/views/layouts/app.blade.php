<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IKICB Learning Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                            IKICB LMS
                        </a>
                    </div>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('home') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Home
                        </a>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('courses.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Courses
                        </a>
                        <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('about') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            About
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('contact') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Contact
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                            Dashboard
                        </a>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                            Login
                        </a>
                        <a href="{{ route('filament.admin.auth.login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <p class="text-yellow-700">{{ session('warning') }}</p>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <p class="text-blue-700">{{ session('info') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">IKICB LMS</h3>
                    <p class="text-gray-600 text-sm">
                        Excellence in education through innovative learning solutions.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('courses.index') }}" class="text-gray-600 hover:text-indigo-600">Courses</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-indigo-600">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-indigo-600">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
                    <p class="text-gray-600 text-sm">
                        Email: info@ikicb.com<br>
                        Phone: +94 XX XXX XXXX
                    </p>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} IKICB. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
