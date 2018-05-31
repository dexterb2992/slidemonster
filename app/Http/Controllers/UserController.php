<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Libraries\StripePlan;

use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255'
        ];
    }

    protected function getPerms($user)
    {
        $subscription = $user->subscriptions->first();
        if (!empty($subscription) && $subscription->valid()) {
            return [
                ['id' => 'adcontent', 'value' => 'Ad/Content'],
                ['id' => 'cta_btn', 'value' => 'Call to action button'],
                ['id' => 'optin', 'value' => 'Opt-in'],
                ['id' => 'social', 'value' => 'Social'],
                ['id' => 'timer', 'value' => 'Timer'],
            ];
        }

        return [
            ['id' => 'adcontent', 'value' => 'Ad/Content'],
            ['id' => 'cta_btn', 'value' => 'Call to action button'],
            ['id' => 'timer', 'value' => 'Timer']
        ];
    }

    public function index()
    {
        // $data = auth()->guard('api')->user()->only('name', 'email', 'license_key', 'subscriptions');
        // $user = auth('api')->user();
        $user = auth()->user();

        // for now, we only support single subscription, so let's get the latest one
        $subscription = $user->subscriptions->first();

        $data = $user->toArray();

        $subscription_status = false;

        if (!empty($subscription)) {
            $subscription_status = $subscription->valid();

            $data['subscription_on_grace_period'] = $subscription->cancelled() && $subscription->onGracePeriod();
            $data['subscription_ends_at'] = Carbon::parse($subscription->ends_at)->toDayDateTimeString();
        }

        $data['subscriptions'] = $subscription_status ? array_wrap($subscription) : [];

        $data['perms'] = $this->getPerms($user);

        

        // check for current subscription:
        return ['form' => $data];
    }

    public function show(User $user)
    {
        if (auth('api')->user()->id == $user->id) {
            $user->perms = $this->getPerms($user);
            return $user;
        }

        return response(404);
    }

    public function get()
    {
        if (auth('api')->user()->role == 1) {
            $users = User::paginate(10);

            foreach ($users as $key => $user) {
                $user->subscription_status = $user->subscribed('main');
            }

            // return User::paginate(10)->toArray();
            return $users->toArray();
        }

        return response(404);
    }


    public function update(Request $request)
    {
        if ($request->has('password') && trim($request->password) != "") {
            $this->rules['password'] = 'required|string|min:6|confirmed';
        }

        $var = $this->validate($request, $this->rules);
        
        $user = auth()->guard('api')->user();
        $user->name = $request->name;

        if (!empty($request->license_key)) {
            if (!validateLicense($request->license_key, $user->email)) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'license_key' => ['Invalid license']
                    ]
                ], 422);
            }
        }

        $user->license_key = $request->license_key;
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            return [
                'success' => 1,
                'message' => 'Profile has been updated successfully.'
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to update profile information. Please try again later."
        ];
    }

    /**
     * Updates an existing user
     *
     * @return array
     */
    public function updateUser(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return [
                'message' => "Access denied.",
                'success' => 0
            ];
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->save()) {
            return [
                'message' => "User updated successfully.",
                'success' => 1
            ];
        }

        return [
            'message' => "Sorry, we are unable to update a user this time. Please try again later.",
            'success' => 0
        ];
    }

    public function updatePaymentMethod(Request $request)
    {
        $user = auth('api')->user();
        $user->stripe_id = "";
        $user->card_brand = "";
        $user->last_four = "";
        $user->trial_ends_at = "";
    }

    public function hasPreviousSubscription($user, $plans)
    {
        foreach ($plans as $value) {
            if ($user->subscribed($value['id'])) {
                return $value;
            }
        }

        return false;
    }

    public function checkCoupon(Request $request)
    {
        try {
            $coupon = $request->coupon;
            $stripe = new StripePlan;
            $response = $stripe->getCoupon($coupon);

            return response()->json([
                'success' => 1,
                'coupon' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'No such coupon.'], 200);
        }
    }

    public function subscribe(Request $request)
    {
        $user = $request->user();
        $input = $request->all();

        $stripeToken = $input['token']['id'];
        $card = $input['token']['card'];
        $plan_id = $input['plan_id'];

        $stripe = new StripePlan;
        $plans = $stripe->all();

        $plan = null;
        // dd($plans->data);
        \Log::info($plans);

        // let's get the price now
        foreach ($plans->data as $key => $value) {
            if ($value['id'] == $plan_id) {
                $plan = $value;
            }
        }

        // let's check if user has a previous subscription
        $previous = $this->hasPreviousSubscription($user, $plans->data);

        if ($previous == false) {
            // create a new subscription
           

            try {
                if ($request->coupon != "") {
                    $user->newSubscription($plan['id'], $plan['id'])
                        ->withCoupon($request->coupon)
                        ->create($stripeToken, [
                            'email' => $user->email
                        ]);
                } else {
                    $user->newSubscription($plan['id'], $plan['id'])
                        ->create($stripeToken, [
                            'email' => $user->email
                        ]);
                }
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), "No such customer") !== false) {
                    dump("No such a fucking customer retard!");
                    $user->stripe_id = "";
                    $user->save();
                    $this->subscribe($request);
                } else {
                    dump("There's an error but we can't find a 'no such customer' phrase");
                }
            }

            $hasTrial = !empty($plan['trial_period_days']) ? "Your trial ends in ".$plan['trial_period_days']." days" : "";

            return [
                'success' => 1,
                'message' => "You have successfully subscribed to ".$plan['name']." membership. ".$hasTrial
            ];
        } else {
            // this user has already subscribed
            \Log::info("this user has already subscribed");
            \Log::info("susbscribed to: ".json_encode($previous));
            return [
                'success' => 0,
                'message' => "You have already subscribed to this plan."
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong, please try again later."
        ];
    }

    public function cancelSubscription(Request $request)
    {
        $user = $request->user();
        $plan = $request->plan_id;
        
        try {
            if ($user->subscription($plan)->onTrial()) {
                $user->subscription($plan)->cancelNow();
            } else {
                $user->subscription($plan)->cancel();
            }
        } catch (\Exception $e) {
            return [
                'success' => 0,
                'message' => "Something went wrong while trying cancel your subscription. Please try again later."
            ];
        }

        $ends_at = Carbon::parse($user->subscription($plan)->ends_at)->toDayDateTimeString();

        return [
            'success' => 1,
            'message' => "You successfully cancelled your subscription. Your subscription will end in $ends_at"
        ];
    }

    public function resumeSubscription(Request $request)
    {
        $user = $request->user();
        $plan = $request->plan_id;
        
        try {
            $user->subscription($plan)->resume();
        } catch (\Exception $e) {
            return [
                'success' => 0,
                'message' => "Something went wrong while trying resume your subscription. Please try again later."
            ];
        }

        $ends_at = Carbon::parse($user->subscription($plan)->ends_at)->toDayDateTimeString();

        return [
            'success' => 1,
            'message' => "You successfully resumed your subscription to $plan"
        ];
    }

    /**
     * Deletes the user
     *
     * @return array
     */
    public function destroy(User $user)
    {
        if ($user->subscribed('main')) {
            return [
                'message' => "You can't delete a user with an active subscription.",
                "success" => 0
            ];
        }

        if ($user->id == auth()->user()->id) {
            return [
                'message' => "You can't delete yourself.",
                "success" => 0
            ];
        }
        
        $name = $user->name;

        if ($user->delete()) {
            return [
                "message" => "$name has been successfully deleted.",
                "success" => 1
            ];
        }

        return [
            "message" => "Something went wrong, we are unable to delete a user this time. Please try again later.",
            "success" => 0
        ];
    }
}
