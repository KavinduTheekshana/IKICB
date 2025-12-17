@extends('layouts.guest')

@section('title', 'Contact Us - Get in Touch with IKICB | Support & Inquiries')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 mb-6">
            <span class="text-sm font-bold text-yellow-500">💬 Contact Us</span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6 animate-fade-in-up">
            Get in Touch <br class="hidden sm:block">with Our Team
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto animate-fade-in">
            We're here to help you with any questions or concerns
        </p>
    </div>
</div>

<!-- Contact Information Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Left - Contact Info Cards -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Let's Start a <span class="text-gradient">Conversation</span>
                    </h2>
                    <p class="text-lg text-gray-600">
                        Have questions about our courses, need technical support, or want to learn more about IKICB? Our team is ready to assist you.
                    </p>
                </div>

                <!-- Email Card -->
                <div class="group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-3xl p-8 border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 card-hover">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-black text-gray-900 mb-2">Email Us</h3>
                            <p class="text-gray-600 mb-3">Send us an email anytime</p>
                            <a href="mailto:ikbrideshub@gmail.com" class="text-lg font-bold text-yellow-600 hover:text-yellow-700 transition-colors">
                               ikbrideshub@gmail.com
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 border-2 border-gray-200 hover:border-yellow-400 transition-all duration-300 card-hover">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-2xl gradient-secondary flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-black text-gray-900 mb-2">Call Us</h3>
                            <p class="text-gray-600 mb-3">Available during business hours</p>
                            <a href="tel:+94777155515" class="text-lg font-bold text-gray-900 hover:text-yellow-600 transition-colors">
                               +947 77 155 515
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Location Card -->
                <div class="group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-3xl p-8 border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 card-hover">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-2xl gradient-success flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-black text-gray-900 mb-2">Visit Us</h3>
                            <p class="text-gray-600 mb-3">Our office location</p>
                            <p class="text-lg font-bold text-gray-900">
                                IKICBC <br>
                                Main Branch, Maharagama, Sri Lanka 
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right - Business Hours & Quick Info -->
            <div class="space-y-8">
                <!-- Business Hours Card -->
                <div class="bg-gradient-to-br from-gray-900 via-black to-gray-900 rounded-3xl p-8 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500 rounded-full filter blur-3xl"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-yellow-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-white">Support Hours</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-white/10">
                                <span class="text-gray-300 font-semibold">Monday - Friday</span>
                                <span class="text-white font-bold">9:00 AM - 5:00 PM</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-white/10">
                                <span class="text-gray-300 font-semibold">Saturday</span>
                                <span class="text-white font-bold">9:00 AM - 1:00 PM</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-300 font-semibold">Sunday</span>
                                <span class="text-red-400 font-bold">Closed</span>
                            </div>
                        </div>
                        <div class="mt-6 p-4 bg-yellow-500/10 rounded-2xl border border-yellow-500/20">
                            <p class="text-yellow-300 text-sm font-semibold">
                                💡 Email support is available 24/7. We'll respond within 24 hours.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links Card -->
                <div class="bg-white rounded-3xl p-8 shadow-lg border-2 border-gray-200">
                    <h3 class="text-2xl font-black text-gray-900 mb-6">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="{{ route('courses.index') }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-yellow-50 rounded-xl transition-all group">
                            <span class="font-bold text-gray-900 group-hover:text-yellow-600">Browse Courses</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-yellow-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('about') }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-yellow-50 rounded-xl transition-all group">
                            <span class="font-bold text-gray-900 group-hover:text-yellow-600">About Us</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-yellow-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 rounded-xl transition-all group shadow-lg">
                            <span class="font-bold text-gray-900">Create Account</span>
                            <svg class="w-5 h-5 text-gray-900 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Preview Section -->
<section class="py-20 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                <span class="text-sm font-bold text-gray-900">FREQUENTLY ASKED</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                Common <span class="text-gradient">Questions</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Quick answers to questions you may have
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-2">How do I enroll in a course?</h3>
                <p class="text-gray-600">
                    Simply browse our course catalog, select the course you're interested in, and click "Enroll Now". You can pay for the full course or individual modules.
                </p>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-2">What payment methods do you accept?</h3>
                <p class="text-gray-600">
                    We accept all major credit cards, debit cards, and online payment methods. You can also pay per module for flexible learning.
                </p>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-2">Do I get a certificate after completion?</h3>
                <p class="text-gray-600">
                    Yes! Upon successfully completing a course and passing all assessments, you'll receive a verified certificate of completion.
                </p>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-2">How long do I have access to course materials?</h3>
                <p class="text-gray-600">
                    You get lifetime access to all course materials once enrolled. Learn at your own pace without any time restrictions.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-gray-900 via-black to-gray-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl sm:text-5xl font-black text-white mb-6">
            Still Have Questions?
        </h2>
        <p class="text-xl text-gray-300 mb-12 max-w-3xl mx-auto">
            Our support team is ready to help you get started on your learning journey
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="mailto:info@ikicb.com" class="px-10 py-5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black text-lg shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300">
                <span class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Send Email</span>
                </span>
            </a>
            <a href="{{ route('courses.index') }}" class="px-10 py-5 bg-transparent border-2 border-yellow-500 rounded-2xl text-yellow-500 font-black text-lg hover:bg-yellow-500 hover:text-gray-900 transform hover:scale-105 transition-all duration-300">
                Explore Courses
            </a>
        </div>
    </div>
</section>
@endsection
