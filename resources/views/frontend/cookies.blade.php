@extends('layouts.guest')

@section('title', 'Cookie Policy - IKICB')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-black text-white mb-4">Cookie Policy</h1>
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
                    This Cookie Policy explains how IKICB Learning Management System uses cookies and similar tracking technologies to recognize you when you visit our platform. It explains what these technologies are, why we use them, and your rights to control our use of them.
                </p>
            </div>

            <!-- 1. What Are Cookies -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">1</span>
                    What Are Cookies?
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Cookies are small text files that are placed on your computer or mobile device when you visit a website. They are widely used to make websites work more efficiently and provide information to website owners.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Cookies can be "persistent" or "session" cookies. Persistent cookies remain on your device when you go offline, while session cookies are deleted as soon as you close your web browser.
                </p>
            </section>

            <!-- 2. How We Use Cookies -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">2</span>
                    How We Use Cookies
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We use cookies for the following purposes:
                </p>

                <div class="space-y-6">
                    <!-- Essential Cookies -->
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 border-2 border-yellow-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Essential Cookies</h3>
                        <p class="text-gray-700 leading-relaxed mb-3">
                            These cookies are necessary for the platform to function and cannot be switched off in our systems. They are usually only set in response to actions made by you, such as:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                            <li>Logging in to your account</li>
                            <li>Remembering your privacy settings</li>
                            <li>Maintaining your session</li>
                            <li>Ensuring security and fraud prevention</li>
                        </ul>
                    </div>

                    <!-- Performance Cookies -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border-2 border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Performance Cookies</h3>
                        <p class="text-gray-700 leading-relaxed mb-3">
                            These cookies allow us to count visits and traffic sources to measure and improve the performance of our platform:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                            <li>Tracking which pages are most and least popular</li>
                            <li>Understanding how visitors move around the site</li>
                            <li>Identifying technical issues</li>
                            <li>Improving user experience</li>
                        </ul>
                    </div>

                    <!-- Functionality Cookies -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border-2 border-blue-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Functionality Cookies</h3>
                        <p class="text-gray-700 leading-relaxed mb-3">
                            These cookies enable enhanced functionality and personalization:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                            <li>Remembering your preferences and settings</li>
                            <li>Personalizing content based on your interests</li>
                            <li>Saving your course progress</li>
                            <li>Remembering your language preferences</li>
                        </ul>
                    </div>

                    <!-- Analytics Cookies -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border-2 border-green-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Analytics Cookies</h3>
                        <p class="text-gray-700 leading-relaxed mb-3">
                            We use analytics cookies to understand how you use our platform:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                            <li>Google Analytics for website traffic analysis</li>
                            <li>Understanding user behavior and engagement</li>
                            <li>Measuring marketing campaign effectiveness</li>
                            <li>Identifying areas for improvement</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- 3. Third-Party Cookies -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">3</span>
                    Third-Party Cookies
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    In addition to our own cookies, we may also use various third-party cookies to report usage statistics and deliver content:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li><strong>Google Analytics:</strong> For website analytics and understanding user behavior</li>
                    <li><strong>Payment Processors:</strong> For secure payment processing</li>
                    <li><strong>Video Hosting:</strong> For delivering educational video content</li>
                    <li><strong>Social Media:</strong> For social sharing functionality</li>
                </ul>
            </section>

            <!-- 4. Managing Cookies -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">4</span>
                    Managing Cookies
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700 mb-4">
                    <li>Setting or amending your web browser controls</li>
                    <li>Using cookie preference tools provided on our platform</li>
                    <li>Opting out of third-party cookies through their websites</li>
                </ul>
                <p class="text-gray-700 leading-relaxed">
                    Most web browsers allow you to control cookies through their settings. However, if you limit the ability of websites to set cookies, you may impact your overall user experience.
                </p>
            </section>

            <!-- 5. Browser Controls -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">5</span>
                    Browser Controls
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    To learn more about how to manage cookies in your specific browser, please visit:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li><strong>Chrome:</strong> <a href="https://support.google.com/chrome/answer/95647" target="_blank" class="text-yellow-600 hover:text-yellow-700 font-bold">Google Chrome Cookie Settings</a></li>
                    <li><strong>Firefox:</strong> <a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer" target="_blank" class="text-yellow-600 hover:text-yellow-700 font-bold">Mozilla Firefox Cookie Settings</a></li>
                    <li><strong>Safari:</strong> <a href="https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac" target="_blank" class="text-yellow-600 hover:text-yellow-700 font-bold">Safari Cookie Settings</a></li>
                    <li><strong>Edge:</strong> <a href="https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" class="text-yellow-600 hover:text-yellow-700 font-bold">Microsoft Edge Cookie Settings</a></li>
                </ul>
            </section>

            <!-- 6. Do Not Track Signals -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">6</span>
                    Do Not Track Signals
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    Some browsers have a "Do Not Track" feature that lets you tell websites that you do not want to have your online activities tracked. We currently do not respond to browser "Do Not Track" signals.
                </p>
            </section>

            <!-- 7. Updates to This Policy -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">7</span>
                    Updates to This Policy
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We may update this Cookie Policy from time to time to reflect changes in our practices or for operational, legal, or regulatory reasons. Please revisit this Cookie Policy regularly to stay informed about our use of cookies.
                </p>
            </section>

            <!-- 8. Contact Us -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">8</span>
                    Contact Us
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you have any questions about our use of cookies, please contact us:
                </p>
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 border-2 border-yellow-200">
                    <p class="text-gray-900 font-semibold">IKICB Learning Management System</p>
                    <p class="text-gray-700">Email: <a href="mailto:privacy@ikicb.com" class="text-yellow-600 hover:text-yellow-700 font-bold">privacy@ikicb.com</a></p>
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
