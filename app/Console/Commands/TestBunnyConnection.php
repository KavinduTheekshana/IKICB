<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestBunnyConnection extends Command
{
    protected $signature = 'bunny:test-connection';
    protected $description = 'Test connection to Bunny.net API for debugging timeout issues';

    public function handle(): int
    {
        $this->info('Testing connection to Bunny.net...');
        $this->newLine();

        $apiKey = config('services.bunny.stream_api_key');
        $libraryId = config('services.bunny.library_id');

        if (empty($apiKey) || empty($libraryId)) {
            $this->error('BUNNY_STREAM_API_KEY or BUNNY_LIBRARY_ID not configured in .env');
            return self::FAILURE;
        }

        // Test 1: DNS Resolution
        $this->info('1. Testing DNS resolution for video.bunnycdn.com...');
        $dnsStart = microtime(true);
        $dnsResult = gethostbyname('video.bunnycdn.com');
        $dnsTime = round((microtime(true) - $dnsStart) * 1000, 2);

        if ($dnsResult === 'video.bunnycdn.com') {
            $this->error("   ✗ DNS resolution failed");
            return self::FAILURE;
        }
        $this->info("   ✓ Resolved to: {$dnsResult} ({$dnsTime}ms)");
        $this->newLine();

        // Test 2: cURL version and SSL support
        $this->info('2. Checking cURL configuration...');
        $curlVersion = curl_version();
        $this->info("   Version: {$curlVersion['version']}");
        $this->info("   SSL: {$curlVersion['ssl_version']}");
        $this->info("   IPv6: " . (($curlVersion['features'] & CURL_VERSION_IPV6) ? 'Yes' : 'No'));
        $this->newLine();

        // Test 3: Simple connectivity test
        $this->info('3. Testing basic HTTPS connectivity...');
        $connectStart = microtime(true);

        try {
            $response = Http::timeout(60)
                ->connectTimeout(30)
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_VERBOSE => false,
                    ],
                ])
                ->withHeaders([
                    'AccessKey' => $apiKey,
                    'Accept' => 'application/json',
                ])
                ->get("https://video.bunnycdn.com/library/{$libraryId}/videos");

            $connectTime = round((microtime(true) - $connectStart) * 1000, 2);

            if ($response->successful()) {
                $this->info("   ✓ Connection successful ({$connectTime}ms)");
                $this->info("   Status: {$response->status()}");
            } else {
                $this->error("   ✗ Connection failed");
                $this->error("   Status: {$response->status()}");
                $this->error("   Response: {$response->body()}");
            }
        } catch (\Exception $e) {
            $connectTime = round((microtime(true) - $connectStart) * 1000, 2);
            $this->error("   ✗ Connection error ({$connectTime}ms)");
            $this->error("   Error: {$e->getMessage()}");
            return self::FAILURE;
        }

        $this->newLine();

        // Test 4: Create test video (will be deleted)
        $this->info('4. Testing video creation API...');
        $createStart = microtime(true);

        try {
            $response = Http::timeout(config('http.bunny.timeout', 120))
                ->connectTimeout(config('http.bunny.connect_timeout', 60))
                ->retry(3, 1000)
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    ],
                ])
                ->withHeaders([
                    'AccessKey' => $apiKey,
                    'Accept' => 'application/json',
                ])
                ->post("https://video.bunnycdn.com/library/{$libraryId}/videos", [
                    'title' => 'Connection Test - ' . now()->toDateTimeString(),
                ]);

            $createTime = round((microtime(true) - $createStart) * 1000, 2);

            if ($response->successful()) {
                $data = $response->json();
                $videoId = $data['guid'] ?? null;

                $this->info("   ✓ Video created successfully ({$createTime}ms)");
                $this->info("   Video ID: {$videoId}");

                // Clean up: delete the test video
                if ($videoId) {
                    $this->info('   Cleaning up test video...');
                    Http::timeout(60)
                        ->withHeaders(['AccessKey' => $apiKey])
                        ->delete("https://video.bunnycdn.com/library/{$libraryId}/videos/{$videoId}");
                    $this->info("   ✓ Test video deleted");
                }
            } else {
                $this->error("   ✗ Video creation failed ({$createTime}ms)");
                $this->error("   Status: {$response->status()}");
                $this->error("   Response: {$response->body()}");
                return self::FAILURE;
            }
        } catch (\Exception $e) {
            $createTime = round((microtime(true) - $createStart) * 1000, 2);
            $this->error("   ✗ Video creation error ({$createTime}ms)");
            $this->error("   Error: {$e->getMessage()}");
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('✓ All tests passed! Connection to Bunny.net is working.');

        return self::SUCCESS;
    }
}
