<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\StudentSubmission;
use App\Services\BunnyVideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = auth()->user()->submissions()
            ->with(['course', 'module'])
            ->latest()
            ->paginate(12);

        return view('frontend.submissions.index', compact('submissions'));
    }

    public function create()
    {
        $user    = auth()->user();
        $courses = $user->enrollments()->with('course')->get()->pluck('course');
        $modules = collect();

        return view('frontend.submissions.create', compact('courses', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'file_type'   => 'required|in:video,pdf,image,document,other',
            'course_id'   => 'nullable|exists:courses,id',
            'module_id'   => 'nullable|exists:modules,id',
            'file'        => [
                'required',
                'file',
                match ($request->input('file_type')) {
                    'video'    => 'mimetypes:video/mp4,video/webm,video/ogg,video/avi,video/quicktime,video/x-matroska',
                    'pdf'      => 'mimes:pdf',
                    'image'    => 'mimes:jpg,jpeg,png,gif,webp',
                    'document' => 'mimes:doc,docx,xls,xlsx,ppt,pptx',
                    default    => 'max:51200',
                },
                'max:2097152', // 2 GB max
            ],
        ], [
            'file.required'   => 'Please select a file to upload.',
            'file.mimetypes'  => 'Invalid video format. Supported: MP4, WebM, OGG, AVI, MOV, MKV.',
            'file.mimes'      => 'Invalid file format for the selected type.',
        ]);

        $file     = $request->file('file');
        $fileType = $request->input('file_type');

        $submissionData = [
            'user_id'     => auth()->id(),
            'course_id'   => $request->input('course_id'),
            'module_id'   => $request->input('module_id'),
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'file_type'   => $fileType,
            'status'      => 'pending',
        ];

        if ($fileType === 'video') {
            // Upload video directly to Bunny.net — not saved on our server
            $libraryId = config('services.bunny.library_id');

            if (empty($libraryId)) {
                return back()->withErrors(['file' => 'Video upload service is not configured. Please contact admin.'])->withInput();
            }

            try {
                $service    = app(BunnyVideoService::class);
                $bunnyVideo = $service->createVideo($libraryId, $request->input('title'));
                $videoId    = $bunnyVideo['guid'];

                // Stream the file to Bunny.net — the file is never written to our storage
                $service->uploadVideo($libraryId, $videoId, $file->getRealPath());

                $submissionData['bunny_library_id'] = $libraryId;
                $submissionData['bunny_video_id']   = $videoId;
                $submissionData['video_url']        = $service->embedUrl($libraryId, $videoId);
            } catch (\Throwable $e) {
                Log::error('Student video submission upload failed: ' . $e->getMessage());
                return back()
                    ->withErrors(['file' => 'Video upload failed. Please try again.'])
                    ->withInput();
            }
        } else {
            // Store file on server (PDF, image, document)
            $path = $file->store('student-submissions', 'public');

            $submissionData['file_path'] = $path;
            $submissionData['file_mime'] = $file->getMimeType();
            $submissionData['file_size'] = $file->getSize();
        }

        $submission = StudentSubmission::create($submissionData);

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Your submission has been uploaded successfully!');
    }

    /**
     * Step 1 of direct video upload:
     * Create a video entry on Bunny.net and return tus signing credentials to the browser.
     * The video file is NOT sent to this endpoint — only form metadata.
     * Submission data is held in the session (keyed by a random token) until confirmed.
     */
    public function prepareBunnyUpload(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'course_id'   => 'nullable|exists:courses,id',
            'module_id'   => 'nullable|exists:modules,id',
        ]);

        $libraryId = config('services.bunny.library_id');

        if (empty($libraryId)) {
            return response()->json(['error' => 'Video upload service is not configured. Please contact admin.'], 503);
        }

        try {
            $service    = app(BunnyVideoService::class);
            $bunnyVideo = $service->createVideo($libraryId, $request->input('title'));
            $videoId    = $bunnyVideo['guid'];
            $expiry     = time() + 3600; // signature valid for 1 hour
            $signature  = $service->generateTusSignature($libraryId, $videoId, $expiry);

            // Hold submission data in session — DB record is created only on confirm
            $token = Str::random(40);
            session(["bunny_upload_{$token}" => [
                'user_id'          => auth()->id(),
                'course_id'        => $request->input('course_id') ?: null,
                'module_id'        => $request->input('module_id') ?: null,
                'title'            => $request->input('title'),
                'description'      => $request->input('description'),
                'bunny_library_id' => $libraryId,
                'bunny_video_id'   => $videoId,
                'video_url'        => $service->embedUrl($libraryId, $videoId),
            ]]);

            return response()->json([
                'token'      => $token,
                'video_id'   => $videoId,
                'library_id' => $libraryId,
                'signature'  => $signature,
                'expiry'     => $expiry,
            ]);
        } catch (\Throwable $e) {
            Log::error('Bunny prepare upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to prepare upload. Please try again.'], 500);
        }
    }

    /**
     * Step 2 of direct video upload:
     * Called by the browser after the tus upload completes.
     * Reads the session token, creates the submission as 'pending', and returns a redirect URL.
     */
    public function confirmBunnyUpload(Request $request)
    {
        $token = $request->input('token');
        $key   = "bunny_upload_{$token}";
        $data  = session($key);

        if (!$data || $data['user_id'] !== auth()->id()) {
            return response()->json(['error' => 'Invalid or expired upload session. Please try again.'], 422);
        }

        $submission = StudentSubmission::create(array_merge($data, [
            'file_type' => 'video',
            'status'    => 'pending',
        ]));

        session()->forget($key);

        return response()->json([
            'redirect' => route('submissions.show', $submission),
        ]);
    }

    public function show(StudentSubmission $submission)
    {
        // Students can only view their own submissions
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }

        $submission->load(['course', 'module', 'reviewer']);

        // Generate signed URL if this is a Bunny video submission
        $signedVideoUrl = null;
        if ($submission->isVideo() && $submission->bunny_video_id) {
            $bunny = app(BunnyVideoService::class);
            $libraryId = $submission->bunny_library_id ?: $bunny->getDefaultLibraryId();
            $signedVideoUrl = $bunny->signedEmbedUrl($libraryId, $submission->bunny_video_id);
        }

        return view('frontend.submissions.show', compact('submission', 'signedVideoUrl'));
    }
}
