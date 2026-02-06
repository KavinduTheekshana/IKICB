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

            <!-- Payment Method Selection -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Select Payment Method</h2>
                <div class="space-y-3">
                    <label class="relative flex items-center p-4 cursor-pointer border-2 border-gray-200 rounded-lg hover:border-indigo-500 transition-colors">
                        <input type="radio" name="payment_method" value="payhere" checked class="sr-only peer" onchange="togglePaymentForms()">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">PayHere Online Payment</p>
                                    <p class="text-sm text-gray-500">Pay securely with cards or e-wallet</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 10">
                                <path d="M10.97 1.97a.75.75 0 011.06 1.06l-6.5 6.5a.75.75 0 01-1.06 0l-3-3a.75.75 0 111.06-1.06L4.97 7.94l5.97-5.97z"/>
                            </svg>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 cursor-pointer border-2 border-gray-200 rounded-lg hover:border-indigo-500 transition-colors">
                        <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer" onchange="togglePaymentForms()">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Bank Transfer</p>
                                    <p class="text-sm text-gray-500">Pay via bank deposit and upload receipt</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-green-600 peer-checked:bg-green-600 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 10">
                                <path d="M10.97 1.97a.75.75 0 011.06 1.06l-6.5 6.5a.75.75 0 01-1.06 0l-3-3a.75.75 0 111.06-1.06L4.97 7.94l5.97-5.97z"/>
                            </svg>
                        </div>
                    </label>
                </div>
            </div>

            <!-- PayHere Payment Form -->
            <div class="px-6 py-8" id="payhere-form">
                <form method="post" action="{{ route('payment.payhere.process') }}" id="payhere-payment-form">
                    @csrf
                    <input type="hidden" name="merchant_id" value="{{ $paymentData['merchant_id'] }}">
                    <input type="hidden" name="return_url" value="{{ $paymentData['return_url'] }}">
                    <input type="hidden" name="cancel_url" value="{{ $paymentData['cancel_url'] }}">
                    <input type="hidden" name="notify_url" value="{{ $paymentData['notify_url'] }}">

                    <input type="hidden" name="order_id" value="{{ $paymentData['order_id'] }}">
                    <input type="hidden" name="items" value="{{ $paymentData['items'] }}">
                    <input type="hidden" name="currency" value="{{ $paymentData['currency'] }}">
                    <input type="hidden" name="amount" value="{{ $paymentData['amount'] }}">
                    <input type="hidden" name="course_id" value="{{ $paymentData['course_id'] }}">
                    <input type="hidden" name="module_id" value="{{ $paymentData['module_id'] }}">
                    <input type="hidden" name="type" value="{{ $paymentData['type'] }}">

                    @php
                        $nameParts = explode(' ', auth()->user()->name, 2);
                        $firstName = $nameParts[0] ?? 'User';
                        $lastName = $nameParts[1] ?? '';
                    @endphp
                    <input type="hidden" name="first_name" value="{{ $firstName }}">
                    <input type="hidden" name="last_name" value="{{ $lastName }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" name="phone" value="0000000000">
                    <input type="hidden" name="address" value="N/A">
                    <input type="hidden" name="city" value="{{ Colombo }}">
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

            <!-- Bank Transfer Form -->
            <div class="px-6 py-8 hidden" id="bank-transfer-form">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Bank Transfer Instructions</h3>
                            <div class="mt-2 text-sm text-yellow-700 space-y-1">
                                <p><strong>Bank:</strong> Commercial Bank of Ceylon</p>
                                <p><strong>Account Name:</strong> IKICBC Learning Center</p>
                                <p><strong>Account Number:</strong> 1234567890</p>
                                <p><strong>Branch:</strong> Colombo</p>
                                <p class="mt-2">Please use your name as reference when making the transfer.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('payment.bank-transfer.submit') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($course))
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                    @elseif(isset($module))
                        <input type="hidden" name="module_id" value="{{ $module->id }}">
                    @endif
                    <input type="hidden" name="amount" value="{{ $paymentData['amount'] }}">

                    <div>
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Transaction Reference Number *
                        </label>
                        <input type="text" id="reference_number" name="reference_number" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your bank transfer reference number">
                        <p class="mt-1 text-xs text-gray-500">Enter the reference number from your bank transfer receipt</p>
                    </div>

                    <div>
                        <label for="receipt" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Payment Receipt *
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="receipt" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF (MAX. 5MB)</p>
                                </div>
                                <input id="receipt" name="receipt" type="file" class="hidden" accept="image/*,application/pdf" required onchange="displayFileName(this)">
                            </label>
                        </div>
                        <p id="file-name" class="mt-2 text-sm text-gray-600"></p>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Notes (Optional)
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Any additional information about your transfer..."></textarea>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-blue-800">Pending Approval</h3>
                                <p class="mt-1 text-sm text-blue-700">
                                    Your payment will be verified by our admin team. You'll receive access once approved (usually within 24 hours).
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="submit" style="background-color: #16a34a; color: white;" class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Submit Payment Proof
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
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Protected by PayHere Payment Gateway</p>
        </div>
    </div>
</div>

<script>
function togglePaymentForms() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    const payhereForm = document.getElementById('payhere-form');
    const bankTransferForm = document.getElementById('bank-transfer-form');

    if (paymentMethod === 'payhere') {
        payhereForm.classList.remove('hidden');
        bankTransferForm.classList.add('hidden');
    } else {
        payhereForm.classList.add('hidden');
        bankTransferForm.classList.remove('hidden');
    }
}

function displayFileName(input) {
    const fileNameDisplay = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        fileNameDisplay.textContent = `Selected: ${file.name} (${fileSize} MB)`;
        fileNameDisplay.classList.add('text-green-600', 'font-medium');
    }
}
</script>
@endsection
