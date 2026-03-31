<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class BunnyVideoService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://video.bunnycdn.com';

    public function __construct()
    {
        $this->apiKey = config('services.bunny.stream_api_key', '');
    }

    /**
     * Create a new video entry in a Bunny.net library.
     * Returns the full API response array including 'guid' (video ID).
     */
    public function createVideo(string $libraryId, string $title): array
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
            'Accept'    => 'application/json',
        ])->post("{$this->baseUrl}/library/{$libraryId}/videos", [
            'title' => $title,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException(
                'Failed to create video on Bunny.net: ' . $response->body()
            );
        }

        return $response->json();
    }

    /**
     * Upload a video file to Bunny.net by streaming from a local path.
     * The file is streamed in chunks — it is NOT fully loaded into memory.
     * The local file is deleted immediately after the upload attempt.
     */
    public function uploadVideo(string $libraryId, string $videoId, string $filePath): bool
    {
        $fileHandle = fopen($filePath, 'r');

        if ($fileHandle === false) {
            throw new RuntimeException("Cannot open file for upload: {$filePath}");
        }

        try {
            $client = new Client();
            $response = $client->put(
                "{$this->baseUrl}/library/{$libraryId}/videos/{$videoId}",
                [
                    RequestOptions::HEADERS => [
                        'AccessKey'    => $this->apiKey,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    RequestOptions::BODY    => $fileHandle,
                    RequestOptions::TIMEOUT => 0, // No timeout — large files can take a while
                ]
            );

            return $response->getStatusCode() === 200;
        } finally {
            if (is_resource($fileHandle)) {
                fclose($fileHandle);
            }
            // Always remove the temp file after upload attempt
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    /**
     * Delete a video from Bunny.net.
     */
    public function deleteVideo(string $libraryId, string $videoId): bool
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
        ])->delete("{$this->baseUrl}/library/{$libraryId}/videos/{$videoId}");

        return $response->successful();
    }

    /**
     * Get video details from Bunny.net (includes encoding status).
     */
    public function getVideoStatus(string $libraryId, string $videoId): array
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
            'Accept'    => 'application/json',
        ])->get("{$this->baseUrl}/library/{$libraryId}/videos/{$videoId}");

        if (!$response->successful()) {
            return [];
        }

        return $response->json();
    }

    /**
     * Build the embed URL for a video.
     */
    public function embedUrl(string $libraryId, string $videoId): string
    {
        return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$videoId}";
    }

    /**
     * Build a signed embed URL with token authentication and short expiry.
     *
     * Token authentication must be enabled in Bunny Stream:
     *   Video Library → Security → Enable Token Authentication
     *   Copy the token key into BUNNY_STREAM_TOKEN_KEY in .env
     *
     * If no token key is configured, falls back to a plain embed URL
     * with download/share controls hidden.
     *
     * @param  int  $expiresInSeconds  How long the URL is valid (default 10 minutes)
     */
    public function signedEmbedUrl(string $libraryId, string $videoId, int $expiresInSeconds = 600): string
    {
        $tokenKey = config('services.bunny.token_key', '');

        $baseParams = http_build_query([
            'hideDownload' => 'true',
            'hideShare'    => 'true',
            'autoplay'     => 'false',
        ]);

        if (empty($tokenKey)) {
            // Token auth not configured — return plain URL with controls hidden
            return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$videoId}?{$baseParams}";
        }

        $expires = time() + $expiresInSeconds;

        // Bunny.net token format: SHA256(tokenKey + videoId + expires)
        $token = hash('sha256', $tokenKey . $videoId . $expires);

        $params = http_build_query([
            'token'        => $token,
            'expires'      => $expires,
            'hideDownload' => 'true',
            'hideShare'    => 'true',
            'autoplay'     => 'false',
        ]);

        return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$videoId}?{$params}";
    }

    public function getDefaultLibraryId(): string
    {
        return config('services.bunny.library_id', '');
    }
}
