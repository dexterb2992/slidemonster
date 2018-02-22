<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
