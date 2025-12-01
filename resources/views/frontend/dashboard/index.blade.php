@extends('layouts.app')

@section('title', 'Dashboard - IKICB LMS')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="mt-2 text-gray-600">Continue your learning journey</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Enrolled Courses</dt>
                                <dd class="text-3xl font-semibold text-gray-900">{{ $enrollments->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Unlocked Modules</dt>
                                <dd class="text-3xl font-semibold text-gray-900">{{ $unlockedModules->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                                <dd class="text-3xl font-semibold text-gray-900">LKR {{ number_format($payments->where('status', 'completed')->sum('amount'), 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('dashboard') }}" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Overview
                </a>
                <a href="{{ route('dashboard.my-courses') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    My Courses
                </a>
                <a href="{{ route('dashboard.payments') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Payments
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Courses -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Continue Learning</h3>
                </div>
                <div class="p-6">
                    @forelse($enrollments->take(3) as $enrollment)
                        <div class="mb-6 last:mb-0">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900">{{ $enrollment->course->title }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mb-3">{{ $enrollment->course->modules->count() }} modules</p>
                            <a href="{{ route('courses.show', $enrollment->course) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Continue Course
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No enrolled courses yet. <a href="{{ route('courses.index') }}" class="text-indigo-600 hover:text-indigo-700">Browse courses</a></p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Payments</h3>
                </div>
                <div class="p-6">
                    @forelse($payments->take(5) as $payment)
                        <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-0 border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $payment->course->title }}
                                        @if($payment->module)
                                            - {{ $payment->module->title }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $payment->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="ml-4 text-right">
                                    <p class="text-sm font-semibold text-gray-900">LKR {{ number_format($payment->amount, 2) }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($payment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No payment history</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
