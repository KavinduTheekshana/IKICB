@extends('layouts.guest')

@section('title', 'My Submissions')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-yellow-50 min-h-screen">

    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 to-black py-8 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white">My Submissions</h1>
                    <p class="text-gray-400 mt-1 text-sm sm:text-base">Your uploaded projects, demos, and assignments</p>
                </div>
                <a href="{{ route('submissions.create') }}"
                   class="inline-flex items-center px-4 py-2.5 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-sm sm:text-base shadow-lg transform hover:scale-105 transition-all flex-shrink-0">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden sm:inline">New Submission</span>
                    <span class="sm:hidden">New</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                <a href="{{ route('dashboard') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                    Overview
                </a>
                <a href="{{ route('dashboard.my-courses') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                    My Courses
                </a>
                <a href="{{ route('submissions.index') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-yellow-500 text-yellow-600 font-black text-sm">
                    My Submissions
                </a>
                <a href="{{ route('dashboard.payments') }}" class="whitespace-nowrap py-4 px-1 border-b-4 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300 font-bold text-sm transition-colors">
                    Payments
                </a>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-300 rounded-2xl p-4 flex items-center gap-3">
                <svg class="h-6 w-6 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-800 font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if($submissions->isEmpty())
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">No Submissions Yet</h3>
                <p class="text-gray-600 mb-6">Upload your first project demo, video, or assignment.</p>
                <a href="{{ route('submissions.create') }}"
                   class="inline-flex items-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 text-gray-900 font-black shadow-xl hover:scale-105 transition-all">
                    Submit Something
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($submissions as $submission)
                    @php
                        $statusColors = [
                            'pending'  => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'reviewed' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'approved' => 'bg-green-100 text-green-800 border-green-300',
                            'rejected' => 'bg-red-100 text-red-800 border-red-300',
                        ];
                        $typeIcons = [
                            'video'    => 'M15 10l4.553-2.069A1 1 0 0121 8.882v6.235a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                            'pdf'      => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                            'image'    => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                            'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'other'    => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13',
                        ];
                    @endphp
                    <a href="{{ route('submissions.show', $submission) }}"
                       class="block bg-white rounded-3xl shadow-lg border-2 border-gray-100 hover:border-yellow-400 hover:shadow-xl transition-all group overflow-hidden">
                        <!-- Type Banner -->
                        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-3xl px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$submission->file_type] ?? $typeIcons['other'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-white font-bold capitalize">{{ $submission->file_type }}</span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$submission->status] ?? $statusColors['pending'] }}">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-black text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors line-clamp-2">
                                {{ $submission->title }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $submission->description }}</p>

                            @if($submission->course)
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    {{ $submission->course->title }}
                                </div>
                            @endif

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-400">{{ $submission->created_at->format('M d, Y') }}</span>
                                @if($submission->admin_feedback)
                                    <span class="text-xs text-blue-600 font-semibold">Has feedback</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
