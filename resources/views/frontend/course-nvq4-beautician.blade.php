@extends('layouts.guest')

@section('title', 'NVQ Level 4 Beautician Course - Professional Beauty Training | IKICBC')
@section('description', 'The NVQ Level 4 Beautician Course is a highly recognized vocational qualification that certifies professional competency in the beauty care sector. Learn theory and practical skills to work independently as a skilled beautician.')
@section('keywords', 'NVQ Level 4 Beautician, beauty course, vocational qualification, beauty training, professional beautician, cosmetology course, IKICBC')

@section('og_title', 'NVQ Level 4 Beautician - Professional Beauty Training')
@section('og_description', 'Achieve Level 4 certification and gain professional competency in the beauty care sector with comprehensive theory and practical training.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 mb-6">
                    <span class="text-sm font-bold text-yellow-500">PROFESSIONAL CERTIFICATION</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6 animate-fade-in-up">
                    NVQ Level 4 <br class="hidden sm:block">Beautician Course
                </h1>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto animate-fade-in mb-8">
                    A highly recognized vocational qualification that certifies your professional competency in the beauty care sector
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl text-gray-900 font-black text-lg shadow-lg hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300">
                        Enroll Now
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-transparent border-2 border-yellow-500 rounded-xl text-yellow-500 font-black text-lg hover:bg-yellow-500 hover:text-gray-900 transform hover:scale-105 transition-all duration-300">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Overview Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Course Description -->
                <div class="space-y-6">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200">
                        <span class="text-sm font-bold text-gray-900">COURSE OVERVIEW</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black text-gray-900">
                        About This <span class="text-gradient">Course</span>
                    </h2>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        The NVQ Level 4 Beautician Course is a highly recognized vocational qualification that certifies an individual's professional competency in the beauty care sector.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Achieving Level 4 signifies that the trainee possesses a solid understanding of fundamental beauty treatments and practical skills to work independently as a skilled beautician.
                    </p>

                    <!-- Key Benefits -->
                    <div class="bg-gradient-to-br from-yellow-50 to-gray-50 rounded-2xl p-6 border border-yellow-100">
                        <h3 class="text-xl font-black text-gray-900 mb-4">What You'll Gain</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Industry-recognized NVQ Level 4 certification</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Comprehensive theoretical knowledge</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Hands-on practical skills training</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Ability to work independently as a professional beautician</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Course Image -->
                <div class="relative">
                    <div class="aspect-square rounded-3xl bg-gradient-to-br from-yellow-100 to-yellow-200 p-8">
                        <div class="w-full h-full rounded-2xl bg-white shadow-2xl overflow-hidden">
                            <img src="{{ asset('images/make-up-artist-applying-eyeshadow-face-with-brush-2.jpg') }}" alt="NVQ Level 4 Beautician Course" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theory Component Section -->
    <section class="py-20 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                    <span class="text-sm font-bold text-gray-900">CURRICULUM</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Theory <span class="text-gradient">Component</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    The theoretical modules are crucial for building a strong foundation and understanding the scientific aspects behind beauty treatments
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Module 1 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">1</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Anatomy & Physiology</h3>
                        </div>
                    </div>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>In-depth study of the skin, hair, nails, and their basic functions</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Understanding how different treatments affect the body's systems</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Crucial for accurately identifying contraindications (conditions that prevent a treatment)</span>
                        </li>
                    </ul>
                </div>

                <!-- Module 2 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">2</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Skin Analysis & Classification</h3>
                        </div>
                    </div>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Methods for identifying skin types (dry, oily, combination, sensitive) and skin conditions (pigmentation, acne, hydration levels)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Developing suitable care plans for each specific skin type</span>
                        </li>
                    </ul>
                </div>

                <!-- Module 3 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">3</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Product Knowledge & Chemistry</h3>
                        </div>
                    </div>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Understanding the basic chemical ingredients and active functions of various cosmetic products (creams, serums, toners)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>The concept of skin pH and how products affect it</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Proper handling and storage procedures for products</span>
                        </li>
                    </ul>
                </div>

                <!-- Module 4 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">4</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Hygiene & Infection Control</h3>
                        </div>
                    </div>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Principles of preventing the spread of infection (cross-contamination)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Standardized methods for sterilization and disinfection of tools and the workspace</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>The correct use of Personal Protective Equipment (PPE)</span>
                        </li>
                    </ul>
                </div>

                <!-- Module 5 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 md:col-span-2">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">5</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Health & Safety</h3>
                        </div>
                    </div>
                    <ul class="grid md:grid-cols-2 gap-3 text-gray-700">
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Creating a safe working environment for both the beautician and the client</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Proper posture and ergonomics to prevent work-related injuries</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-yellow-600 mt-1">•</span>
                            <span>Emergency procedures and first aid basics</span>
                        </li>
                    </ul>
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
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6">
                Ready to Start Your Beauty Career?
            </h2>
            <p class="text-xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                Join our NVQ Level 4 Beautician course and become a certified professional beautician with comprehensive training in all beauty techniques.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('register') }}" class="group px-10 py-5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl text-gray-900 font-black text-lg shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all duration-300">
                    <span class="flex items-center justify-center space-x-2">
                        <span>Enroll Now</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>
                <a href="{{ route('courses.index') }}" class="px-10 py-5 bg-transparent border-2 border-yellow-500 rounded-2xl text-yellow-500 font-black text-lg hover:bg-yellow-500 hover:text-gray-900 transform hover:scale-105 transition-all duration-300">
                    View All Courses
                </a>
            </div>
        </div>
    </section>
@endsection
