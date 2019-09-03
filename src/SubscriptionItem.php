<?php

namespace Synccentric\Cashier;

use Illuminate\Database\Eloquent\Model;

class SubscriptionItem extends Model
{
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function asStripeSubscriptionItem()
    {
        $stripeSubscription = $this->subscription->asStripeSubscription();
        // strips out the "subscription" parameter which causes an API error (unknown parameter)
        $stripeSubscription->items->url = substr($stripeSubscription->items->url, 0, strpos($stripeSubscription->items->url, '?'));

        return $stripeSubscription->items->retrieve($this->stripe_id);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function incrementQuantity($count = 1, $prorate = 1)
    {
        $this->updateQuantity($this->quantity + $count, $prorate);

        return $this;
    }

    public function decrementQuantity($count = 1, $prorate = true)
    {
        $this->updateQuantity(max(1, $this->quantity - $count), $prorate);

        return $this;
    }

    public function updateQuantity($quantity, $prorate = true)
    {
        $subscriptionItem = $this->asStripeSubscriptionItem();

        $subscriptionItem->quantity = $quantity;

        $subscriptionItem->prorate = $prorate;

        $subscriptionItem->save();

        $this->quantity = $quantity;

        $this->save();

        return $this;
    }
}
