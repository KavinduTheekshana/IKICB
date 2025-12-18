@extends('layouts.guest')

@section('title', 'Courses Overview - Professional Training Programs | IKICBC')
@section('description', 'Explore our comprehensive range of professional beauty and cosmetology courses. From Bridal Dresser to Beautician NVQ 4 certifications, advance your career with IKICBC.')
@section('keywords', 'beauty courses, cosmetology training, NVQ 4, bridal dresser, beautician course, professional training, IKICBC')

@section('og_title', 'Courses Overview - Professional Beauty Training Programs')
@section('og_description', 'Discover our key courses including Bridal Dresser NVQ 4, Beautician NVQ 4, Advanced Diploma in Cosmetology, and Master Bridal Diploma.')

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
                    Courses Overview
                </h1>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto animate-fade-in mb-8">
                    Explore our comprehensive range of professional beauty and cosmetology training programs designed to transform your career
                </p>
            </div>
        </div>
    </div>

    <!-- Course 1: Bridal Dresser NVQ 4 -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                    <span class="text-sm font-bold text-gray-900">COURSE 01</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Bridal Dresser <span class="text-gradient">NVQ 4</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl">
                    Master the art of bridal styling and makeup with our comprehensive NVQ Level 4 certification program.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-yellow-50 to-gray-50 rounded-2xl p-6 border border-yellow-100">
                        <h3 class="text-xl font-black text-gray-900 mb-4">Course Overview</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            This specialized program trains you in the art of bridal makeup, hairstyling, and dressing. Learn traditional and modern bridal styling techniques to create stunning looks for the most important day in your clients' lives.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Professional bridal makeup techniques</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Traditional and contemporary bridal hairstyles</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Saree draping and dressing techniques</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Client consultation and styling advice</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="aspect-video bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-3xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/team-bride-celebrating-before-wedding-2.jpg') }}" alt="Bridal Dresser Course" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course 2: Beautician NVQ 4 -->
    <section class="py-20 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                    <span class="text-sm font-bold text-gray-900">COURSE 02</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Beautician <span class="text-gradient">NVQ 4</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl">
                    Become a certified professional beautician with comprehensive training in all beauty techniques.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg">
                        <h3 class="text-xl font-black text-gray-900 mb-4">Course Overview</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            The NVQ Level 4 Beautician Course is a highly recognized vocational qualification that certifies an individual's professional competency in the beauty care sector. Achieving Level 4 signifies that the trainee possesses a solid understanding of fundamental beauty treatments and practical skills to work independently as a skilled beautician.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg">
                        <h3 class="text-xl font-black text-gray-900 mb-4">Theory Component</h3>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Anatomy & Physiology</h4>
                                    <p class="text-sm text-gray-600">In-depth study of skin, hair, nails, and their functions</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Skin Analysis & Classification</h4>
                                    <p class="text-sm text-gray-600">Identifying skin types and developing care plans</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Product Knowledge & Chemistry</h4>
                                    <p class="text-sm text-gray-600">Understanding cosmetic ingredients and product handling</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">4</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Hygiene & Infection Control</h4>
                                    <p class="text-sm text-gray-600">Sterilization, disinfection, and PPE protocols</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">5</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Health & Safety</h4>
                                    <p class="text-sm text-gray-600">Safe working environment and emergency procedures</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="aspect-video bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-3xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/make-up-artist-applying-eyeshadow-face-with-brush-2.jpg') }}" alt="Beautician Course" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course 3: Advanced Diploma in Cosmetology -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                    <span class="text-sm font-bold text-gray-900">COURSE 03</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Advanced Diploma in <span class="text-gradient">Cosmetology</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl">
                    Advanced professional training covering all aspects of modern cosmetology and beauty therapy.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="aspect-video bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-3xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/make-up-artist-applying-eyeshadow-face-with-brush-2.jpg') }}" alt="Advanced Cosmetology" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-yellow-50 to-gray-50 rounded-2xl p-6 border border-yellow-100">
                        <h3 class="text-xl font-black text-gray-900 mb-4">Course Overview</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Our Advanced Diploma in Cosmetology is designed for those seeking comprehensive, professional-level training. This intensive program covers advanced techniques in all areas of beauty therapy and cosmetology.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Advanced skincare treatments and therapies</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Professional makeup artistry</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Hair styling and coloring techniques</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Nail technology and artistry</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Spa treatments and wellness therapies</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Business management for beauty professionals</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course 4: Master Bridal Diploma -->
    <section class="py-20 bg-gradient-to-br from-yellow-50 via-gray-50 to-yellow-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 mb-4">
                    <span class="text-sm font-bold text-gray-900">COURSE 04</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Master Bridal <span class="text-gradient">Diploma</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl">
                    Elite-level training for aspiring master bridal dressers with hands-on experience.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg">
                        <h3 class="text-xl font-black text-gray-900 mb-4">Course Overview</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            The Master Bridal Diploma is our most prestigious bridal training program. This elite course is designed for serious professionals who want to become leading experts in bridal makeup and styling. Perfect for those aiming to establish themselves as master bridal dressers.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Master-level bridal makeup techniques</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Advanced hairstyling and hair accessories</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Portfolio building and branding</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Real wedding assignments and practical experience</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Business development for bridal professionals</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="aspect-video bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-3xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/team-bride-celebrating-before-wedding-2.jpg') }}" alt="Master Bridal Diploma" class="w-full h-full object-cover">
                    </div>
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
                Ready to Start Your Journey?
            </h2>
            <p class="text-xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                Choose the course that matches your career goals and start your transformation today with IKICBC.
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
                <a href="{{ route('contact') }}" class="px-10 py-5 bg-transparent border-2 border-yellow-500 rounded-2xl text-yellow-500 font-black text-lg hover:bg-yellow-500 hover:text-gray-900 transform hover:scale-105 transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </section>
@endsection
