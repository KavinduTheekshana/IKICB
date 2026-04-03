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
                    <strong>Video uploads</strong> are streamed directly to Bunny.net - your video will NOT be stored on our server.
                    Large files may take a few minutes to upload. Please wait after clicking Submit.
                </div>
            </div>

            <!-- Upload Progress (hidden until upload starts) -->
            <div id="uploadProgressWrapper" class="hidden mb-4 bg-white rounded-2xl shadow-lg border-2 border-yellow-200 p-5">

                <!-- Stage indicators -->
                <div class="flex items-center gap-2 mb-4">
                    <div id="stageUpload" class="flex items-center gap-1.5">
                        <span id="stageUploadDot" class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse"></span>
                        <span class="text-xs font-bold text-yellow-600">Uploading</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <div id="stageProcess" class="flex items-center gap-1.5 opacity-30">
                        <span id="stageProcessDot" class="w-3 h-3 rounded-full bg-gray-400"></span>
                        <span class="text-xs font-bold text-gray-500">Processing</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <div id="stageDone" class="flex items-center gap-1.5 opacity-30">
                        <span id="stageDoneDot" class="w-3 h-3 rounded-full bg-green-400"></span>
                        <span class="text-xs font-bold text-gray-500">Ready</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="flex items-center justify-between mb-2">
                    <span id="uploadStatusText" class="text-sm font-bold text-gray-700">Uploading…</span>
                    <span id="uploadPercent" class="text-sm font-black text-yellow-600">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    <div id="uploadProgressBar"
                         class="h-4 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600 transition-all duration-300"
                         style="width: 0%"></div>
                </div>
                <p id="uploadSizeText" class="text-xs text-gray-500 mt-2"></p>

                <!-- Success message (hidden until done) -->
                <div id="uploadSuccessMsg" class="hidden mt-4 bg-green-50 border-2 border-green-300 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-black text-green-800 text-sm" id="uploadSuccessTitle">Upload Successful!</p>
                            <p class="text-green-700 text-xs mt-1" id="uploadSuccessDetail"></p>
                            <p class="text-green-600 text-xs mt-2 font-semibold">Redirecting you to your submissions… please do not close this page.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3" id="submitRow">
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

