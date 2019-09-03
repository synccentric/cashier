<?php

namespace Synccentric\Cashier\Http\Controllers;

use Synccentric\Cashier\Cashier;
use Synccentric\Cashier\Payment;
use Illuminate\Routing\Controller;
use Stripe\PaymentIntent as StripePaymentIntent;

class PaymentController extends Controller
{
    /**
     * Display the form to gather additional payment verification for the given payment.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('cashier::payment', [
            'stripeKey' => config('cashier.key'),
            'payment' => new Payment(
                StripePaymentIntent::retrieve($id, Cashier::stripeOptions())
            ),
            'redirect' => request('redirect'),
        ]);
    }
}
