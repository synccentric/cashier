<?php

namespace Synccentric\Cashier;

use Synccentric\Cashier\Exceptions\PaymentFailure;
use Stripe\PaymentIntent as StripePaymentIntent;
use Synccentric\Cashier\Exceptions\PaymentActionRequired;

class Payment
{
    /**
     * The Stripe PaymentIntent instance.
     *
     * @var \Stripe\PaymentIntent
     */
    protected $paymentIntent;

    /**
     * Create a new Payment instance.
     *
     * @param  \Stripe\PaymentIntent  $paymentIntent
     * @return void
     */
    public function __construct(StripePaymentIntent $paymentIntent)
    {
        $this->paymentIntent = $paymentIntent;
    }

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount()
    {
        return Cashier::formatAmount($this->rawAmount(), $this->paymentIntent->currency);
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount()
    {
        return $this->paymentIntent->amount;
    }

    /**
     * The Stripe PaymentIntent client secret.
     *
     * @return string
     */
    public function clientSecret()
    {
        return $this->paymentIntent->client_secret;
    }

    /**
     * Determine if the payment needs a valid payment method.
     *
     * @return bool
     */
    public function requiresPaymentMethod()
    {
        return $this->paymentIntent->status === 'requires_payment_method';
    }

    /**
     * Determine if the payment needs an extra action like 3D Secure.
     *
     * @return bool
     */
    public function requiresAction()
    {
        return $this->paymentIntent->status === 'requires_action';
    }

    /**
     * Determine if the payment was cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->paymentIntent->status === 'canceled';
    }

    /**
     * Determine if the payment was successful.
     *
     * @return bool
     */
    public function isSucceeded()
    {
        return $this->paymentIntent->status === 'succeeded';
    }

    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \Synccentric\Cashier\Exceptions\PaymentActionRequired
     * @throws \Synccentric\Cashier\Exceptions\PaymentFailure
     */
    public function validate()
    {
        if ($this->requiresPaymentMethod()) {
            throw PaymentFailure::invalidPaymentMethod($this);
        } elseif ($this->requiresAction()) {
            throw PaymentActionRequired::incomplete($this);
        }
    }

    /**
     * The Stripe PaymentIntent instance.
     *
     * @return \Stripe\PaymentIntent
     */
    public function asStripePaymentIntent()
    {
        return $this->paymentIntent;
    }

    /**
     * Dynamically get values from the Stripe PaymentIntent.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->paymentIntent->{$key};
    }
}
