@extends('layouts.guest')

@section('title', 'Payment History - Dashboard')

@section('content')
<!-- Hero Header -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-white mb-2">
                    Payment History
                </h1>
                <p class="text-lg text-gray-300">View all your transactions and payment records</p>
            </div>
            @if($payments->count() > 0)
                <div class="hidden sm:flex items-center space-x-4">
                    <div class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
                        <span class="text-sm text-gray-300">Total Payments:</span>
                        <span class="text-xl font-black text-yellow-500 ml-2">{{ $payments->total() }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
            <a href="{{ route('dashboard') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                Overview
            </a>
            <a href="{{ route('dashboard.my-courses') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                My Courses
            </a>
            <a href="{{ route('dashboard.payments') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-yellow-500 text-yellow-600 font-black text-sm">
                Payments
            </a>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-yellow-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Payments Table -->
        @if($payments->count() > 0)
            <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 overflow-hidden">
                <!-- Mobile View - Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @foreach($payments as $payment)
                        <div class="p-6 hover:bg-yellow-50 transition-colors">
                            <!-- Date and Status -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $payment->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->created_at->format('h:i A') }}</div>
                                </div>
                                @if($payment->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Completed
                                    </span>
                                @elseif($payment->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($payment->status === 'failed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                        Failed
                                    </span>
                                @endif
                            </div>

                            <!-- Item Info -->
                            <div class="mb-3">
                                @if($payment->course)
                                    <div class="font-black text-gray-900 mb-1">{{ $payment->course->title }}</div>
                                    <div class="text-sm text-gray-500">Full Course</div>
                                @elseif($payment->module)
                                    <div class="font-black text-gray-900 mb-1">{{ $payment->module->course->title }}</div>
                                    <div class="text-sm text-gray-500">Module: {{ $payment->module->title }}</div>
                                @endif
                            </div>

                            <!-- Type and Amount -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                <div>
                                    @if($payment->module_id)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            Module
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                            Course
                                        </span>
                                    @endif
                                </div>
                                <div class="text-2xl font-black text-gradient">
                                    LKR {{ number_format($payment->amount, 2) }}
                                </div>
                            </div>

                            <!-- Transaction ID -->
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <div class="text-xs text-gray-500 mb-1">Transaction ID</div>
                                <div class="text-sm font-mono text-gray-900">{{ $payment->transaction_id }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop View - Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-900 to-black">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-yellow-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-yellow-500 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-yellow-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-yellow-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-yellow-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-yellow-500 uppercase tracking-wider">Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-yellow-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $payment->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($payment->course)
                                            <div class="font-black text-gray-900">{{ $payment->course->title }}</div>
                                            <div class="text-xs text-gray-500">Full Course</div>
                                        @elseif($payment->module)
                                            <div class="font-black text-gray-900">{{ $payment->module->course->title }}</div>
                                            <div class="text-xs text-gray-500">Module: {{ $payment->module->title }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payment->module_id)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                Module
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                Course
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-black text-gradient">
                                            LKR {{ number_format($payment->amount, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payment->status === 'completed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Completed
                                            </span>
                                        @elseif($payment->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Pending
                                            </span>
                                        @elseif($payment->status === 'failed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                        {{ $payment->transaction_id }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                    <div class="px-6 py-4 border-t-2 border-yellow-200 bg-gradient-to-r from-yellow-50 to-white">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200 mb-6">
                        <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 mb-3">No Payments Yet</h3>
                    <p class="text-gray-600 text-lg mb-8">You haven't made any payments. Start learning by enrolling in a course!</p>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Browse Courses
                    </a>
                </div>
            </div>
        @endif
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
