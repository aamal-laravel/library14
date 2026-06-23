<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request): JsonResponse
    {
        $payment = Payment::create([
            'bill_id' => $request->bill_id,
            'amount' => $request->amount,
            'method' => $request->method,
            'type' => $request->type,
            'status' => 'complete',
            'paid_at' => now(),
        ]);

        return apiSuccess(
            'Payment completed successfully',
            $payment
        );
    }

    public function show(Payment $payment): JsonResponse
    {
        return apiSuccess(
            'Payment details',
            $payment
        );
    }
}