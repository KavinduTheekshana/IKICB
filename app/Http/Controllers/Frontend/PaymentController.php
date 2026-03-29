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
            'amount'    => 'required|numeric',
        ]);

        Payment::create([
            'user_id'         => auth()->id(),
            'course_id'       => $validated['course_id'],
            'module_id'       => $validated['module_id'],
            'amount'          => $validated['amount'],
            'currency'        => 'LKR',
            'payment_gateway' => 'webxpay',
            'payment_method'  => 'webxpay',
            'transaction_id'  => $validated['order_id'],
            'status'          => 'pending',
            'payment_details' => [
                'order_id' => $validated['order_id'],
                'type'     => $validated['type'] === 'course' ? 'full_course' : 'module',
            ],
        ]);

        $user = auth()->user();
        $nameParts = explode(' ', $user->name, 2);

        $webxpayData = [
            'payment_url'      => $this->webxpayService->getPaymentUrl(),
            'secret_key'       => config('services.webxpay.secret_key'),
            'payment'          => $this->webxpayService->generatePaymentField(
                $validated['order_id'],
                (float) $validated['amount']
            ),
            'custom_fields'    => $this->webxpayService->generateCustomFields([
                $validated['course_id'] ?? '',
                $validated['module_id'] ?? '',
                $validated['type'] === 'course' ? 'full_course' : 'module',
            ]),
            'first_name'       => $nameParts[0] ?? 'User',
            'last_name'        => $nameParts[1] ?? '',
            'email'            => $user->email,
            'contact_number'   => $user->phone ?? '0000000000',
            'address_line_one' => $user->address ?? 'N/A',
            'process_currency' => 'LKR',
            'cms'              => config('services.webxpay.cms', 'custom'),
        ];

        return view('frontend.payment.webxpay-redirect', compact('webxpayData'));
    }

    /**
     * WEBXPAY POSTs the payment result back to this route (configured in WEBXPAY dashboard).
     * No auth middleware — WEBXPAY sends this as a browser redirect POST.
     */
    public function webxpayReturn(Request $request)
    {
        if (!$request->has('payment')) {
            return redirect()->route('dashboard')
                ->with('error', 'Invalid payment response received.');
        }

        $decrypted = $this->webxpayService->decryptPayment($request->input('payment'));

        if (!$decrypted) {
            return redirect()->route('dashboard')
                ->with('error', 'Payment response could not be decrypted.');
        }

        // Verify authenticity via signature if WEBXPAY provides it
        if ($request->has('signature')) {
            if (!$this->webxpayService->verifySignature($request->input('signature'), $decrypted['raw'])) {
                return redirect()->route('dashboard')
                    ->with('error', 'Payment signature verification failed.');
            }
        }

        $payment = Payment::where('transaction_id', $decrypted['order_id'])->first();

        if (!$payment) {
            return redirect()->route('dashboard')
                ->with('error', 'Payment record not found.');
        }

        if ($this->webxpayService->isSuccessful($decrypted['status_code'])) {
            $this->webxpayService->handleSuccessfulPayment($payment);

            return redirect()->route('dashboard')
                ->with('success', 'Payment successful! You can now access your course.');
        }

        $this->webxpayService->handleFailedPayment($payment);

        return redirect()->route('dashboard')
            ->with('error', 'Payment was not successful. Please try again or use bank transfer.');
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
