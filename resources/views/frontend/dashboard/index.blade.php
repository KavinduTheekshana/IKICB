@extends('layouts.guest')

@section('title', 'Dashboard - My Learning Journey | IKICB')

@section('content')
<!-- Hero Header -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-white mb-2">
                    Welcome back, <span class="text-gradient-light">{{ auth()->user()->name }}</span>!
                </h1>
                <p class="text-gray-300 text-lg">Continue your learning journey</p>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center space-x-3">
                    <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center shadow-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<section class="py-8 bg-gradient-to-br from-yellow-50 via-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Stat 1 -->
            <div class="group bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-yellow-200 hover:border-yellow-400 card-hover">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-600 mb-1">Enrolled Courses</p>
                        <p class="text-4xl font-black text-gradient">{{ $enrollments->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="group bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-200 hover:border-green-400 card-hover">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-600 mb-1">Unlocked Modules</p>
                        <p class="text-4xl font-black text-green-600">{{ $unlockedModules->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="group bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-gray-200 hover:border-yellow-400 card-hover">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl gradient-secondary flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-600 mb-1">Total Spent</p>
                        <p class="text-2xl font-black text-gray-900">LKR {{ number_format($payments->where('status', 'completed')->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Tabs -->
<section class="bg-white border-b border-gray-200 sticky top-20 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex space-x-8 -mb-px">
            <a href="{{ route('dashboard') }}" class="group inline-flex items-center py-4 px-1 border-b-4 border-yellow-500 text-yellow-600 font-black text-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Overview
            </a>
            <a href="{{ route('dashboard.my-courses') }}" class="group inline-flex items-center py-4 px-1 border-b-4 border-transparent text-gray-500 hover:text-yellow-600 hover:border-yellow-300 font-bold text-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                My Courses
            </a>
            <a href="{{ route('dashboard.payments') }}" class="group inline-flex items-center py-4 px-1 border-b-4 border-transparent text-gray-500 hover:text-yellow-600 hover:border-yellow-300 font-bold text-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Payments
            </a>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Continue Learning -->
            <div class="bg-gradient-to-br from-yellow-50 to-white rounded-3xl shadow-xl border-2 border-yellow-200 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <h3 class="text-xl font-black text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Continue Learning
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($enrollments->take(3) as $enrollment)
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100 group card-hover">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h4 class="text-lg font-black text-gray-900 mb-1 group-hover:text-yellow-600 transition-colors">
                                        {{ $enrollment->course->title }}
                                    </h4>
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ $enrollment->course->modules->count() }} modules
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                    Active
                                </span>
                            </div>
                            <a href="{{ route('courses.show', $enrollment->course) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold text-sm rounded-xl shadow-lg hover:shadow-yellow-500/50 transition-all transform hover:scale-105">
                                Continue Course
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 font-semibold mb-4">No enrolled courses yet</p>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl text-gray-900 font-bold shadow-lg hover:shadow-yellow-500/50 transition-all">
                                Browse Courses
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-br from-gray-900 via-black to-gray-900 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500 rounded-full filter blur-2xl"></div>
                    </div>
                    <h3 class="relative text-xl font-black text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Recent Payments
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($payments->take(5) as $payment)
                        <div class="bg-white rounded-2xl p-4 shadow-md hover:shadow-lg transition-all border border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 mb-1 truncate">
                                        {{ $payment->course->title }}
                                        @if($payment->module)
                                            <span class="text-gray-500">- {{ $payment->module->title }}</span>
                                        @endif
                                    </p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $payment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="ml-4 text-right flex-shrink-0">
                                    <p class="text-lg font-black text-gray-900 mb-1">LKR {{ number_format($payment->amount, 2) }}</p>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                        @if($payment->status === 'completed') bg-green-100 text-green-800 border border-green-200
                                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @else bg-red-100 text-red-800 border border-red-200
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 font-semibold">No payment history</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<section class="py-12 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-gray-900 mb-3">
                Quick <span class="text-gradient">Actions</span>
            </h2>
            <p class="text-gray-600">Explore more learning opportunities</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('courses.index') }}" class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all border-2 border-gray-200 hover:border-yellow-400 card-hover text-center">
                <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors">Browse Courses</h3>
                <p class="text-gray-600">Discover new learning opportunities</p>
            </a>

            <a href="{{ route('dashboard.my-courses') }}" class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all border-2 border-gray-200 hover:border-yellow-400 card-hover text-center">
                <div class="w-16 h-16 rounded-2xl gradient-secondary flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors">My Courses</h3>
                <p class="text-gray-600">View all your enrolled courses</p>
            </a>

            <a href="{{ route('dashboard.payments') }}" class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all border-2 border-gray-200 hover:border-yellow-400 card-hover text-center">
                <div class="w-16 h-16 rounded-2xl gradient-success flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors">Payment History</h3>
                <p class="text-gray-600">View all your transactions</p>
            </a>
        </div>
    </div>
</section>

<style>
    .text-gradient-light {
        background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection
