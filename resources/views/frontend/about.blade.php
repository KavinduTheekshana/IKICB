@extends('layouts.guest')

@section('title', 'About Us - Empowering Learners Worldwide | IKICB')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div
                class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 mb-6">
                <span class="text-sm font-bold text-yellow-500">🎯 About IKICB</span>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6 animate-fade-in-up">
                Empowering Learners <br class="hidden sm:block">Worldwide
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto animate-fade-in">
                Building the future of education through innovative learning solutions
            </p>
        </div>
    </div>

    <!-- Mission Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="space-y-6">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200">
                        <span class="text-sm font-bold text-gray-900">OUR MISSION</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black text-gray-900">
                        Transform Lives Through <span class="text-gradient">Quality Education</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        At IKICB Learning Management System, we believe education is the key to unlocking human potential.
                        Our mission is to provide accessible, high-quality education to learners around the world, enabling
                        them to achieve their personal and professional goals.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        We combine cutting-edge technology with proven teaching methodologies to deliver an exceptional
                        learning experience that empowers students to succeed in today's rapidly evolving world.
                    </p>
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="aspect-square rounded-3xl bg-gradient-to-br from-yellow-100 to-yellow-200 p-8">
                        <div class="w-full h-full rounded-2xl bg-white shadow-2xl p-12 flex items-center justify-center">
                            <svg class="w-full h-full text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5"
                                    d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Offer Section -->
    <section class="py-20 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                    <span class="text-sm font-bold text-gray-900">WHAT WE OFFER</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Everything You Need to <span class="text-gradient">Succeed</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive learning solutions designed to help you achieve your goals
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Offer 1 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                    <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Expert-Led Courses</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Learn from industry professionals with years of real-world experience across multiple disciplines.
                    </p>
                </div>

                <!-- Offer 2 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                    <div class="w-16 h-16 rounded-2xl gradient-secondary flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Flexible Learning</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Study at your own pace with lifetime access to all course materials and resources.
                    </p>
                </div>

                <!-- Offer 3 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                    <div class="w-16 h-16 rounded-2xl gradient-success flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Interactive Assessments</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Test your knowledge with practical assignments and get instant feedback on your performance.
                    </p>
                </div>

                <!-- Offer 4 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Affordable Pricing</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Flexible payment options that fit your budget - pay per course or per module.
                    </p>
                </div>

                <!-- Offer 5 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-cyan-500 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Verified Certificates</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Earn industry-recognized certificates upon completion to showcase your skills.
                    </p>
                </div>

                <!-- Offer 6 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">24/7 Support</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Get help whenever you need it from our dedicated support team.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-black text-gradient mb-2">500+</div>
                    <div class="text-gray-600 font-semibold">Expert Courses</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-black text-gradient mb-2">50K+</div>
                    <div class="text-gray-600 font-semibold">Active Students</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-black text-gradient mb-2">98%</div>
                    <div class="text-gray-600 font-semibold">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-black text-gradient mb-2">4.9★</div>
                    <div class="text-gray-600 font-semibold">Average Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-gradient-to-br from-gray-900 via-black to-gray-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-black text-white mb-4">
                    Why Choose IKICB?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    We're committed to providing the best learning experience
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                    <div class="text-yellow-500 text-4xl font-black mb-4">01</div>
                    <h3 class="text-2xl font-black text-white mb-3">Cutting-Edge Technology</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Our platform uses the latest technology to provide seamless learning experiences across all devices.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                    <div class="text-yellow-500 text-4xl font-black mb-4">02</div>
                    <h3 class="text-2xl font-black text-white mb-3">Proven Methodologies</h3>
                    <p class="text-gray-300 leading-relaxed">
                        We combine traditional teaching methods with modern innovations for maximum effectiveness.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                    <div class="text-yellow-500 text-4xl font-black mb-4">03</div>
                    <h3 class="text-2xl font-black text-white mb-3">Student-Centric Approach</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Every feature is designed with your success in mind, from course structure to support systems.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-3xl p-12 text-center border-2 border-yellow-200">
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6">
                    Ready to Start Your Learning Journey?
                </h2>
                <p class="text-xl text-gray-700 mb-8 max-w-2xl mx-auto">
                    Join thousands of students who are already transforming their careers with IKICB
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('courses.index') }}"
                        class="px-10 py-5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black text-lg shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300">
                        Browse Courses
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-10 py-5 bg-white border-2 border-gray-300 rounded-2xl text-gray-900 font-black text-lg hover:border-yellow-500 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Get Started Free
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
