@extends('layouts.guest')

@section('title', 'Edit Profile - Dashboard | IKICB')

@section('content')
<!-- Hero Header -->
<div class="relative bg-gradient-to-br from-gray-900 via-black to-gray-900 py-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-yellow-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-600 rounded-full filter blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-2">
                    My <span class="text-gradient-light">Profile</span>
                </h1>
                <p class="text-gray-300 text-base sm:text-lg">Manage your account settings</p>
            </div>
            <a href="{{ route('dashboard') }}" class="group flex items-center space-x-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 hover:border-yellow-500 rounded-xl transition-all duration-300 shadow-lg hover:shadow-yellow-500/50">
                <i class="fas fa-arrow-left text-white group-hover:text-yellow-500 transition-colors"></i>
                <span class="text-white font-bold group-hover:text-yellow-500 transition-colors">Back to Dashboard</span>
            </a>
        </div>
    </div>
</div>

<!-- Profile Content -->
<section class="py-12 bg-gradient-to-br from-yellow-50 via-white to-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-300 rounded-2xl p-4 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <span class="text-green-800 font-bold text-lg">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-2 border-red-300 rounded-2xl p-4 shadow-lg">
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-red-800 font-bold text-lg block mb-2">Please fix the following errors:</span>
                        <ul class="list-disc list-inside text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Profile Information Card -->
        <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-6">
                <h2 class="text-2xl font-black text-gray-900 flex items-center">
                    <i class="fas fa-user-circle text-3xl mr-3"></i>
                    Profile Information
                </h2>
                <p class="text-gray-700 mt-1">Update your account details</p>
            </div>

            <form action="{{ route('dashboard.profile.update') }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold @error('phone') border-red-500 @enderror"
                            placeholder="0771234567">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-bold text-gray-900 mb-2">Address</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold @error('address') border-red-500 @enderror"
                            placeholder="Your address">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t-2 border-gray-100">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                        <i class="fas fa-save text-xl mr-3"></i>
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Card -->
        <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-6">
                <h2 class="text-2xl font-black text-gray-900 flex items-center">
                    <i class="fas fa-lock text-3xl mr-3"></i>
                    Change Password
                </h2>
                <p class="text-gray-700 mt-1">Update your password to keep your account secure</p>
            </div>

            <form action="{{ route('dashboard.password.update') }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-bold text-gray-900 mb-2">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-2">New Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Minimum 8 characters</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-900 mb-2">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all font-semibold">
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t-2 border-gray-100">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-black text-lg shadow-xl hover:shadow-green-500/50 transform hover:scale-105 transition-all">
                        <i class="fas fa-key text-xl mr-3"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

<style>
.text-gradient-light {
    background: linear-gradient(135deg, #FDE047 0%, #FDB931 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
