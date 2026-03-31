@extends('layouts.guest')

@section('title', $submission->title . ' - Submission')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-yellow-50 min-h-screen">

    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 to-black py-8 border-b border-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="mb-3 flex items-center gap-3 text-sm">
                <a href="{{ route('submissions.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">My Submissions</a>
                <span class="text-gray-600">/</span>
                <span class="text-gray-300">{{ Str::limit($submission->title, 40) }}</span>
            </nav>
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-black text-white">{{ $submission->title }}</h1>
                    <p class="text-gray-400 mt-1">Submitted {{ $submission->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                @php
                    $statusClasses = [
                        'pending'  => 'bg-yellow-500 text-gray-900',
                        'reviewed' => 'bg-blue-500 text-white',
                        'approved' => 'bg-green-500 text-white',
                        'rejected' => 'bg-red-500 text-white',
                    ];
                @endphp
                <span class="px-4 py-2 rounded-full font-black text-sm {{ $statusClasses[$submission->status] ?? 'bg-yellow-500 text-gray-900' }}">
                    {{ ucfirst($submission->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @if(session('success'))
            <div class="bg-green-50 border-2 border-green-300 rounded-2xl p-4 flex items-center gap-3">
                <svg class="h-6 w-6 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-800 font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Details card -->
        <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                <h2 class="text-xl font-black text-gray-900">Submission Details</h2>
            </div>
            <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Type</p>
                    <p class="font-bold text-gray-900 capitalize">{{ $submission->file_type }}</p>
                </div>
                @if($submission->course)
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Course</p>
                    <p class="font-bold text-gray-900">{{ $submission->course->title }}</p>
                </div>
                @endif
                @if($submission->module)
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Module</p>
                    <p class="font-bold text-gray-900">{{ $submission->module->title }}</p>
                </div>
                @endif
                @if(!$submission->isVideo() && $submission->file_size)
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">File Size</p>
                    <p class="font-bold text-gray-900">{{ $submission->getFileSizeFormatted() }}</p>
                </div>
                @endif
                <div class="sm:col-span-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Description / Reason</p>
                    <p class="text-gray-700 leading-relaxed">{{ $submission->description }}</p>
                </div>
            </div>
        </div>

        <!-- File / Video -->
        <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                <h2 class="text-xl font-black text-gray-900">Submitted File</h2>
            </div>
            <div class="p-8">
                @if($submission->isVideo() && $signedVideoUrl)
                    <div class="bg-black rounded-2xl overflow-hidden shadow-2xl" style="position:relative;padding-bottom:56.25%;height:0;">
                        <iframe src="{{ $signedVideoUrl }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
                            allowfullscreen
                            style="position:absolute;top:0;left:0;width:100%;height:100%;">
                        </iframe>
                    </div>
                    <p class="text-xs text-gray-400 mt-3 text-center">Video hosted on Bunny.net</p>

                @elseif($submission->file_type === 'image' && $submission->file_path)
                    <img src="{{ Storage::url($submission->file_path) }}"
                         alt="{{ $submission->title }}"
                         class="max-w-full rounded-2xl shadow-lg mx-auto block">
                    <div class="mt-4 text-center">
                        <a href="{{ Storage::url($submission->file_path) }}" download
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Image
                        </a>
                    </div>

                @elseif($submission->file_path)
                    <div class="flex flex-col items-center justify-center py-10 gap-4">
                        <div class="w-20 h-20 bg-yellow-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-gray-900 capitalize">{{ $submission->file_type }} file</p>
                        <p class="text-sm text-gray-500">{{ $submission->getFileSizeFormatted() }}</p>
                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 text-gray-900 font-black shadow-xl hover:scale-105 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download / Open File
                        </a>
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">File not available</p>
                @endif
            </div>
        </div>

        <!-- Admin Feedback -->
        @if($submission->admin_feedback || $submission->status !== 'pending')
        <div class="bg-white rounded-3xl shadow-xl border-2 overflow-hidden" style="border-color: #eab308;">
            <div class="px-8 py-4" style="background: linear-gradient(to right, #eab308, #ca8a04);">
                <h2 class="text-xl font-black text-gray-900">Instructor Feedback</h2>
            </div>
            <div class="p-8">
                @if($submission->admin_feedback)
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $submission->admin_feedback }}</p>
                @else
                    <p class="text-gray-400 italic">No feedback provided yet.</p>
                @endif
                @if($submission->reviewed_at)
                    <p class="text-xs text-gray-400 mt-4">
                        Reviewed on {{ $submission->reviewed_at->format('M d, Y \a\t h:i A') }}
                        @if($submission->reviewer) by {{ $submission->reviewer->name }} @endif
                    </p>
                @endif
            </div>
        </div>
        @endif

        <div class="text-center">
            <a href="{{ route('submissions.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border-2 border-gray-300 text-gray-700 font-bold hover:border-yellow-400 transition-all">
                ← Back to My Submissions
            </a>
        </div>
    </div>
</div>
@endsection
