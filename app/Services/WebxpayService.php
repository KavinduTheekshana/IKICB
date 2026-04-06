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
     * Decrypt the `payment` field from WEBXPAY's callback response.
     * Returns parsed fields plus the raw decrypted string for signature verification.
     */
    public function decryptPayment(string $encryptedPayment): ?array
    {
        try {
            $decoded = base64_decode($encryptedPayment, true);

            if ($decoded === false) {
                Log::error('WEBXPAY: Failed to base64 decode payment response');
                return null;
            }

            $publicKey = $this->getPublicKey();
            $success = openssl_public_decrypt($decoded, $decrypted, $publicKey);

            if (!$success) {
                $error = openssl_error_string();
                Log::error('WEBXPAY: Failed to decrypt payment response', ['error' => $error]);
                return null;
            }

            $parts = explode('|', $decrypted);

            if (count($parts) < 4) {
                Log::error('WEBXPAY: Invalid payment response format', [
                    'parts_count' => count($parts),
                    'raw' => $decrypted
                ]);
                return null;
            }

            return [
                'raw'          => $decrypted,
                'order_id'     => $parts[0] ?? null,
                'reference'    => $parts[1] ?? null,
                'datetime'     => $parts[2] ?? null,
                'gateway'      => $parts[3] ?? null,
                'status_code'  => $parts[4] ?? null,
                'comment'      => $parts[5] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('WEBXPAY: Exception during payment decryption', [
                'error' => $e->getMessage()
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
     * WEBXPAY status codes 0 or 00 indicate a successful transaction.
     */
    public function isSuccessful(string $statusCode): bool
    {
        return in_array($statusCode, ['0', '00']);
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
