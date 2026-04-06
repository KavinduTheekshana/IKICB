<?php

namespace App\Console\Commands;

use App\Services\WebxpayService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestWebxpayConnection extends Command
{
    protected $signature = 'webxpay:test-connection';
    protected $description = 'Test WebXPay configuration and connection';

    public function handle(WebxpayService $webxpayService): int
    {
        $this->info('Testing WebXPay Configuration...');
        $this->newLine();

        // Test 1: Check environment variables
        $this->info('1. Checking environment configuration...');
        $secretKey = config('services.webxpay.secret_key');
        $publicKeyPath = config('services.webxpay.public_key_path');
        $sandbox = config('services.webxpay.sandbox');
        $cms = config('services.webxpay.cms');

        if (empty($secretKey)) {
            $this->error('   ✗ WEBXPAY_SECRET_KEY is not set in .env');
            return self::FAILURE;
        }
        $this->info('   ✓ SECRET_KEY is configured');

        if (empty($publicKeyPath)) {
            $this->error('   ✗ WEBXPAY_PUBLIC_KEY_PATH is not set in .env');
            return self::FAILURE;
        }
        $this->info('   ✓ PUBLIC_KEY_PATH is configured: ' . $publicKeyPath);

        $this->info('   ✓ Sandbox mode: ' . ($sandbox ? 'Enabled' : 'Disabled'));
        $this->info('   ✓ CMS: ' . $cms);
        $this->newLine();

        // Test 2: Check public key file
        $this->info('2. Checking public key file...');

        if (!file_exists($publicKeyPath)) {
            $this->error('   ✗ Public key file not found at: ' . $publicKeyPath);
            $this->newLine();
            $this->warn('   To fix this:');
            $this->warn('   1. Login to your WebXPay merchant dashboard');
            $this->warn('   2. Navigate to API Settings or Integration section');
            $this->warn('   3. Download the public key file (webxpay_public.pem)');
            $this->warn('   4. Place it at: ' . storage_path('app/webxpay_public.pem'));
            return self::FAILURE;
        }

        $keyContent = file_get_contents($publicKeyPath);
        if ($keyContent === false) {
            $this->error('   ✗ Could not read public key file');
            return self::FAILURE;
        }

        // Validate it's a valid PEM public key
        $publicKey = openssl_pkey_get_public($keyContent);
        if ($publicKey === false) {
            $this->error('   ✗ Invalid public key format');
            $this->error('   OpenSSL Error: ' . openssl_error_string());
            return self::FAILURE;
        }
        openssl_free_key($publicKey);

        $keySize = strlen($keyContent);
        $this->info('   ✓ Public key file exists and is valid');
        $this->info('   Key size: ' . $keySize . ' bytes');
        $this->newLine();

        // Test 3: Test encryption/decryption
        $this->info('3. Testing encryption...');
        try {
            $testOrderId = 'TEST-' . time();
            $testAmount = 1000.00;

            $encrypted = $webxpayService->generatePaymentField($testOrderId, $testAmount);

            $this->info('   ✓ Successfully encrypted test payment data');
            $this->info('   Test Order ID: ' . $testOrderId);
            $this->info('   Test Amount: LKR ' . number_format($testAmount, 2));
            $this->info('   Encrypted length: ' . strlen($encrypted) . ' characters');
        } catch (\Exception $e) {
            $this->error('   ✗ Encryption failed: ' . $e->getMessage());
            return self::FAILURE;
        }
        $this->newLine();

        // Test 4: Test custom fields encoding
        $this->info('4. Testing custom fields encoding...');
        try {
            $customFields = $webxpayService->generateCustomFields([
                'course_123',
                'module_456',
                'full_course'
            ]);
            $this->info('   ✓ Successfully encoded custom fields');
            $this->info('   Encoded length: ' . strlen($customFields) . ' characters');
        } catch (\Exception $e) {
            $this->error('   ✗ Custom fields encoding failed: ' . $e->getMessage());
            return self::FAILURE;
        }
        $this->newLine();

        // Test 5: Test payment URL
        $this->info('5. Testing payment gateway URL...');
        $paymentUrl = $webxpayService->getPaymentUrl();
        $this->info('   Payment URL: ' . $paymentUrl);

        try {
            $response = Http::timeout(30)
                ->connectTimeout(15)
                ->get($paymentUrl);

            if ($response->successful() || $response->status() === 405) {
                // 405 is expected for GET on POST endpoint
                $this->info('   ✓ Payment gateway URL is reachable');
                $this->info('   Status: ' . $response->status());
            } else {
                $this->warn('   ⚠ Payment gateway returned status: ' . $response->status());
                $this->warn('   This may be normal if the URL expects POST requests');
            }
        } catch (\Exception $e) {
            $this->error('   ✗ Could not connect to payment gateway: ' . $e->getMessage());
            $this->newLine();
            $this->warn('   This could mean:');
            $this->warn('   - Firewall blocking outbound HTTPS connections');
            $this->warn('   - Server DNS issues');
            $this->warn('   - Network connectivity problems');
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('✓ All tests passed! WebXPay is properly configured.');
        $this->newLine();

        $this->comment('Note: This only tests the configuration and encryption.');
        $this->comment('Actual payment processing will be tested when a user makes a payment.');

        return self::SUCCESS;
    }
}
