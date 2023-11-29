<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SubscriptionAPIRequest;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StripeAPIController extends Controller
{

//    public function getToken()
//    {
//
//        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
//
//        $token = $stripe->tokens->create([
//            'card' => [
//                'number' => '4242424242424242',
//                'exp_month' => 9,
//                'exp_year' => 2022,
//                'cvc' => '314',
//            ],
//        ]);
//        return response()->json(['status' => 200, 'response' =>  $token->id]);
//    }

    public function subscription(SubscriptionAPIRequest $request){

        try {
            $stripe =   \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripes = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $payment = $stripes->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->get('card_number'),
                    'exp_month' => $request->get('expire_month'),
                    'exp_year' => $request->get('expire_year'),
                    'cvc' => $request->get('cvc'),
                ],
            ]);

            $user = (Auth::user()) ? Auth::user() : new User();

            $planId = $request->input('plan_id');
            $user->createOrGetStripeCustomer();
            $user->addPaymentMethod($payment->id);
            $subscription = $user->newSubscription('default', $planId)->create($payment->id, [
                'email' => $user->email,
                'description' => 'Testing Pure',
            ]);
            return $subscription;

        } catch (\Exception $e){
                return response()->json(['status' => 400, 'response' =>  $e->getMessage()]);
        }

    }
}
