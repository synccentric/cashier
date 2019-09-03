<?php

namespace Synccentric\Cashier\Exceptions;

use Synccentric\Cashier\Payment;

class PaymentFailure extends IncompletePayment
{
    /**
     * Create a new PaymentFailure instance.
     *
     * @param  \Synccentric\Cashier\Payment  $payment
     * @return self
     */
    public static function invalidPaymentMethod(Payment $payment)
    {
        return new self(
            $payment,
            'The payment attempt failed because of an invalid payment method.'
        );
    }
}
