<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Payment;
use App\Services\PayHereService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $payHereService;

    public function __construct(PayHereService $payHereService)
    {
        $this->payHereService = $payHereService;
    }

    public function initiateCoursePayment(Course $course)
    {
        $paymentData = $this->payHereService->createCoursePayment(
            auth()->id(),
            $course
        );

        return view('frontend.payment.checkout', compact('paymentData', 'course'));
    }

    public function initiateModulePayment(Module $module)
    {
        $paymentData = $this->payHereService->createModulePayment(
            auth()->id(),
            $module
        );

        return view('frontend.payment.checkout', compact('paymentData', 'module'));
    }

    public function notify(Request $request)
    {
        $data = $request->all();

        // Verify notification
        if (!$this->payHereService->verifyNotification($data)) {
            return response('Invalid notification', 400);
        }

        // Find payment
        $payment = Payment::where('transaction_id', $data['order_id'])->first();

        if (!$payment) {
            return response('Payment not found', 404);
        }

        // Handle payment based on status
        if ($data['status_code'] == 2) { // Success
            $this->payHereService->handleSuccessfulPayment($payment);
        } else {
            $this->payHereService->handleFailedPayment($payment);
        }

        return response('OK', 200);
    }

    public function return(Request $request)
    {
        $orderId = $request->query('order_id');
        $payment = Payment::where('transaction_id', $orderId)->first();

        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found.');
        }

        // For sandbox mode, if payment status_code is 2, mark as completed and unlock
        if ($request->has('status_code') && $request->query('status_code') == 2) {
            if ($payment->status !== 'completed') {
                $this->payHereService->handleSuccessfulPayment($payment);
            }
            return redirect()->route('dashboard')
                ->with('success', 'Payment successful! You can now access your course.');
        }

        if ($payment->status === 'completed') {
            return redirect()->route('dashboard')
                ->with('success', 'Payment successful! You can now access your course.');
        }

        return redirect()->route('dashboard')
            ->with('info', 'Payment is being processed. You will be notified once confirmed.');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('courses.index')
            ->with('warning', 'Payment was cancelled.');
    }
}
