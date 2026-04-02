@extends('layouts.guest')

@section('title', $module->title . ' - ' . $module->course->title)

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-yellow-50 min-h-screen">
    <!-- Breadcrumb Header -->
    <div class="bg-gradient-to-r from-gray-900 to-black py-4 sm:py-6 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="mb-2">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm">
                    <li>
                        <a href="{{ route('courses.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">
                            Courses
                        </a>
                    </li>
                    <li><span class="text-gray-500">/</span></li>
                    <li>
                        <a href="{{ route('courses.show', $module->course) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">
                            {{ $module->course->title }}
                        </a>
                    </li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><span class="text-gray-300 font-semibold">{{ $module->title }}</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-300 rounded-2xl p-4 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-green-800 font-bold text-lg">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Module Header with Completion Status -->
                <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-4 sm:p-8">
                    <div class="flex flex-wrap sm:flex-nowrap items-start gap-3 sm:gap-6 sm:justify-between">
                        <div class="w-full sm:flex-1">
                            <h1 class="text-2xl sm:text-4xl font-black text-gray-900 mb-2 sm:mb-3">{{ $module->title }}</h1>
                            <p class="text-sm sm:text-lg text-gray-600">{{ $module->description }}</p>
                        </div>
                        @if($isCompleted)
                            <span class="inline-flex items-center px-3 py-1.5 sm:px-5 sm:py-3 rounded-2xl text-sm font-black bg-green-100 text-green-800 border-2 border-green-300 shadow-lg whitespace-nowrap flex-shrink-0">
                                <svg class="h-4 w-4 sm:h-6 sm:w-6 mr-1.5 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Completed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Video Lessons (multiple, with expiry support) -->
                @if($module->activeVideos->count() > 0)
                <!-- Video Protection Notice -->
                <div class="flex items-start gap-3 bg-red-50 border-2 border-red-200 rounded-2xl px-5 py-4">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-black text-red-800">Protected Content — No Recording or Sharing</p>
                        <p class="text-xs text-red-600 mt-0.5">This video is watermarked with your account identity. Unauthorized recording, screen capture, or sharing is a violation of our Terms of Service and may result in immediate account suspension and legal action.</p>
                    </div>
                </div>
                    @foreach($module->activeVideos as $moduleVideo)
                        <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-4 py-3 sm:px-8 sm:py-4 flex flex-wrap items-center justify-between gap-2">
                                <h2 class="text-lg sm:text-2xl font-black text-gray-900 flex items-center">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $moduleVideo->title }}
                                </h2>
                                @if($moduleVideo->expires_at)
                                    <span class="text-xs font-semibold bg-white/30 text-gray-900 px-3 py-1 rounded-full">
                                        Expires {{ $moduleVideo->expires_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                            @if($moduleVideo->description)
                                <div class="px-8 pt-4 text-gray-600">{{ $moduleVideo->description }}</div>
                            @endif
                            <div class="p-6">
                                {{-- Outer wrapper — THIS is what we fullscreen so our watermark stays inside --}}
                                <div class="video-protected-wrapper" style="position:relative;background:#000;border-radius:1rem;overflow:hidden;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">
                                    <div style="padding-bottom:56.25%;height:0;position:relative;">
                                        <iframe
                                            class="protected-video-iframe"
                                            data-src="{{ base64_encode($signedVideoUrls[$moduleVideo->id] ?? $moduleVideo->video_url) }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
                                            sandbox="allow-scripts allow-same-origin allow-forms allow-presentation"
                                            style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;">
                                        </iframe>
                                        {{-- Single moving watermark — sits INSIDE the wrapper so it shows in our custom fullscreen --}}
                                        <div class="video-watermark" style="position:absolute;z-index:30;pointer-events:none;user-select:none;">
                                            {{ auth()->user()->name }} &bull; {{ auth()->user()->email }}
                                        </div>
                                    </div>
                                    {{-- Custom fullscreen button --}}
                                    <button class="custom-fs-btn" title="Fullscreen" onclick="toggleVideoFullscreen(this)">
                                        <svg class="fs-icon-expand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                                        </svg>
                                        <svg class="fs-icon-compress" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4m0 5H4m11-5v5m0 0h5M4 15h5v5M20 15h-5v5"/>
                                        </svg>
                                    </button>
                                    {{-- Tab-hidden blur overlay --}}
                                    <div class="tab-hidden-overlay" style="display:none;position:absolute;inset:0;z-index:45;background:rgba(0,0,0,0.88);align-items:center;justify-content:center;flex-direction:column;">
                                        <svg style="width:48px;height:48px;color:#eab308;margin-bottom:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                        <p style="color:#fff;font-weight:900;font-size:16px;margin-bottom:4px;">Video Paused</p>
                                        <p style="color:#9ca3af;font-size:13px;">Return to this tab to continue watching.</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Per-video identity footer --}}
                            <div class="px-6 pb-4">
                                <p class="text-xs text-gray-400 text-right font-semibold">
                                    <svg class="inline w-3 h-3 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    Watermarked for {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @elseif($module->video_url && trim($module->video_url) !== '')
                    {{-- Backward compat: show legacy single video --}}
                    <div class="flex items-start gap-3 bg-red-50 border-2 border-red-200 rounded-2xl px-5 py-4">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-black text-red-800">Protected Content — No Recording or Sharing</p>
                            <p class="text-xs text-red-600 mt-0.5">This video is watermarked with your account identity. Unauthorized recording, screen capture, or sharing is a violation of our Terms of Service and may result in immediate account suspension and legal action.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                            <h2 class="text-lg sm:text-2xl font-black text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Video Lesson
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="video-protected-wrapper" style="position:relative;background:#000;border-radius:1rem;overflow:hidden;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">
                                <div style="padding-bottom:56.25%;height:0;position:relative;">
                                    <iframe
                                        class="protected-video-iframe"
                                        data-src="{{ base64_encode($legacySignedUrl ?? $module->video_url) }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
                                        sandbox="allow-scripts allow-same-origin allow-forms allow-presentation"
                                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;">
                                    </iframe>
                                    <div class="video-watermark" style="position:absolute;z-index:30;pointer-events:none;user-select:none;">
                                        {{ auth()->user()->name }} &bull; {{ auth()->user()->email }}
                                    </div>
                                </div>
                                <button class="custom-fs-btn" title="Fullscreen" onclick="toggleVideoFullscreen(this)">
                                    <svg class="fs-icon-expand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                                    </svg>
                                    <svg class="fs-icon-compress" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4m0 5H4m11-5v5m0 0h5M4 15h5v5M20 15h-5v5"/>
                                    </svg>
                                </button>
                                <div class="tab-hidden-overlay" style="display:none;position:absolute;inset:0;z-index:45;background:rgba(0,0,0,0.88);align-items:center;justify-content:center;flex-direction:column;">
                                    <svg style="width:48px;height:48px;color:#eab308;margin-bottom:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                    <p style="color:#fff;font-weight:900;font-size:16px;margin-bottom:4px;">Video Paused</p>
                                    <p style="color:#9ca3af;font-size:13px;">Return to this tab to continue watching.</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 pb-4">
                            <p class="text-xs text-gray-400 text-right font-semibold">
                                <svg class="inline w-3 h-3 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                Watermarked for {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Materials -->
                @if($module->materials->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-4 py-3 sm:px-8 sm:py-4">
                            <h2 class="text-lg sm:text-2xl font-black text-gray-900 flex items-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Learning Materials
                            </h2>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($module->materials->sortBy('order') as $material)
                                    <div class="group border-2 border-gray-200 rounded-xl overflow-hidden hover:border-yellow-400 hover:shadow-lg transition-all flex flex-col">
                                        @if($material->type === 'image')
                                            <img src="{{ Storage::url($material->file_path) }}" alt="{{ $material->title }}" class="w-full h-36 object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-20 bg-gradient-to-br
                                                {{ $material->type === 'pdf' ? 'from-red-100 to-red-200' : 'from-blue-100 to-blue-200' }}">
                                                @if($material->type === 'pdf')
                                                    <svg class="h-10 w-10 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg class="h-10 w-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="p-3 flex flex-col flex-1">
                                            <h3 class="text-sm font-black text-gray-900 mb-1 group-hover:text-yellow-600 transition-colors">{{ $material->title }}</h3>
                                            @if($material->description)
                                                <p class="text-xs text-gray-600 mb-3">{{ $material->description }}</p>
                                            @endif
                                            <a href="{{ Storage::url($material->file_path) }}" download class="mt-auto w-full inline-flex items-center justify-center px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-bold text-sm shadow hover:shadow-yellow-500/50 transition-all">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- MCQ Quiz -->
                @if($mcqQuestions->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-4">
                            <h2 class="text-lg sm:text-2xl font-black text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                Practice Quiz (MCQ)
                            </h2>
                        </div>
                        <div class="p-6">
                            <!-- Quiz Results -->
                            @if(session('quiz_results'))
                                <div class="mb-8 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-3xl p-8 shadow-xl">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-2xl font-black text-gray-900">Quiz Results</h3>
                                        <div class="text-5xl font-black text-gradient">
                                            {{ number_format(session('quiz_results')['score'], 1) }}%
                                        </div>
                                    </div>
                                    <div class="flex items-center text-gray-900 mb-6 text-lg font-bold">
                                        <svg class="h-6 w-6 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ session('quiz_results')['correct'] }} out of {{ session('quiz_results')['total'] }} correct</span>
                                    </div>

                                    <!-- Detailed Results -->
                                    <div class="space-y-4">
                                        @foreach($mcqQuestions as $index => $question)
                                            @php
                                                $result = session('quiz_results')['results'][$question->id] ?? null;
                                            @endphp
                                            @if($result)
                                                <div class="border-l-4 {{ $result['is_correct'] ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-5 rounded-r-2xl shadow-md">
                                                    <p class="font-black text-gray-900 mb-3 text-base">
                                                        {{ $index + 1 }}. {{ $question->question }}
                                                    </p>
                                                    <div class="text-sm font-semibold">
                                                        <p class="text-gray-700">
                                                            <strong>Your answer:</strong> {{ $result['user_answer'] ?? 'Not answered' }}
                                                            @if($result['is_correct'])
                                                                <span class="text-green-600 font-black ml-2">✓ Correct!</span>
                                                            @else
                                                                <span class="text-red-600 font-black ml-2">✗ Incorrect</span>
                                                            @endif
                                                        </p>
                                                        @if(!$result['is_correct'])
                                                            <p class="text-green-700 mt-2">
                                                                <strong>Correct answer:</strong> {{ $result['correct_answer'] }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Previous Attempts -->
                            @if($quizAttempts->count() > 0)
                                <div class="mb-8">
                                    <h3 class="text-lg font-black text-gray-900 mb-4">Previous Attempts</h3>
                                    <div class="space-y-3">
                                        @foreach($quizAttempts->take(5) as $attempt)
                                            <div class="flex items-center justify-between bg-gradient-to-r from-yellow-50 to-white border-2 border-yellow-200 rounded-2xl p-4 hover:border-yellow-400 transition-all">
                                                <div class="flex items-center space-x-4">
                                                    <span class="text-3xl font-black text-gradient">{{ number_format($attempt->score, 1) }}%</span>
                                                    <div class="text-sm text-gray-700 font-semibold">
                                                        <div>{{ $attempt->correct_answers }}/{{ $attempt->total_questions }} correct</div>
                                                        <div class="text-gray-500">{{ $attempt->completed_at->format('M d, Y h:i A') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Quiz Form -->
                            @if($hasAttempted)
                                <div class="mt-4 p-6 bg-gray-100 border-2 border-gray-300 rounded-2xl text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <p class="text-gray-700 font-black text-lg">Quiz Already Submitted</p>
                                    <p class="text-gray-500 font-semibold mt-1">You have already completed this quiz. Only one attempt is allowed.</p>
                                </div>
                            @else
                                <form action="{{ route('courses.module.quiz', $module) }}" method="POST" id="quizForm">
                                    @csrf
                                    <div class="space-y-8">
                                        @foreach($mcqQuestions as $index => $question)
                                            <div class="border-b-2 border-gray-200 pb-8 last:border-0">
                                                <p class="font-black text-gray-900 mb-4 text-lg">
                                                    {{ $index + 1 }}. {{ $question->question }}
                                                    <span class="text-sm text-yellow-600 font-bold ml-2">({{ $question->marks }} marks)</span>
                                                </p>
                                                @if($question->mcq_options)
                                                    <div class="space-y-3 ml-6">
                                                        @foreach($question->mcq_options as $option)
                                                            @php
                                                                $optionText = is_array($option) ? ($option['option'] ?? '') : $option;
                                                                $optionId   = is_array($option) ? ($option['id'] ?? '') : '';
                                                            @endphp
                                                            @if($optionText && $optionId)
                                                            <label class="flex items-center space-x-4 p-4 rounded-2xl border-2 border-gray-200 hover:bg-yellow-50 hover:border-yellow-400 cursor-pointer transition-all group">
                                                                <input
                                                                    type="radio"
                                                                    name="answers[{{ $question->id }}]"
                                                                    value="{{ $optionId }}"
                                                                    class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 focus:ring-2"
                                                                    required>
                                                                <span class="text-gray-700 font-semibold flex-1 group-hover:text-gray-900">{{ $optionText }}</span>
                                                            </label>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-8 pt-8 border-t-2 border-gray-200">
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                                            <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Submit Quiz
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Module Completion Button -->
                @if(!$isCompleted)
                    <div class="bg-white rounded-3xl shadow-xl border-2 border-green-200 p-8">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Complete This Module</h3>
                        <p class="text-gray-600 mb-6 text-lg">Once you've finished all the materials and completed the quiz, mark this module as complete.</p>
                        <form action="{{ route('courses.module.complete', $module) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-black text-lg shadow-xl hover:shadow-green-500/50 transform hover:scale-105 transition-all">
                                <svg class="h-6 w-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Mark as Complete
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 sticky top-24 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-xl font-black text-gray-900">Course Modules</h3>
                    </div>

                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($module->course->modules->sortBy('order') as $courseModule)
                                @php
                                    $moduleUnlocked = auth()->user()->moduleUnlocks()->where('module_id', $courseModule->id)->exists();
                                    $moduleCompleted = auth()->user()->hasCompletedModule($courseModule->id);
                                @endphp
                                <a href="{{ $moduleUnlocked ? route('courses.module', $courseModule) : '#' }}"
                                   class="block p-4 rounded-2xl transition-all {{ $courseModule->id === $module->id ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 border-2 border-yellow-400 shadow-lg' : ($moduleUnlocked ? 'bg-gray-50 hover:bg-yellow-50 border-2 border-gray-200 hover:border-yellow-300' : 'bg-gray-100 opacity-50 cursor-not-allowed border-2 border-gray-200') }}">
                                    <div class="flex items-center">
                                        <span class="flex-shrink-0 h-8 w-8 rounded-xl {{ $moduleCompleted ? 'bg-green-500' : ($moduleUnlocked ? 'gradient-primary' : 'bg-gray-400') }} flex items-center justify-center mr-3 shadow-lg">
                                            @if($moduleCompleted)
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($moduleUnlocked)
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </span>
                                        <span class="text-sm font-bold {{ $courseModule->id === $module->id ? 'text-gray-900' : 'text-gray-700' }}">
                                            {{ $courseModule->title }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('courses.show', $module->course) }}" class="block w-full text-center px-6 py-3 rounded-2xl border-2 border-gray-300 text-gray-900 bg-white hover:bg-gray-50 hover:border-yellow-400 font-bold shadow-lg transform hover:scale-105 transition-all">
                                Back to Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gradient-primary {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
}
.text-gradient {
    background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Video Protection ──────────────────────────────────── */
.video-protected-wrapper {
    -webkit-user-select: none;
    user-select: none;
}
.video-protected-wrapper * {
    -webkit-user-drag: none;
}

/* Single moving watermark */
.video-watermark {
    position: absolute;
    z-index: 30;
    pointer-events: none;
    user-select: none;
    font-size: 13px;
    font-weight: 800;
    color: rgba(255, 255, 255, 0.28);
    text-shadow: 0 1px 4px rgba(0,0,0,0.7);
    white-space: nowrap;
    transform: rotate(-22deg);
    transition: top 4s ease, left 4s ease;
    letter-spacing: 0.05em;
}

/* Tab-hidden overlay */
.tab-hidden-overlay {
    display: none;
    position: absolute;
    inset: 0;
    z-index: 45;
    background: rgba(0,0,0,0.88);
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

/* Custom fullscreen button */
.custom-fs-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    z-index: 40;
    background: rgba(0,0,0,0.55);
    border: none;
    border-radius: 8px;
    padding: 6px 8px;
    cursor: pointer;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
.custom-fs-btn:hover { background: rgba(0,0,0,0.80); }
.custom-fs-btn svg   { width: 20px; height: 20px; }

/* When the wrapper itself is fullscreen */
.video-protected-wrapper:fullscreen,
.video-protected-wrapper:-webkit-full-screen,
.video-protected-wrapper:-moz-full-screen {
    background: #000;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.video-protected-wrapper:fullscreen > div,
.video-protected-wrapper:-webkit-full-screen > div,
.video-protected-wrapper:-moz-full-screen > div {
    width: 100%;
    padding-bottom: 56.25%;
}
</style>

<script>
(function () {
    'use strict';

    // ── 0. Inject iframe src from base64 data attribute ─────
    // URL is not in HTML source — only injected at runtime via JS
    document.querySelectorAll('.protected-video-iframe[data-src]').forEach(function (iframe) {
        try {
            iframe.src = atob(iframe.getAttribute('data-src'));
            iframe.removeAttribute('data-src');
        } catch (e) {}
    });

    // ── 1. Right-click block + toast ────────────────────────
    document.querySelectorAll('.video-protected-wrapper').forEach(function (w) {
        w.addEventListener('contextmenu', function (e) {
            e.preventDefault();
            showToast('This content is protected. Right-click is disabled.');
        });
    });

    // ── 2. Single watermark — move every 8 seconds ──────────
    function moveWatermarks() {
        document.querySelectorAll('.video-watermark').forEach(function (wm) {
            wm.style.top  = (Math.random() * 65 + 5) + '%';
            wm.style.left = (Math.random() * 60 + 5) + '%';
        });
    }
    moveWatermarks();
    setInterval(moveWatermarks, 8000);

    // ── 3. Custom fullscreen (fullscreens the wrapper, not the iframe) ──
    window.toggleVideoFullscreen = function (btn) {
        var wrapper = btn.closest('.video-protected-wrapper');
        var isFs = !!(document.fullscreenElement ||
                      document.webkitFullscreenElement ||
                      document.mozFullScreenElement);
        if (!isFs) {
            var req = wrapper.requestFullscreen ||
                      wrapper.webkitRequestFullscreen ||
                      wrapper.mozRequestFullScreen;
            if (req) req.call(wrapper);
        } else {
            var exit = document.exitFullscreen ||
                       document.webkitExitFullscreen ||
                       document.mozCancelFullScreen;
            if (exit) exit.call(document);
        }
    };

    function onFsChange() {
        var isFs = !!(document.fullscreenElement ||
                      document.webkitFullscreenElement ||
                      document.mozFullScreenElement);
        document.querySelectorAll('.custom-fs-btn').forEach(function (btn) {
            btn.querySelector('.fs-icon-expand').style.display   = isFs ? 'none' : '';
            btn.querySelector('.fs-icon-compress').style.display = isFs ? ''     : 'none';
        });
    }
    document.addEventListener('fullscreenchange',       onFsChange);
    document.addEventListener('webkitfullscreenchange', onFsChange);
    document.addEventListener('mozfullscreenchange',    onFsChange);

    // ── 4. Tab visibility — overlay when tab is hidden ──────
    document.addEventListener('visibilitychange', function () {
        var hidden = document.hidden;
        document.querySelectorAll('.tab-hidden-overlay').forEach(function (o) {
            o.style.display = hidden ? 'flex' : 'none';
        });
    });

    // ── 5. getDisplayMedia interception ─────────────────────
    // Blocks browser-based screen recorders (Loom, browser share, etc.)
    if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
        navigator.mediaDevices.getDisplayMedia = function () {
            showToast('Screen capture of this content is not permitted.');
            document.querySelectorAll('.tab-hidden-overlay').forEach(function (o) {
                o.style.display = 'flex';
            });
            return Promise.reject(new DOMException('Not allowed', 'NotAllowedError'));
        };
    }

    // ── 6. PiP (Picture-in-Picture) blocking ────────────────
    // Prevents video being dragged into a floating PiP window
    document.addEventListener('enterpictureinpicture', function (e) {
        e.preventDefault && e.preventDefault();
        if (document.exitPictureInPicture) {
            document.exitPictureInPicture().catch(function () {});
        }
        showToast('Picture-in-Picture is disabled for protected content.');
    }, true);

    // ── 7. DevTools detection (debugger timing trick) ────────
    // The `debugger` statement pauses execution when DevTools is open.
    // If the pause takes > 100ms, DevTools is open.
    var devToolsOpen = false;
    setInterval(function () {
        var start = performance.now();
        // eslint-disable-next-line no-debugger
        debugger;
        var elapsed = performance.now() - start;
        var isOpen = elapsed > 100;
        if (isOpen && !devToolsOpen) {
            devToolsOpen = true;
            document.querySelectorAll('.tab-hidden-overlay').forEach(function (o) {
                o.style.display = 'flex';
                o.querySelector('p:first-of-type') && (o.querySelector('p:first-of-type').textContent = 'Developer Tools Detected');
                o.querySelector('p:last-of-type')  && (o.querySelector('p:last-of-type').textContent  = 'Close DevTools to continue watching.');
            });
        } else if (!isOpen && devToolsOpen) {
            devToolsOpen = false;
            if (!document.hidden) {
                document.querySelectorAll('.tab-hidden-overlay').forEach(function (o) {
                    o.style.display = 'none';
                    o.querySelector('p:first-of-type') && (o.querySelector('p:first-of-type').textContent = 'Video Paused');
                    o.querySelector('p:last-of-type')  && (o.querySelector('p:last-of-type').textContent  = 'Return to this tab to continue watching.');
                });
            }
        }
    }, 1000);

    // ── 8. Mouse leave detection ─────────────────────────────
    // When mouse exits the browser window entirely (e.g. to position OBS)
    // show a subtle warning toast — do NOT block the video (too aggressive)
    var mouseLeaveTimer = null;
    document.addEventListener('mouseleave', function () {
        mouseLeaveTimer = setTimeout(function () {
            showToast('Recording this content is prohibited and will result in account suspension.');
        }, 800); // 800ms delay avoids false-positives from quick mouse exits
    });
    document.addEventListener('mouseenter', function () {
        clearTimeout(mouseLeaveTimer);
    });

    // ── 9. Keyboard shortcut blocking ───────────────────────
    document.addEventListener('keydown', function (e) {
        if (e.key === 'F12') { e.preventDefault(); return false; }
        if (e.ctrlKey && e.shiftKey && 'ijusc'.indexOf(e.key.toLowerCase()) !== -1) {
            e.preventDefault(); return false;
        }
        if (e.ctrlKey && e.key.toLowerCase() === 'u') { e.preventDefault(); return false; }
        if (e.key === 'PrintScreen') {
            e.preventDefault();
            showToast('Screenshots are not permitted for this content.');
            return false;
        }
    });

    // ── 10. Toast notification ───────────────────────────────
    function showToast(msg) {
        var existing = document.getElementById('protection-toast');
        if (existing) existing.remove();
        var toast = document.createElement('div');
        toast.id = 'protection-toast';
        toast.textContent = msg;
        toast.style.cssText = [
            'position:fixed',
            'bottom:28px',
            'left:50%',
            'transform:translateX(-50%)',
            'background:#1f2937',
            'color:#fff',
            'padding:10px 20px',
            'border-radius:10px',
            'font-size:13px',
            'font-weight:700',
            'z-index:99999',
            'box-shadow:0 4px 20px rgba(0,0,0,0.4)',
            'border-left:4px solid #eab308',
            'white-space:nowrap',
            'opacity:0',
            'transition:opacity 0.3s ease'
        ].join(';');
        document.body.appendChild(toast);
        requestAnimationFrame(function () { toast.style.opacity = '1'; });
        setTimeout(function () {
            toast.style.opacity = '0';
            setTimeout(function () { toast.remove(); }, 300);
        }, 3500);
    }

})();
</script>
@endsection
