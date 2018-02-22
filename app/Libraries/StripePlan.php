<?php

namespace App\Libraries;

use App\User;
use Cache;
use Stripe\Stripe;
use Stripe\Plan;

class StripePlan
{

    public function __construct()
    {
        Stripe::setApiKey(User::getStripeKey());
    }

    public function all()
    {
        try {
            return Cache::remember('stripe.plans', 60*24, function () {
                return Plan::all();
            });
        } catch (\Exception $e) {
            return [];
        }

        // return Plan::all();
    }

    public function get($id)
    {
        $plan = Plan::retrieve($id);
        return $plan;
    }
}
