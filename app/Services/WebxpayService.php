<?php

namespace App\Services;

use App\Filament\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class WebxpayService
{
    protected string $secretKey;
    protected string $publicKeyPath;
    protected string $apiUsername;
    protected string $apiPassword;
    protected bool $sandbox;
    protected string $cms;

    public function __construct()
    {
        $this->secretKey = config('services.webxpay.secret_key', '');
        $this->publicKeyPath = config('services.webxpay.public_key_path', '');
        $this->apiUsername = config('services.webxpay.api_username', '');
        $this->apiPassword = config('services.webxpay.api_password', '');
        $this->sandbox = config('services.webxpay.sandbox', true);
        $this->cms = config('services.webxpay.cms', 'custom');

        $this->validateConfiguration();
    }

    protected function validateConfiguration(): void
    {
        if (empty($this->secretKey)) {
            Log::warning('WEBXPAY: SECRET_KEY is not configured in .env');
        }

        if (empty($this->publicKeyPath)) {
            Log::warning('WEBXPAY: PUBLIC_KEY_PATH is not configured in .env');
        } elseif (!file_exists($this->publicKeyPath)) {
            Log::error('WEBXPAY: Public key file not found at: ' . $this->publicKeyPath);
        }

        if (empty($this->apiUsername)) {
            Log::warning('WEBXPAY: API_USERNAME is not configured in .env');
        }

        if (empty($this->apiPassword)) {
            Log::warning('WEBXPAY: API_PASSWORD is not configured in .env');
        }
    }

    public function getPaymentUrl(): string
    {
        return $this->sandbox
            ? 'https://stagingxpay.info/index.php?route=checkout/billing'
            : 'https://webxpay.com/index.php?route=checkout/billing';
    }

    protected function getPublicKey(): string
    {
        if (empty($this->publicKeyPath)) {
            Log::error('WEBXPAY: Public key path is not configured');
            throw new \RuntimeException('WEBXPAY: Public key path is not configured. Set WEBXPAY_PUBLIC_KEY_PATH in .env');
        }

        if (!file_exists($this->publicKeyPath)) {
            Log::error('WEBXPAY: Public key file not found at: ' . $this->publicKeyPath);
            throw new \RuntimeException('WEBXPAY: Public key file not found at: ' . $this->publicKeyPath . '. Please download it from WebXPay dashboard.');
        }

        $keyContent = file_get_contents($this->publicKeyPath);

        if ($keyContent === false) {
            Log::error('WEBXPAY: Could not read public key from: ' . $this->publicKeyPath);
            throw new \RuntimeException('WEBXPAY: Could not read public key from: ' . $this->publicKeyPath);
        }

        return $keyContent;
    }

    /**
     * RSA-encrypt the order_id|amount string and base64-encode it.
     * Matches WEBXPAY's official PHP example exactly.
     * Uses PKCS1 padding as required by WebXPay.
     */
    public function generatePaymentField(string $orderId, float $amount): string
    {
        $plaintext = $orderId . '|' . number_format($amount, 2, '.', '');

        $publicKey = $this->getPublicKey();

        // WebXPay requires PKCS1 padding (not OAEP which is the default in some PHP versions)
        $success = openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        if (!$success) {
            $error = openssl_error_string();
            Log::error('WEBXPAY: Failed to encrypt payment field', [
                'order_id' => $orderId,
                'amount' => $amount,
                'plaintext' => $plaintext,
                'error' => $error
            ]);
            throw new \RuntimeException('WEBXPAY: Failed to encrypt payment data. ' . $error);
        }

        $encoded = base64_encode($encrypted);

        Log::info('WEBXPAY: Payment field encrypted successfully', [
            'order_id' => $orderId,
            'amount' => $amount,
            'plaintext' => $plaintext,
            'encrypted_length' => strlen($encrypted),
            'encoded_length' => strlen($encoded),
        ]);

        return $encoded;
    }

    /**
     * Encode custom fields as pipe-separated base64 string.
     */
    public function generateCustomFields(array $values): string
    {
        return base64_encode(implode('|', $values));
    }

    /**
     * Process the payment response from WEBXPAY's callback.
     * WebXPay returns base64 encoded pipe-separated values.
     * Format: order_id|reference|datetime|gateway|status_code|comment
     */
    public function decryptPayment(string $encryptedPayment): ?array
    {
        try {
            Log::info('WEBXPAY: Processing payment response', [
                'encrypted_length' => strlen($encryptedPayment),
                'encrypted_preview' => substr($encryptedPayment, 0, 100) . '...',
            ]);

            // WebXPay sends base64 encoded data, not RSA encrypted
            $decoded = base64_decode($encryptedPayment, true);

            if ($decoded === false) {
                // If base64 decode fails, maybe it's already decoded? Try to use it as-is
                $decoded = $encryptedPayment;
                Log::warning('WEBXPAY: Base64 decode failed, using raw value', [
                    'raw_value' => $encryptedPayment,
                ]);
            } else {
                Log::info('WEBXPAY: Base64 decode successful', [
                    'decoded_length' => strlen($decoded),
                    'decoded_preview' => substr($decoded, 0, 100),
                ]);
            }

            // Parse pipe-separated values
            $parts = explode('|', $decoded);

            Log::info('WEBXPAY: Parsed response parts', [
                'parts_count' => count($parts),
                'parts' => $parts,
            ]);

            if (count($parts) < 4) {
                Log::error('WEBXPAY: Invalid payment response format - not enough parts', [
                    'parts_count' => count($parts),
                    'raw' => $decoded,
                    'parts' => $parts,
                ]);
                return null;
            }

            $result = [
                'raw'          => $decoded,
                'order_id'     => $parts[0] ?? null,
                'reference'    => $parts[1] ?? null,
                'datetime'     => $parts[2] ?? null,
                'gateway'      => $parts[3] ?? null,
                'status_code'  => $parts[4] ?? null,
                'comment'      => $parts[5] ?? null,
            ];

            Log::info('WEBXPAY: Payment response processed successfully', $result);

            return $result;
        } catch (\Exception $e) {
            Log::error('WEBXPAY: Exception during payment processing', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Verify the `signature` field matches the decrypted payment string.
     */
    public function verifySignature(string $encryptedSignature, string $rawDecryptedPayment): bool
    {
        $decoded = base64_decode($encryptedSignature);
        openssl_public_decrypt($decoded, $decryptedSig, $this->getPublicKey());

        return $decryptedSig === $rawDecryptedPayment;
    }

    /**
     * WEBXPAY status codes indicate a successful transaction.
     * Sandbox mode: "00 - Approved" or just "00"
     * Live mode: "100 - Request was processed successfully."
     */
    public function isSuccessful(string $statusCode): bool
    {
        // Extract the numeric code (first part before any dash or space)
        $code = trim(explode('-', $statusCode)[0]);
        $code = trim(explode(' ', $code)[0]);

        Log::info('WEBXPAY: Checking if payment is successful', [
            'original_status_code' => $statusCode,
            'extracted_code' => $code,
            'is_successful' => in_array($code, ['0', '00', '100']),
        ]);

        // Accept status codes:
        // - 0, 00: Sandbox success
        // - 100: Live mode success
        return in_array($code, ['0', '00', '100']);
    }

    public function handleSuccessfulPayment(Payment $payment): void
    {
        $payment->update(['status' => 'completed', 'completed_at' => now()]);

        PaymentResource::handlePaymentCompleted($payment);
    }

    public function handleFailedPayment(Payment $payment): void
    {
        $payment->update(['status' => 'failed']);
    }
}
