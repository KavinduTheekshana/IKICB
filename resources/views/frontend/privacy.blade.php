@extends('layouts.guest')

@section('title', 'Privacy Policy - IKICB')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-black text-white mb-4">Privacy Policy</h1>
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
                    At IKICB Learning Management System, we are committed to protecting your privacy and personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform.
                </p>
            </div>

            <!-- 1. Information We Collect -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">1</span>
                    Information We Collect
                </h2>

                <h3 class="text-xl font-bold text-gray-900 mb-3 mt-6">Personal Information</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We collect information that you provide directly to us, including:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700 mb-6">
                    <li>Name and email address</li>
                    <li>Account credentials (username and password)</li>
                    <li>Payment information (processed securely through third-party providers)</li>
                    <li>Profile information and preferences</li>
                    <li>Communication preferences</li>
                </ul>

                <h3 class="text-xl font-bold text-gray-900 mb-3">Usage Information</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We automatically collect certain information about your device and how you interact with our platform:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li>Course enrollment and progress data</li>
                    <li>Quiz scores and assessment results</li>
                    <li>Device information (browser type, operating system)</li>
                    <li>IP address and location data</li>
                    <li>Cookies and similar tracking technologies</li>
                </ul>
            </section>

            <!-- 2. How We Use Your Information -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">2</span>
                    How We Use Your Information
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">We use the collected information to:</p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li>Provide, maintain, and improve our services</li>
                    <li>Process your transactions and manage your enrollments</li>
                    <li>Send you course updates, announcements, and educational content</li>
                    <li>Respond to your comments, questions, and support requests</li>
                    <li>Personalize your learning experience</li>
                    <li>Monitor and analyze usage patterns and trends</li>
                    <li>Detect, prevent, and address technical issues and fraudulent activity</li>
                    <li>Comply with legal obligations</li>
                </ul>
            </section>

            <!-- 3. Information Sharing and Disclosure -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">3</span>
                    Information Sharing and Disclosure
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We do not sell your personal information. We may share your information in the following circumstances:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li><strong>With Service Providers:</strong> We share information with third-party vendors who perform services on our behalf (payment processing, hosting, analytics)</li>
                    <li><strong>With Instructors:</strong> Course instructors may access student progress and performance data for their courses</li>
                    <li><strong>For Legal Reasons:</strong> When required by law or to protect our rights and safety</li>
                    <li><strong>Business Transfers:</strong> In connection with any merger, sale, or acquisition of all or a portion of our business</li>
                    <li><strong>With Your Consent:</strong> When you explicitly authorize us to share your information</li>
                </ul>
            </section>

            <!-- 4. Data Security -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">4</span>
                    Data Security
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700 mt-4">
                    <li>Encryption of data in transit and at rest</li>
                    <li>Regular security assessments and updates</li>
                    <li>Access controls and authentication mechanisms</li>
                    <li>Secure payment processing through PCI-compliant providers</li>
                </ul>
            </section>

            <!-- 5. Your Privacy Rights -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">5</span>
                    Your Privacy Rights
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">You have the right to:</p>
                <ul class="list-disc list-inside space-y-2 ml-4 text-gray-700">
                    <li>Access and receive a copy of your personal information</li>
                    <li>Correct inaccurate or incomplete information</li>
                    <li>Request deletion of your personal information</li>
                    <li>Object to or restrict certain processing of your information</li>
                    <li>Withdraw consent where we rely on consent to process your information</li>
                    <li>Export your data in a portable format</li>
                </ul>
                <p class="text-gray-700 leading-relaxed mt-4">
                    To exercise these rights, please contact us at <a href="mailto:privacy@ikicb.com" class="text-yellow-600 hover:text-yellow-700 font-bold">privacy@ikicb.com</a>
                </p>
            </section>

            <!-- 6. Cookies and Tracking Technologies -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">6</span>
                    Cookies and Tracking Technologies
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We use cookies and similar tracking technologies to track activity on our platform and hold certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    For more information, please read our <a href="{{ route('cookies') }}" class="text-yellow-600 hover:text-yellow-700 font-bold">Cookie Policy</a>.
                </p>
            </section>

            <!-- 7. Data Retention -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">7</span>
                    Data Retention
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. When we no longer need your information, we will securely delete or anonymize it.
                </p>
            </section>

            <!-- 8. Children's Privacy -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">8</span>
                    Children's Privacy
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    Our service is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you believe we have collected information from a child under 13, please contact us immediately.
                </p>
            </section>

            <!-- 9. Changes to This Privacy Policy -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">9</span>
                    Changes to This Privacy Policy
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. We encourage you to review this Privacy Policy periodically.
                </p>
            </section>

            <!-- 10. Contact Us -->
            <section class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-sm font-bold mr-3">10</span>
                    Contact Us
                </h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you have any questions about this Privacy Policy, please contact us:
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
