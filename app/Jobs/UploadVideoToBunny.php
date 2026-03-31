<?php

namespace App\Jobs;

use App\Models\ModuleVideo;
use App\Services\BunnyVideoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class UploadVideoToBunny implements ShouldQueue
{
    use Queueable;

    public int $timeout = 0;  // No timeout — large videos can take a long time
    public int $tries   = 2;  // Retry once on failure

    public function __construct(
        public readonly int    $moduleVideoId,
        public readonly string $localPath,
    ) {}

    public function handle(BunnyVideoService $service): void
    {
        $record = ModuleVideo::find($this->moduleVideoId);

        if (!$record) {
            $this->cleanupFile();
            return;
        }

        if (!file_exists($this->localPath)) {
            Log::error("UploadVideoToBunny: file not found at {$this->localPath}");
            $record->update(['status' => 'failed', 'temp_file_path' => null]);
            return;
        }

        try {
            $libraryId  = $record->bunny_library_id;
            $bunnyVideo = $service->createVideo($libraryId, $record->title);
            $videoId    = $bunnyVideo['guid'];

            // Save video ID before uploading so it can be tracked if upload is slow
            $record->update([
                'bunny_video_id' => $videoId,
                'video_url'      => $service->embedUrl($libraryId, $videoId),
                'status'         => 'uploading',
            ]);

            $service->uploadVideo($libraryId, $videoId, $this->localPath);

            $record->update([
                'status'         => 'processing',
                'temp_file_path' => null,
            ]);

        } catch (\Throwable $e) {
            Log::error("UploadVideoToBunny job failed for video #{$this->moduleVideoId}: " . $e->getMessage());
            $this->cleanupFile();
            $record->update(['status' => 'failed', 'temp_file_path' => null]);
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error("UploadVideoToBunny permanently failed for video #{$this->moduleVideoId}: " . $e->getMessage());
        $this->cleanupFile();
        ModuleVideo::find($this->moduleVideoId)?->update(['status' => 'failed', 'temp_file_path' => null]);
    }

    private function cleanupFile(): void
    {
        if (file_exists($this->localPath)) {
            unlink($this->localPath);
        }
    }
}
