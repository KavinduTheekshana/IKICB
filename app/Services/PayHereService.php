<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\ModuleUnlock;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PayHereService
{
    protected string $merchantId;
    protected string $merchantSecret;
    protected string $apiUrl;
    protected bool $sandbox;

    public function __construct()
    {
        $this->merchantId = config('services.payhere.merchant_id');
        $this->merchantSecret = config('services.payhere.merchant_secret');
        $this->sandbox = config('services.payhere.sandbox', true);
        $this->apiUrl = $this->sandbox
            ? 'https://sandbox.payhere.lk'
            : 'https://www.payhere.lk';
    }

    /**
     * Generate payment hash for PayHere
     */
    public function generateHash(array $data): string
    {
        $hashedSecret = strtoupper(
            md5($this->merchantSecret)
        );

        $amountFormatted = number_format($data['amount'], 2, '.', '');

        $hash = strtoupper(
            md5(
                $this->merchantId .
                $data['order_id'] .
                $amountFormatted .
                $data['currency'] .
                $hashedSecret
            )
        );

        return $hash;
    }

    /**
     * Create payment for full course purchase
     */
    public function createCoursePayment(int $userId, Course $course): array
    {
        $orderId = 'COURSE-' . $course->id . '-' . $userId . '-' . time();

        $payment = Payment::create([
            'user_id' => $userId,
            'course_id' => $course->id,
            'module_id' => null,
            'amount' => $course->full_price,
            'currency' => 'LKR',
            'payment_gateway' => 'payhere',
            'transaction_id' => $orderId,
            'status' => 'pending',
            'payment_details' => [
                'order_id' => $orderId,
                'type' => 'full_course',
            ],
        ]);

        $hash = $this->generateHash([
            'order_id' => $orderId,
            'amount' => $course->full_price,
            'currency' => 'LKR',
        ]);

        return [
            'payment' => $payment,
            'merchant_id' => $this->merchantId,
            'return_url' => route('payment.return'),
            'cancel_url' => route('payment.cancel'),
            'notify_url' => route('payment.notify'),
            'order_id' => $orderId,
            'items' => $course->title,
            'currency' => 'LKR',
            'amount' => number_format($course->full_price, 2, '.', ''),
            'hash' => $hash,
        ];
    }

    /**
     * Create payment for module purchase
     */
    public function createModulePayment(int $userId, Module $module): array
    {
        $orderId = 'MODULE-' . $module->id . '-' . $userId . '-' . time();

        $payment = Payment::create([
            'user_id' => $userId,
            'course_id' => $module->course_id,
            'module_id' => $module->id,
            'amount' => $module->module_price,
            'currency' => 'LKR',
            'payment_gateway' => 'payhere',
            'transaction_id' => $orderId,
            'status' => 'pending',
            'payment_details' => [
                'order_id' => $orderId,
                'type' => 'module',
            ],
        ]);

        $hash = $this->generateHash([
            'order_id' => $orderId,
            'amount' => $module->module_price,
            'currency' => 'LKR',
        ]);

        return [
            'payment' => $payment,
            'merchant_id' => $this->merchantId,
            'return_url' => route('payment.return'),
            'cancel_url' => route('payment.cancel'),
            'notify_url' => route('payment.notify'),
            'order_id' => $orderId,
            'items' => $module->course->title . ' - ' . $module->title,
            'currency' => 'LKR',
            'amount' => number_format($module->module_price, 2, '.', ''),
            'hash' => $hash,
        ];
    }

    /**
     * Verify PayHere notification
     */
    public function verifyNotification(array $data): bool
    {
        $hashedSecret = strtoupper(md5($this->merchantSecret));

        $localHash = strtoupper(
            md5(
                $data['merchant_id'] .
                $data['order_id'] .
                $data['payhere_amount'] .
                $data['payhere_currency'] .
                $data['status_code'] .
                $hashedSecret
            )
        );

        return $localHash === $data['md5sig'];
    }

    /**
     * Handle successful payment
     */
    public function handleSuccessfulPayment(Payment $payment): void
    {
        $payment->update(['status' => 'completed']);

        $details = $payment->payment_details;

        if ($details['type'] === 'full_course') {
            // Create or update enrollment
            Enrollment::updateOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                ],
                [
                    'purchase_type' => 'full_course',
                    'status' => 'active',
                ]
            );

            // Unlock all modules
            $modules = Course::find($payment->course_id)->modules;
            foreach ($modules as $module) {
                ModuleUnlock::updateOrCreate(
                    [
                        'user_id' => $payment->user_id,
                        'module_id' => $module->id,
                    ],
                    [
                        'payment_id' => $payment->id,
                        'unlocked_at' => now(),
                    ]
                );
            }
        } elseif ($details['type'] === 'module') {
            // Create or update enrollment for module-wise purchase
            Enrollment::updateOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                ],
                [
                    'purchase_type' => 'module_wise',
                    'status' => 'active',
                ]
            );

            // Unlock specific module
            ModuleUnlock::updateOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'module_id' => $payment->module_id,
                ],
                [
                    'payment_id' => $payment->id,
                    'unlocked_at' => now(),
                ]
            );
        }
    }

    /**
     * Handle failed payment
     */
    public function handleFailedPayment(Payment $payment): void
    {
        $payment->update(['status' => 'failed']);
    }
}
