<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BunnyVideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BunnyController extends Controller
{
    /**
     * Create a video entry on Bunny.net and return tus signing credentials
     * so the admin browser can upload directly — the file never touches this server.
     */
    public function prepareVideoUpload(Request $request)
    {
        // Only admins and branch admins may manage module videos
        if (!auth()->user()?->isAdmin() && !auth()->user()?->isBranchAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $request->validate([
            'title'      => 'required|string|max:255',
            'library_id' => 'required|string',
        ]);

        try {
            $service    = app(BunnyVideoService::class);
            $libraryId  = $request->input('library_id');
            $bunnyVideo = $service->createVideo($libraryId, $request->input('title'));
            $videoId    = $bunnyVideo['guid'];
            $expiry     = time() + 3600;
            $signature  = $service->generateTusSignature($libraryId, $videoId, $expiry);

            return response()->json([
                'video_id'   => $videoId,
                'library_id' => $libraryId,
                'signature'  => $signature,
                'expiry'     => $expiry,
            ]);
        } catch (\Throwable $e) {
            Log::error('Admin Bunny prepare video upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to prepare upload: ' . $e->getMessage()], 500);
        }
    }
}
