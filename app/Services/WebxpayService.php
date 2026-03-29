<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ModuleUnlock;
use App\Models\Payment;

class WebxpayService
{
    protected string $secretKey;
    protected string $publicKeyPath;
    protected bool $sandbox;
    protected string $cms;

    public function __construct()
    {
        $this->secretKey = config('services.webxpay.secret_key');
        $this->publicKeyPath = config('services.webxpay.public_key_path');
        $this->sandbox = config('services.webxpay.sandbox', true);
        $this->cms = config('services.webxpay.cms', 'custom');
    }

    public function getPaymentUrl(): string
    {
        return $this->sandbox
            ? 'https://stagingxpay.info/index.php?route=checkout/billing'
            : 'https://webxpay.com/index.php?route=checkout/billing';
    }

    protected function getPublicKey(): string
    {
        $keyContent = file_get_contents($this->publicKeyPath);

        if ($keyContent === false) {
            throw new \RuntimeException('WEBXPAY: Could not read public key from: ' . $this->publicKeyPath);
        }

        return $keyContent;
    }

    /**
     * RSA-encrypt the order_id|amount string and base64-encode it.
     * Matches WEBXPAY's official PHP example exactly.
     */
    public function generatePaymentField(string $orderId, float $amount): string
    {
        $plaintext = $orderId . '|' . number_format($amount, 2, '.', '');

        openssl_public_encrypt($plaintext, $encrypted, $this->getPublicKey());

        return base64_encode($encrypted);
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
        $decoded = base64_decode($encryptedPayment);

        if (!openssl_public_decrypt($decoded, $decrypted, $this->getPublicKey())) {
            return null;
        }

        $parts = explode('|', $decrypted);

        if (count($parts) < 4) {
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

        $details = $payment->payment_details;

        if (!isset($details['type'])) {
            $details['type'] = ($payment->course_id && !$payment->module_id)
                ? 'full_course'
                : 'module';
        }

        if ($details['type'] === 'full_course') {
            Enrollment::updateOrCreate(
                ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                ['purchase_type' => 'full_course', 'status' => 'active']
            );

            $modules = Course::find($payment->course_id)->modules;
            foreach ($modules as $module) {
                ModuleUnlock::updateOrCreate(
                    ['user_id' => $payment->user_id, 'module_id' => $module->id],
                    ['payment_id' => $payment->id, 'unlocked_at' => now()]
                );
            }
        } elseif ($details['type'] === 'module') {
            Enrollment::updateOrCreate(
                ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                ['purchase_type' => 'module_wise', 'status' => 'active']
            );

            ModuleUnlock::updateOrCreate(
                ['user_id' => $payment->user_id, 'module_id' => $payment->module_id],
                ['payment_id' => $payment->id, 'unlocked_at' => now()]
            );
        }
    }

    public function handleFailedPayment(Payment $payment): void
    {
        $payment->update(['status' => 'failed']);
    }
}
