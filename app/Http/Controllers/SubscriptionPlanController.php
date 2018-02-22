<?php

namespace App\Http\Controllers;

use App\SubscriptionPlan;
use App\Feature;
use App\Libraries\StripePlan;

use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{

    public function __construct()
    {
        $this->plans = new StripePlan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->plans->all();
    }

    /**
     * @param int $id
     */
    public function retrieve($id)
    {
        return $this->plans->get($id);
    }

    /**
     * @param string $plan_id
     */
    public function features($plan_id)
    {
        return Feature::where('plan_id', $plan_id)->get();
    }
}
