@extends('layouts.app')

@section('title', 'Contact Us - IKICB LMS')

@section('content')
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">Contact Us</h1>
            <p class="mt-4 text-xl text-gray-600">Get in touch with our team</p>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-gray-50 rounded-lg p-8">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600">info@ikicb.com</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Phone</h3>
                        <p class="text-gray-600">+94 XX XXX XXXX</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Address</h3>
                        <p class="text-gray-600">
                            IKICB<br>
                            Colombo, Sri Lanka
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Support Hours</h3>
                        <p class="text-gray-600">
                            Monday - Friday: 9:00 AM - 5:00 PM<br>
                            Saturday: 9:00 AM - 1:00 PM<br>
                            Sunday: Closed
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
