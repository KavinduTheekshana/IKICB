@extends('layouts.guest')

@section('title', 'Submit Assignment / Project')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-yellow-50 min-h-screen">

    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 to-black py-8 border-b border-gray-800">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="mb-3 flex items-center gap-3 text-sm">
                <a href="{{ route('submissions.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">My Submissions</a>
                <span class="text-gray-600">/</span>
                <span class="text-gray-300">New Submission</span>
            </nav>
            <h1 class="text-3xl font-black text-white">Submit Assignment / Project</h1>
            <p class="text-gray-400 mt-1">Upload your project demo, video, PDF, or any related file</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-2 border-red-300 rounded-2xl p-4">
                <p class="font-bold text-red-800 mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" id="submissionForm">
            @csrf

            <!-- Details -->
            <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-8 mb-6">
                <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center text-gray-900 font-black text-sm">1</span>
                    Submission Details
                </h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-0 font-semibold text-gray-900"
                               placeholder="e.g. Module 3 Project Demo">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description / Reason <span class="text-red-500">*</span></label>
                        <textarea name="description" required rows="4"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-0 font-semibold text-gray-900 resize-none"
                                  placeholder="Explain what you are submitting and why...">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Related Course</label>
                            <select name="course_id" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-0 font-semibold text-gray-900 bg-white">
                                <option value="">— Select course (optional) —</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Related Module</label>
                            <select name="module_id" id="moduleSelect" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-yellow-400 focus:ring-0 font-semibold text-gray-900 bg-white">
                                <option value="">— Select module (optional) —</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Upload -->
            <div class="bg-white rounded-3xl shadow-xl border-2 border-yellow-200 p-8 mb-6">
                <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center text-gray-900 font-black text-sm">2</span>
                    Upload File
                </h2>

                <!-- File Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">File Type <span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-2">
                        @foreach([
                            ['value' => 'video',    'label' => 'Video',    'icon' => 'M15 10l4.553-2.069A1 1 0 0121 8.882v6.235a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                            ['value' => 'pdf',      'label' => 'PDF',      'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                            ['value' => 'image',    'label' => 'Image',    'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['value' => 'document', 'label' => 'Document', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['value' => 'other',    'label' => 'Other',    'icon' => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13'],
                        ] as $type)
                            <label class="file-type-option cursor-pointer">
                                <input type="radio" name="file_type" value="{{ $type['value'] }}"
                                       class="sr-only" {{ old('file_type', 'video') === $type['value'] ? 'checked' : '' }}>
                                <div class="file-type-card inline-flex items-center gap-2 border-2 border-gray-200 rounded-xl px-4 py-2.5 transition-all hover:border-yellow-400
                                    {{ old('file_type', 'video') === $type['value'] ? 'border-yellow-500 bg-yellow-50' : 'bg-white' }}">
                                    <svg class="w-4 h-4 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"/>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-700">{{ $type['label'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- File Input -->
                <div id="fileDropZone"
                     class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-yellow-400 transition-colors cursor-pointer"
                     onclick="document.getElementById('fileInput').click()">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-gray-700 font-bold mb-1">Click to select your file</p>
                    <p id="fileTypeHint" class="text-sm text-gray-500">MP4, WebM, MOV, MKV (max 2 GB)</p>
                    <p id="selectedFileName" class="mt-3 text-yellow-600 font-bold hidden"></p>
                    <input type="file" id="fileInput" name="file" class="hidden" required>
                </div>

                <!-- Video note -->
                <div id="videoNote" class="mt-4 bg-amber-50 border border-amber-200 rounded-xl p-3 text-sm text-amber-700">
                    <strong>Video uploads</strong> are streamed directly to Bunny.net — your video will NOT be stored on our server.
                    Large files may take a few minutes to upload. Please wait after clicking Submit.
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3">
                <button type="submit" id="submitBtn"
                        class="flex-1 inline-flex items-center justify-center px-5 py-3 sm:px-8 sm:py-4 rounded-xl sm:rounded-2xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-900 font-black text-base sm:text-lg shadow-xl hover:shadow-yellow-500/50 transform hover:scale-105 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <span id="submitText">Submit</span>
                </button>
                <a href="{{ route('submissions.index') }}"
                   class="px-4 py-3 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-gray-300 text-gray-700 font-bold hover:border-gray-400 transition-all text-sm sm:text-base">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileTypeHints = {
        video:    'MP4, WebM, MOV, MKV, AVI (max 2 GB)',
        pdf:      'PDF files only (max 50 MB)',
        image:    'JPG, PNG, GIF, WebP (max 10 MB)',
        document: 'Word, Excel, PowerPoint (max 50 MB)',
        other:    'Any file type (max 50 MB)',
    };

    const videoAccept   = 'video/mp4,video/webm,video/ogg,video/avi,video/quicktime,video/x-matroska';
    const fileAccepts = {
        video:    videoAccept,
        pdf:      'application/pdf',
        image:    'image/jpeg,image/png,image/gif,image/webp',
        document: '.doc,.docx,.xls,.xlsx,.ppt,.pptx',
        other:    '*',
    };

    function getSelectedType() {
        return document.querySelector('input[name="file_type"]:checked')?.value ?? 'video';
    }

    // File type card toggle
    document.querySelectorAll('.file-type-option input').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.file-type-card').forEach(c => {
                c.classList.remove('border-yellow-500', 'bg-yellow-50');
                c.classList.add('border-gray-200');
            });
            this.closest('.file-type-option').querySelector('.file-type-card')
                .classList.add('border-yellow-500', 'bg-yellow-50');
            const type = this.value;
            document.getElementById('fileTypeHint').textContent = fileTypeHints[type];
            document.getElementById('fileInput').accept = fileAccepts[type];
            document.getElementById('videoNote').style.display = type === 'video' ? 'block' : 'none';
            document.getElementById('fileInput').value = '';
            document.getElementById('selectedFileName').classList.add('hidden');
        });
    });

    // File selection display
    document.getElementById('fileInput').addEventListener('change', function () {
        const nameEl = document.getElementById('selectedFileName');
        if (this.files[0]) {
            nameEl.textContent = '✓ ' + this.files[0].name;
            nameEl.classList.remove('hidden');
        } else {
            nameEl.classList.add('hidden');
        }
    });

    // Show uploading state on submit
    document.getElementById('submissionForm').addEventListener('submit', function () {
        const btn  = document.getElementById('submitBtn');
        const text = document.getElementById('submitText');
        btn.disabled = true;
        btn.classList.remove('hover:scale-105');
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        text.textContent = getSelectedType() === 'video'
            ? 'Uploading video… please wait'
            : 'Submitting…';
    });

    // Course → modules AJAX
    document.querySelector('select[name="course_id"]').addEventListener('change', function () {
        const courseId   = this.value;
        const moduleSel  = document.getElementById('moduleSelect');
        moduleSel.innerHTML = '<option value="">— Select module (optional) —</option>';
        if (!courseId) return;
        fetch(`/api/courses/${courseId}/modules`)
            .then(r => r.json())
            .then(modules => {
                modules.forEach(m => {
                    const opt = document.createElement('option');
                    opt.value = m.id;
                    opt.textContent = m.title;
                    moduleSel.appendChild(opt);
                });
            })
            .catch(() => {});
    });

    // Initialize
    document.getElementById('videoNote').style.display = getSelectedType() === 'video' ? 'block' : 'none';
    document.getElementById('fileInput').accept = fileAccepts[getSelectedType()];
});
</script>
@endsection
