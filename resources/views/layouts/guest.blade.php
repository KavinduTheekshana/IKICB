<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'IKICBC - Transform Your Future with Quality Education')</title>
    <meta name="description" content="@yield('description', 'IKICBC Learning Management System - Empowering learners worldwide with cutting-edge courses and expert instructors. Join thousands of students advancing their careers through quality education.')">
    <meta name="keywords" content="@yield('keywords', 'online learning, courses, education, LMS, IKICBC, e-learning, professional development, skill training, online courses, career advancement')">
    <meta name="author" content="IKICBC Learning Management System">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph Meta Tags (Facebook, LinkedIn) -->
    <meta property="og:title" content="@yield('og_title', 'IKICBC - Transform Your Future with Quality Education')">
    <meta property="og:description" content="@yield('og_description', 'Empowering learners worldwide with cutting-edge courses and expert instructors. Join thousands of students advancing their careers through quality education.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="IKICBC Learning Management System">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'IKICBC - Transform Your Future with Quality Education')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Empowering learners worldwide with cutting-edge courses and expert instructors.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">
    <meta name="twitter:site" content="@IKICBClms">
    <meta name="twitter:creator" content="@IKICBClms">

    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#FFD700">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="IKICBC">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('meta')

    <style>
        /* Professional Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .gradient-animated {
            background: linear-gradient(-45deg, #FFD700, #FDB931, #B8860B, #1a1a1a);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, #B8860B 0%, #1a1a1a 100%);
        }

        .gradient-success {
            background: linear-gradient(135deg, #FFD700 0%, #DAA520 100%);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #FDB931 0%, #B8860B 100%);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 215, 0, 0.5);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .text-gradient {
            background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Mobile Menu Animation */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.active {
            max-height: 600px;
        }

        /* Floating shapes background */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            bottom: 10%;
            right: 10%;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #B8860B 0%, #1a1a1a 100%);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 10s ease-in-out infinite;
            animation-delay: -2s;
        }

        /* Notification slide animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-enter {
            animation: slideDown 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-white to-yellow-50">
    <!-- Modern Navigation -->
    <nav class="glass-effect shadow-xl border-b border-gray-200/50 fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="w-14 h-14 gradient-animated rounded-2xl flex items-center justify-center shadow-2xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-2xl font-black text-gradient">IKICBC</h1>
                            <p class="text-xs text-gray-500 font-medium -mt-1">Learning Hub</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="nav-link px-5 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('home') ? 'text-white gradient-primary shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition-all duration-300">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Home</span>
                        </div>
                    </a>
                    <a href="{{ route('courses.index') }}" class="nav-link px-5 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('courses.*') && !request()->routeIs('courses.module') ? 'text-white gradient-primary shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition-all duration-300">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>Courses</span>
                        </div>
                    </a>
                    <a href="{{ route('about') }}" class="nav-link px-5 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('about') ? 'text-white gradient-primary shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition-all duration-300">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>About</span>
                        </div>
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link px-5 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('contact') ? 'text-white gradient-primary shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition-all duration-300">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>Contact</span>
                        </div>
                    </a>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-6 py-3 text-sm font-bold text-gray-700 hover:text-yellow-600 hover:bg-gray-50 rounded-xl transition-all duration-300">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="relative px-8 py-3.5 text-sm font-black text-white btn-primary rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                        <span class="relative z-10 flex items-center space-x-2">
                            <span>Get Started Free</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button type="button" class="lg:hidden p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div id="mobileMenu" class="mobile-menu lg:hidden border-t border-gray-200">
                <div class="px-2 pt-4 pb-6 space-y-2">
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('home') ? 'text-white gradient-primary' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        Home
                    </a>
                    <a href="{{ route('courses.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('courses.*') ? 'text-white gradient-primary' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        Courses
                    </a>
                    <a href="{{ route('about') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('about') ? 'text-white gradient-primary' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        About
                    </a>
                    <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('contact') ? 'text-white gradient-primary' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        Contact
                    </a>
                    <div class="pt-4 space-y-2">
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-gray-100 transition-all">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl text-base font-black text-white gradient-primary text-center shadow-lg">
                            Get Started Free
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="fixed top-24 right-4 z-50 space-y-3 max-w-md" id="flashMessages">
        @if(session('success'))
            <div class="notification-enter glass-effect rounded-2xl shadow-2xl border border-green-200 p-5 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-green-900 text-base">Success!</p>
                    <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-green-500 hover:text-green-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="notification-enter glass-effect rounded-2xl shadow-2xl border border-red-200 p-5 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-red-900 text-base">Error!</p>
                    <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-red-500 hover:text-red-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div class="notification-enter glass-effect rounded-2xl shadow-2xl border border-yellow-200 p-5 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-yellow-900 text-base">Warning!</p>
                    <p class="text-yellow-700 text-sm mt-1">{{ session('warning') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-yellow-500 hover:text-yellow-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="notification-enter glass-effect rounded-2xl shadow-2xl border border-blue-200 p-5 flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-blue-900 text-base">Info!</p>
                    <p class="text-blue-700 text-sm mt-1">{{ session('info') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-blue-500 hover:text-blue-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    <!-- Professional Footer -->
    <footer class="relative overflow-hidden bg-gradient-to-br from-black via-gray-900 to-black text-white">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-14 h-14 gradient-success rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black">IKICBC LMS</h2>
                            <p class="text-yellow-300 text-sm font-medium">Transform Your Future</p>
                        </div>
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6 text-base max-w-md">
                        Empowering learners worldwide with cutting-edge courses and expert instructors. Join thousands of students advancing their careers through quality education.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-black mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2 group">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Browse Courses</span>
                        </a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2 group">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>About Us</span>
                        </a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2 group">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Contact Us</span>
                        </a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2 group">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Create Account</span>
                        </a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-black mb-6">Get In Touch</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3 text-gray-300">
                            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-white">Email</p>
                                <a href="mailto:info@IKICBC.com" class="hover:text-white transition-colors">info@IKICBC.com</a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-300">
                            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-white">Phone</p>
                                <span>+94 XX XXX XXXX</span>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-300">
                            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-white">Location</p>
                                <span>Colombo, Sri Lanka</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-16 pt-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} <span class="font-bold text-white">IKICBC Learning Management System</span>. All rights reserved.
                    </p>
                    <div class="flex space-x-6 text-sm">
                        <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="{{ route('terms') }}" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                        <a href="{{ route('cookies') }}" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollTop" class="fixed bottom-8 right-8 w-14 h-14 gradient-primary rounded-full shadow-2xl flex items-center justify-center text-white opacity-0 invisible transition-all duration-300 hover:scale-110 z-40" onclick="scrollToTop()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }

        // Scroll to Top
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Show/Hide Scroll to Top Button
        window.addEventListener('scroll', function() {
            const scrollTop = document.getElementById('scrollTop');
            const navbar = document.getElementById('navbar');

            if (window.pageYOffset > 300) {
                scrollTop.classList.remove('opacity-0', 'invisible');
                scrollTop.classList.add('opacity-100', 'visible');
            } else {
                scrollTop.classList.add('opacity-0', 'invisible');
                scrollTop.classList.remove('opacity-100', 'visible');
            }

            // Navbar shadow on scroll
            if (window.pageYOffset > 10) {
                navbar.classList.add('shadow-2xl');
            } else {
                navbar.classList.remove('shadow-2xl');
            }
        });

        // Auto-hide flash messages
        setTimeout(() => {
            const flashMessages = document.getElementById('flashMessages');
            if (flashMessages && flashMessages.children.length > 0) {
                Array.from(flashMessages.children).forEach((msg, index) => {
                    setTimeout(() => {
                        msg.style.transition = 'all 0.5s ease-out';
                        msg.style.transform = 'translateX(400px)';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500);
                    }, 5000 + (index * 500));
                });
            }
        }, 100);

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileButton = event.target.closest('button[onclick="toggleMobileMenu()"]');

            if (!mobileButton && !mobileMenu.contains(event.target) && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