<script src="https://cdn.jsdelivr.net/npm/tus-js-client@4/dist/tus.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileTypeHints = {
        video:    'MP4, WebM, MOV, MKV, AVI (max 2 GB)',
        pdf:      'PDF files only (max 50 MB)',
        image:    'JPG, PNG, GIF, WebP (max 10 MB)',
        document: 'Word, Excel, PowerPoint (max 50 MB)',
        other:    'Any file type (max 50 MB)',
    };

    const videoAccept = 'video/mp4,video/webm,video/ogg,video/avi,video/quicktime,video/x-matroska';
    const fileAccepts = {
        video:    videoAccept,
        pdf:      'application/pdf',
        image:    'image/jpeg,image/png,image/gif,image/webp',
        document: '.doc,.docx,.xls,.xlsx,.ppt,.pptx',
        other:    '*',
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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

    // UI helpers
    const bar        = document.getElementById('uploadProgressBar');
    const percent    = document.getElementById('uploadPercent');
    const statusText = document.getElementById('uploadStatusText');
    const sizeText   = document.getElementById('uploadSizeText');
    const progressWrap = document.getElementById('uploadProgressWrapper');
    const submitRow    = document.getElementById('submitRow');

    function setStage(stage) {
        const upload     = document.getElementById('stageUpload');
        const process    = document.getElementById('stageProcess');
        const done       = document.getElementById('stageDone');
        const uploadDot  = document.getElementById('stageUploadDot');
        const processDot = document.getElementById('stageProcessDot');
        const doneDot    = document.getElementById('stageDoneDot');

        [upload, process, done].forEach(el => el.classList.add('opacity-30'));
        [uploadDot, processDot, doneDot].forEach(el => el.classList.remove('animate-pulse'));

        if (stage === 'uploading') {
            upload.classList.remove('opacity-30');
            uploadDot.classList.add('animate-pulse');
        } else if (stage === 'processing') {
            upload.classList.remove('opacity-30');
            uploadDot.classList.replace('bg-yellow-400', 'bg-green-400');
            process.classList.remove('opacity-30');
            processDot.classList.replace('bg-gray-400', 'bg-yellow-400');
            processDot.classList.add('animate-pulse');
        } else if (stage === 'done') {
            upload.classList.remove('opacity-30');
            process.classList.remove('opacity-30');
            done.classList.remove('opacity-30');
            doneDot.classList.replace('bg-green-400', 'bg-green-500');
            bar.style.width = '100%';
            bar.classList.replace('from-yellow-400', 'from-green-400');
            bar.classList.replace('to-yellow-600', 'to-green-600');
        }
    }

    function showSuccess(isVideo) {
        setStage('done');
        statusText.textContent = 'Done!';
        percent.textContent = '100%';
        sizeText.textContent = '';
        const successMsg    = document.getElementById('uploadSuccessMsg');
        const successTitle  = document.getElementById('uploadSuccessTitle');
        const successDetail = document.getElementById('uploadSuccessDetail');
        successTitle.textContent  = isVideo ? 'Video Uploaded Successfully!' : 'File Uploaded Successfully!';
        successDetail.textContent = isVideo
            ? 'Your video has been sent directly to our media server. You can now view it in your submissions.'
            : 'Your file has been received. You can now view it in your submissions.';
        successMsg.classList.remove('hidden');
    }

    function showError(msg) {
        progressWrap.classList.add('hidden');
        submitRow.classList.remove('hidden');
        alert(msg);
    }

    // ── VIDEO: direct tus upload to Bunny.net ──────────────────────────────
    async function handleVideoUpload(form) {
        const file        = document.getElementById('fileInput').files[0];
        const title       = form.querySelector('[name="title"]').value;
        const description = form.querySelector('[name="description"]').value;
        const courseId    = form.querySelector('[name="course_id"]').value || null;
        const moduleId    = document.getElementById('moduleSelect').value || null;

        // Step 1 — tell the server to create the video entry on Bunny and get signing credentials
        statusText.textContent = 'Preparing upload…';
        const prepResp = await fetch('{{ route("submissions.bunny.prepare") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ title, description, course_id: courseId, module_id: moduleId }),
        });

        if (!prepResp.ok) {
            const err = await prepResp.json().catch(() => ({}));
            throw new Error(err.error || 'Failed to prepare upload. Please try again.');
        }

        const { token, video_id, library_id, signature, expiry } = await prepResp.json();

        statusText.textContent = 'Uploading video directly to media server…';

        // Step 2 — tus upload straight from the browser to Bunny.net
        await new Promise((resolve, reject) => {
            const upload = new tus.Upload(file, {
                endpoint: 'https://video.bunnycdn.com/tusupload',
                retryDelays: [0, 3000, 5000, 10000, 20000],
                headers: {
                    AuthorizationSignature: signature,
                    AuthorizationExpire: String(expiry),
                    VideoId: video_id,
                    LibraryId: String(library_id),
                },
                metadata: {
                    filetype: file.type,
                    title: title,
                },
                onError(err) {
                    reject(new Error('Upload failed: ' + err.message));
                },
                onProgress(bytesUploaded, bytesTotal) {
                    const pct = Math.round((bytesUploaded / bytesTotal) * 100);
                    bar.style.width = pct + '%';
                    percent.textContent = pct + '%';
                    sizeText.textContent =
                        (bytesUploaded / 1048576).toFixed(1) + ' MB / ' +
                        (bytesTotal    / 1048576).toFixed(1) + ' MB uploaded';
                    if (pct === 100) {
                        setStage('processing');
                        statusText.textContent = 'File uploaded! Finalizing your submission…';
                    }
                },
                async onSuccess() {
                    // Step 3 — confirm on our server (creates the submission as 'pending')
                    try {
                        const confirmResp = await fetch('{{ route("submissions.bunny.confirm") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ token }),
                        });
                        if (!confirmResp.ok) {
                            reject(new Error('Upload succeeded but could not save your submission. Please contact support.'));
                            return;
                        }
                        const data = await confirmResp.json();
                        resolve(data.redirect);
                    } catch (e) {
                        reject(e);
                    }
                },
            });
            upload.start();
        }).then(redirectUrl => {
            showSuccess(true);
            setTimeout(() => { window.location.href = redirectUrl || '{{ route("submissions.index") }}'; }, 2500);
        });
    }

    // ── NON-VIDEO: regular XHR form upload ────────────────────────────────
    function handleFileUpload(form) {
        return new Promise((resolve, reject) => {
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.upload.addEventListener('progress', function (e) {
                if (!e.lengthComputable) return;
                const pct = Math.round((e.loaded / e.total) * 100);
                bar.style.width = pct + '%';
                percent.textContent = pct + '%';
                sizeText.textContent =
                    (e.loaded / 1048576).toFixed(1) + ' MB / ' +
                    (e.total  / 1048576).toFixed(1) + ' MB uploaded';
                if (pct === 100) {
                    setStage('processing');
                    statusText.textContent = 'File uploaded! Server is processing your submission…';
                    percent.textContent = '100%';
                }
            });

            xhr.addEventListener('load', function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    let redirectUrl = xhr.responseURL || xhr.getResponseHeader('Location');
                    if (!redirectUrl) {
                        try {
                            const json = JSON.parse(xhr.responseText);
                            if (json.redirect) redirectUrl = json.redirect;
                        } catch (_) {}
                    }
                    resolve(redirectUrl || '{{ route("submissions.index") }}');
                } else {
                    reject(new Error('Upload failed (HTTP ' + xhr.status + '). Please try again.'));
                }
            });

            xhr.addEventListener('error', function () {
                reject(new Error('Network error during upload. Please check your connection and try again.'));
            });

            xhr.send(formData);
        }).then(redirectUrl => {
            showSuccess(false);
            setTimeout(() => { window.location.href = redirectUrl; }, 2500);
        });
    }

    // ── Form submit dispatcher ─────────────────────────────────────────────
    document.getElementById('submissionForm').addEventListener('submit', function (e) {
        e.preventDefault();

        submitRow.classList.add('hidden');
        progressWrap.classList.remove('hidden');
        setStage('uploading');

        const isVideo = getSelectedType() === 'video';
        statusText.textContent = isVideo ? 'Preparing upload…' : 'Uploading file… please wait';

        const handler = isVideo ? handleVideoUpload(this) : handleFileUpload(this);
        handler.catch(err => showError(err.message));
    });

    // ── Course → modules AJAX ─────────────────────────────────────────────
    document.querySelector('select[name="course_id"]').addEventListener('change', function () {
        const courseId  = this.value;
        const moduleSel = document.getElementById('moduleSelect');
        moduleSel.innerHTML = '<option value="">— Select module (optional) —</option>';
        if (!courseId) return;
        fetch(`/api/courses/${courseId}/modules`)
            .then(r => {
                if (!r.ok) throw new Error('Server returned ' + r.status);
                return r.json();
            })
            .then(modules => {
                if (!modules.length) {
                    moduleSel.innerHTML = '<option value="">— No modules available —</option>';
                    return;
                }
                modules.forEach(m => {
                    const opt = document.createElement('option');
                    opt.value = m.id;
                    opt.textContent = m.title;
                    moduleSel.appendChild(opt);
                });
            })
            .catch(() => {
                moduleSel.innerHTML = '<option value="">— Could not load modules —</option>';
            });
    });

    // Initialize
    document.getElementById('videoNote').style.display = getSelectedType() === 'video' ? 'block' : 'none';
    document.getElementById('fileInput').accept = fileAccepts[getSelectedType()];
});
</script>
@endsection
