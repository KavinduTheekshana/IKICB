<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Payment;
use App\Services\WebxpayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $webxpayService;

    public function __construct(WebxpayService $webxpayService)
    {
        $this->webxpayService = $webxpayService;
    }

    public function initiateCoursePayment(Course $course)
    {
        // WebXPay requires minimum 1.00 LKR
        if ($course->full_price < 1) {
            return back()->with('error', 'Payment amount must be at least LKR 1.00');
        }

        $orderId = time() . $course->id . auth()->id();

        $paymentData = [
            'order_id'  => $orderId,
            'items'     => $course->title,
            'currency'  => 'LKR',
            'amount'    => number_format($course->full_price, 2, '.', ''),
            'course_id' => $course->id,
            'module_id' => null,
            'type'      => 'course',
        ];

        return view('frontend.payment.checkout', compact('paymentData', 'course'));
    }

    public function initiateModulePayment(Module $module)
    {
        // WebXPay requires minimum 1.00 LKR
        if ($module->module_price < 1) {
            return back()->with('error', 'Payment amount must be at least LKR 1.00');
        }

        $orderId = time() . $module->id . auth()->id();

        $paymentData = [
            'order_id'  => $orderId,
            'items'     => $module->course->title . ' - ' . $module->title,
            'currency'  => 'LKR',
            'amount'    => number_format($module->module_price, 2, '.', ''),
            'course_id' => $module->course_id,
            'module_id' => $module->id,
            'type'      => 'module',
        ];

        return view('frontend.payment.checkout', compact('paymentData', 'module'));
    }

    public function processWebxpayPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id'  => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'type'      => 'required|in:course,module',
            'amount'    => 'required|numeric|min:1',
        ]);

        try {
            Payment::create([
                'user_id'         => auth()->id(),
                'course_id'       => $validated['course_id'],
                'module_id'       => $validated['module_id'],
                'amount'          => $validated['amount'],
                'currency'        => 'LKR',
                'payment_gateway' => 'webxpay',
                'payment_method'  => 'webxpay',
                'transaction_id'  => $validated['order_id'],
                'status'          => 'initiated',
                'payment_details' => [
                    'order_id' => $validated['order_id'],
                    'type'     => $validated['type'] === 'course' ? 'full_course' : 'module',
                ],
            ]);

            $user = auth()->user();
            $nameParts = explode(' ', $user->name, 2);

            // Use test amount in sandbox mode to avoid transaction limit errors
            $paymentAmount = config('services.webxpay.sandbox')
                ? 100.00  // LKR 100 for sandbox testing
                : $validated['amount'];  // Real amount for production

            $webxpayData = [
                'payment_url'      => $this->webxpayService->getPaymentUrl(),
                'secret_key'       => config('services.webxpay.secret_key'),
                'payment'          => $this->webxpayService->generatePaymentField(
                    $validated['order_id'],
                    $paymentAmount
                ),
                'custom_fields'    => $this->webxpayService->generateCustomFields([
                    $validated['course_id'] ?? '',
                    $validated['module_id'] ?? '',
                    $validated['type'] === 'course' ? 'full_course' : 'module',
                ]),
                'first_name'       => $nameParts[0] ?? 'User',
                'last_name'        => $nameParts[1] ?? '',
                'email'            => $user->email,
                'contact_number'   => $user->phone ?? '0773606370',
                'address_line_one' => $user->address ?? '46/46, Green Lanka Building',
                'address_line_two' => 'Nawam Mawatha',
                'city'             => 'Colombo',
                'state'            => 'Western',
                'postal_code'      => '10300',
                'country'          => 'Sri Lanka',
                'process_currency' => 'LKR',
                'cms'              => 'PHP',
                'return_url'       => route('payment.webxpay.return'),
                'notify_url'       => route('payment.webxpay.return'),
            ];

            return view('frontend.payment.webxpay-redirect', compact('webxpayData'));
        } catch (\Exception $e) {
            \Log::error('WebXPay payment processing failed', [
                'error' => $e->getMessage(),
                'order_id' => $validated['order_id'],
                'user_id' => auth()->id(),
            ]);

            return back()->with('error', 'Payment processing failed: ' . $e->getMessage() . '. Please check your WebXPay configuration or contact support.');
        }
    }

    /**
     * WEBXPAY POSTs the payment result back to this route (configured in WEBXPAY dashboard).
     * No auth middleware — WEBXPAY sends this as a browser redirect POST.
     */
    public function webxpayReturn(Request $request)
    {
        \Log::info('WEBXPAY: Return callback received', [
            'has_payment' => $request->has('payment'),
            'has_signature' => $request->has('signature'),
            'is_authenticated' => auth()->check(),
            'session_id' => session()->getId(),
            'all_input_keys' => array_keys($request->all()),
            'payment_preview' => $request->has('payment') ? substr($request->input('payment'), 0, 100) . '...' : null,
        ]);

        if (!$request->has('payment')) {
            \Log::error('WEBXPAY: No payment field in request', [
                'all_input' => $request->all(),
            ]);
            return $this->redirectAfterPayment('error', 'Invalid payment response received.');
        }

        $decrypted = $this->webxpayService->decryptPayment($request->input('payment'));

        if (!$decrypted) {
            return $this->redirectAfterPayment('error', 'Payment response could not be decrypted.');
        }

        // Verify authenticity via signature if WEBXPAY provides it
        if ($request->has('signature')) {
            if (!$this->webxpayService->verifySignature($request->input('signature'), $decrypted['raw'])) {
                return $this->redirectAfterPayment('error', 'Payment signature verification failed.');
            }
        }

        $payment = Payment::where('transaction_id', $decrypted['order_id'])->first();

        if (!$payment) {
            return $this->redirectAfterPayment(null, 'error', 'Payment record not found.');
        }

        // Re-authenticate the user if session was lost during payment gateway redirect
        if (!auth()->check() && $payment->user_id) {
            \Log::info('WEBXPAY: Re-authenticating user after payment redirect', [
                'user_id' => $payment->user_id,
                'order_id' => $decrypted['order_id'],
            ]);
            auth()->loginUsingId($payment->user_id);
        }

        \Log::info('WEBXPAY: Checking payment status', [
            'order_id' => $decrypted['order_id'],
            'status_code' => $decrypted['status_code'],
            'reference' => $decrypted['reference'] ?? null,
            'gateway' => $decrypted['gateway'] ?? null,
            'comment' => $decrypted['comment'] ?? null,
            'sandbox_mode' => config('services.webxpay.sandbox'),
            'full_response' => $decrypted,
        ]);

        // Save the WebXPay reference number and response details to the payment record
        $payment->update([
            'reference_number' => $decrypted['reference'] ?? null,
            'payment_details'  => array_merge($payment->payment_details ?? [], [
                'webxpay_reference' => $decrypted['reference'] ?? null,
                'webxpay_datetime'  => $decrypted['datetime'] ?? null,
                'webxpay_gateway'   => $decrypted['gateway'] ?? null,
                'webxpay_status'    => $decrypted['status_code'] ?? null,
                'webxpay_comment'   => $decrypted['comment'] ?? null,
            ]),
        ]);

        if ($this->webxpayService->isSuccessful($decrypted['status_code'])) {
            $this->webxpayService->handleSuccessfulPayment($payment);

            \Log::info('WEBXPAY: Payment successful', [
                'order_id' => $decrypted['order_id'],
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'status_code' => $decrypted['status_code'],
            ]);

            return $this->redirectAfterPayment($payment->user, 'success', 'Payment successful! You can now access your course.');
        }

        $this->webxpayService->handleFailedPayment($payment);

        \Log::warning('WEBXPAY: Payment failed or not recognized', [
            'order_id' => $decrypted['order_id'],
            'status_code' => $decrypted['status_code'],
            'reference' => $decrypted['reference'] ?? null,
            'comment' => $decrypted['comment'] ?? null,
            'full_response' => $decrypted,
        ]);

        return $this->redirectAfterPayment($payment->user, 'error', 'Payment was not successful. Please try again or use bank transfer.');
    }

    /**
     * Redirect after payment with proper session handling
     */
    protected function redirectAfterPayment($user, string $type, string $message)
    {
        // If user object is provided and not currently authenticated, log them in
        if ($user && !auth()->check()) {
            auth()->login($user);
            \Log::info('WEBXPAY: User logged in after payment', [
                'user_id' => $user->id,
            ]);
        }

        // Always redirect to dashboard (user is now authenticated)
        return redirect()->route('dashboard')->with($type, $message);
    }

    public function cancel(Request $request)
    {
        return redirect()->route('courses.index')
            ->with('warning', 'Payment was cancelled.');
    }

    public function submitBankTransfer(Request $request)
    {
        $validated = $request->validate([
            'course_id'        => 'nullable|exists:courses,id',
            'module_id'        => 'nullable|exists:modules,id',
            'amount'           => 'required|numeric|min:0',
            'reference_number' => 'required|string|max:255|unique:payments,reference_number',
            'receipt'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes'            => 'nullable|string|max:1000',
        ]);

        if (!$request->course_id && !$request->module_id) {
            return back()->with('error', 'Please select a course or module.');
        }

        try {
            $receiptPath = $request->file('receipt')->store('bank-receipts', 'public');

            Payment::create([
                'user_id'          => auth()->id(),
                'course_id'        => $request->course_id,
                'module_id'        => $request->module_id,
                'amount'           => $validated['amount'],
                'currency'         => 'LKR',
                'payment_gateway'  => 'bank_transfer',
                'payment_method'   => 'bank_transfer',
                'transaction_id'   => 'BANK-' . $validated['reference_number'],
                'reference_number' => $validated['reference_number'],
                'receipt_path'     => $receiptPath,
                'status'           => 'pending',
                'payment_details'  => json_encode([
                    'notes'        => $request->notes,
                    'submitted_at' => now()->toDateTimeString(),
                ]),
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Bank transfer payment submitted successfully! Your payment will be verified by our admin team within 24 hours.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit bank transfer. Please try again.');
        }
    }
}
