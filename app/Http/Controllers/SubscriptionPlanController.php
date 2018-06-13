<?php

namespace App\Http\Controllers;

use App\SubscriptionPlan;
use App\Feature;
use App\Libraries\StripePlan;

use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{

    public static $rules = [
        'name' => 'required',
        'stripe_plan' => 'required',
        'price_per_unit' => 'required|numeric'
    ];

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
        // return $this->plans->all();
        return SubscriptionPlan::all();
    }

    /**
     * @param int $id
     */
    public function retrieve($id)
    {
        // return $this->plans->get($id);
        return $this->show($id);
    }

    /**
     * @param string $plan_id
     */
    public function features($plan_id)
    {
        return Feature::where('plan_id', $plan_id)->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, self::$rules);

        $plan = new SubscriptionPlan;
        $plan->name = $request->name;
        $plan->stripe_plan = $request->stripe_plan;
        $plan->interval = $request->interval;
        $plan->unit = $request->unit;
        $plan->unit_text = $request->unit_text;
        $plan->billing_interval = $request->billing_interval;
        $plan->trial_days = $request->trial_days;
        $plan->price_per_unit = $request->price_per_unit;

        if ($plan->save()) {
            return [
                'success' => 1,
                'id' => $plan->id,
                'message' => "New subscription plan successfully saved."
            ];
        }

        return [
            'success' => 0,
            'message' => "Unable to create a new subscription plan this time. Please try again later."
        ];
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return $subscriptionPlan;
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $this->validate($request, self::$rules);
        
        $subscriptionPlan->name = $request->name;
        $subscriptionPlan->stripe_plan = $request->stripe_plan;
        $subscriptionPlan->interval = $request->interval;
        $subscriptionPlan->unit = $request->unit;
        $subscriptionPlan->unit_text = $request->unit_text;
        $subscriptionPlan->billing_interval = $request->billing_interval;
        $subscriptionPlan->trial_days = $request->trial_days;
        $subscriptionPlan->price_per_unit = $request->price_per_unit;

        if ($subscriptionPlan->save()) {
            return [
                'success' => 1,
                'message' => "Changes successfully saved."
            ];
        }

        return [
            'success' => 0,
            'message' => "Unable to update a subscription plan this time. Please try again later."
        ];
    }

    /**
     * Delete from resource
     * 
     * @param App\SubscriptionPlan $subscriptionPlan
     * @return array
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        if ($subscriptionPlan->delete()) {
            return [
                'success' => 1,
                'message' => "Plan successfully deleted."
            ];
        }

        return [
            'success' => 0,
            'message' => "Unable to delete a subscription plan this time. Please try again later."
        ];
    }
}
