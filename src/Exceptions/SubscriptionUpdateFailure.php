<?php

namespace Synccentric\Cashier\Exceptions;

use Exception;
use Synccentric\Cashier\Subscription;

class SubscriptionUpdateFailure extends Exception
{
    /**
     * Create a new SubscriptionUpdateFailure instance.
     *
     * @param  \Synccentric\Cashier\Subscription  $subscription
     * @param  string  $plan
     * @return self
     */
    public static function incompleteSubscription(Subscription $subscription)
    {
        return new static("The subscription \"{$subscription->stripe_id}\" cannot be updated because its payment is incomplete.");
    }
}
