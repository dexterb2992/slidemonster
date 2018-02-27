<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Libraries\StripePlan;

class UserController extends Controller
{
    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255'
        ];
    }

    public function index()
    {
        $user = auth()->guard('api')->user()->only('name', 'email', 'license_key');
        // check for current subscription:

        return ['form' => $user];
    }

    public function show(User $user)
    {
        if (auth('api')->user()->id == $user->id) {
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

            return [
                'success' => 1,
                'message' => "You have successfully subscribed to ".$plan['name']." membership. Your trial ends in "
                                .$plan['trial_period_days']." days"
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

    public function cancelSubscription()
    {
        //
    }
}
