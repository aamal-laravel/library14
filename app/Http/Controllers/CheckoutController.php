<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(
        private CheckoutService $checkoutService
    ) {}

    public function store(CheckoutRequest $request)
    {
        $customer = auth()->user()->customer;

        $bill = $this->checkoutService->checkout(
            $customer->id,
            $request->books,
            $request->payment_method
        );

        return apiSuccess(
            'Checkout completed successfully',
            $bill,
            201
        );
    }
}