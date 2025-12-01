@extends('layouts.app')

@section('title', 'Checkout - IKICB LMS')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-indigo-600 px-6 py-8">
                <h1 class="text-2xl font-bold text-white">Complete Your Purchase</h1>
                <p class="mt-2 text-indigo-100">Secure payment powered by PayHere</p>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-8 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                @if(isset($course))
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-medium text-gray-900">{{ $course->title }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Full Course Access</p>
                            <p class="mt-1 text-xs text-gray-500">Instructor: {{ $course->instructor->name }}</p>
                        </div>
                        <div class="ml-4 text-right">
                            <p class="text-xl font-bold text-indigo-600">
                                LKR {{ number_format($paymentData['amount'], 2) }}
                            </p>
                        </div>
                    </div>
                @elseif(isset($module))
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-medium text-gray-900">{{ $module->course->title }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Module: {{ $module->title }}</p>
                        </div>
                        <div class="ml-4 text-right">
                            <p class="text-xl font-bold text-indigo-600">
                                LKR {{ number_format($paymentData['amount'], 2) }}
                            </p>
                        </div>
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-900">LKR {{ number_format($paymentData['amount'], 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-2">
                        <span class="text-gray-600">Tax</span>
                        <span class="text-gray-900">LKR 0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold mt-4 pt-4 border-t border-gray-200">
                        <span class="text-gray-900">Total</span>
                        <span class="text-indigo-600">LKR {{ number_format($paymentData['amount'], 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="px-6 py-8">
                <form method="post" action="https://{{ config('services.payhere.sandbox') ? 'sandbox' : 'www' }}.payhere.lk/pay/checkout">
                    <input type="hidden" name="merchant_id" value="{{ $paymentData['merchant_id'] }}">
                    <input type="hidden" name="return_url" value="{{ $paymentData['return_url'] }}">
                    <input type="hidden" name="cancel_url" value="{{ $paymentData['cancel_url'] }}">
                    <input type="hidden" name="notify_url" value="{{ $paymentData['notify_url'] }}">

                    <input type="hidden" name="order_id" value="{{ $paymentData['order_id'] }}">
                    <input type="hidden" name="items" value="{{ $paymentData['items'] }}">
                    <input type="hidden" name="currency" value="{{ $paymentData['currency'] }}">
                    <input type="hidden" name="amount" value="{{ $paymentData['amount'] }}">

                    <input type="hidden" name="first_name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="last_name" value="">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" name="phone" value="">
                    <input type="hidden" name="address" value="">
                    <input type="hidden" name="city" value="">
                    <input type="hidden" name="country" value="Sri Lanka">

                    <input type="hidden" name="hash" value="{{ $paymentData['hash'] }}">

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-blue-800">Secure Payment</h3>
                                <p class="mt-1 text-sm text-blue-700">
                                    You will be redirected to PayHere's secure payment gateway to complete your purchase.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Proceed to Payment
                        </button>

                        @if(isset($course))
                            <a href="{{ route('courses.show', $course) }}" class="block w-full text-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                        @elseif(isset($module))
                            <a href="{{ route('courses.show', $module->course) }}" class="block w-full text-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                        @endif
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Secure SSL encrypted payment</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Protected by PayHere Payment Gateway</p>
        </div>
    </div>
</div>
@endsection
