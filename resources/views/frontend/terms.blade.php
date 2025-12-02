@extends('layouts.guest')

@section('title', 'Terms and Conditions - IKICB')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-black text-white mb-4">Terms and Conditions</h1>
        <p class="text-lg text-gray-300">Last updated: {{ date('F d, Y') }}</p>
    </div>
</div>

<!-- Content Section -->
<div class="py-16 bg-gradient-to-br from-gray-50 via-white to-yellow-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-8 md:p-12">

            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-gray-700 leading-relaxed">
                    Welcome to IKICB Learning Management System. These Terms and Conditions govern your use of our platform and services. By accessing or using IKICB, you agree to be bound by these terms.
                </p>
            </div>

            <!-- 1. Acceptance of Terms -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">1</span>
                    Acceptance of Terms
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    By creating an account, accessing, or using any part of the IKICB platform, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our services.
                </p>
            </section>

            <!-- 2. User Accounts -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">2</span>
                    User Accounts
                </h2>
                <div class="space-y-3 text-gray-700">
                    <p class="leading-relaxed">When you create an account with IKICB, you must:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Provide accurate, current, and complete information</li>
                        <li>Maintain and update your information to keep it accurate</li>
                        <li>Maintain the security of your account credentials</li>
                        <li>Accept responsibility for all activities under your account</li>
                        <li>Notify us immediately of any unauthorized access or security breaches</li>
                    </ul>
                </div>
            </section>

            <!-- 3. Course Enrollment and Access -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">3</span>
                    Course Enrollment and Access
                </h2>
                <div class="space-y-3 text-gray-700">
                    <p class="leading-relaxed">Upon purchasing a course or module:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>You gain access to course materials for the duration specified</li>
                        <li>Access is personal and non-transferable</li>
                        <li>You may not share your login credentials with others</li>
                        <li>Downloaded materials are for personal use only</li>
                        <li>We reserve the right to revoke access for violations of these terms</li>
                    </ul>
                </div>
            </section>

            <!-- 4. Payment and Refunds -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">4</span>
                    Payment and Refunds
                </h2>
                <div class="space-y-3 text-gray-700">
                    <p class="leading-relaxed">All payments are processed securely. Please note:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Prices are listed in LKR (Sri Lankan Rupees)</li>
                        <li>Payment is required before accessing course content</li>
                        <li>Refunds may be available within 7 days of purchase if less than 20% of content has been accessed</li>
                        <li>Module purchases are subject to the same refund policy</li>
                        <li>We reserve the right to modify pricing at any time</li>
                    </ul>
                </div>
            </section>

            <!-- 5. Intellectual Property -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">5</span>
                    Intellectual Property
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    All content on IKICB, including but not limited to text, graphics, logos, videos, and software, is the property of IKICB or its content suppliers and is protected by intellectual property laws. You may not:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li>Reproduce, distribute, or publicly display any content without permission</li>
                    <li>Create derivative works from our content</li>
                    <li>Use content for commercial purposes without authorization</li>
                    <li>Remove copyright or proprietary notices</li>
                </ul>
            </section>

            <!-- 6. User Conduct -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">6</span>
                    User Conduct
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">You agree not to:</p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li>Use the platform for any unlawful purpose</li>
                    <li>Harass, abuse, or harm other users</li>
                    <li>Attempt to gain unauthorized access to any part of the platform</li>
                    <li>Interfere with the proper functioning of the platform</li>
                    <li>Upload viruses or malicious code</li>
                    <li>Engage in any form of automated data collection</li>
                </ul>
            </section>

            <!-- 7. Limitation of Liability -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">7</span>
                    Limitation of Liability
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    IKICB shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use or inability to use the service. We provide the platform "as is" without warranties of any kind, either express or implied.
                </p>
            </section>

            <!-- 8. Modifications to Terms -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">8</span>
                    Modifications to Terms
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We reserve the right to modify these Terms and Conditions at any time. Changes will be effective immediately upon posting. Your continued use of the platform after changes constitutes acceptance of the modified terms.
                </p>
            </section>

            <!-- 9. Contact Information -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">9</span>
                    Contact Information
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you have any questions about these Terms and Conditions, please contact us:
                </p>
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 border-2 border-yellow-200">
                    <p class="text-gray-900 font-semibold">IKICB Learning Management System</p>
                    <p class="text-gray-700">Email: <a href="mailto:support@ikicb.com" class="text-yellow-600 hover:text-yellow-700 font-bold">support@ikicb.com</a></p>
                    <p class="text-gray-700">Website: <a href="{{ route('home') }}" class="text-yellow-600 hover:text-yellow-700 font-bold">{{ config('app.url') }}</a></p>
                </div>
            </section>

            <!-- Back to Home -->
            <div class="mt-12 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
