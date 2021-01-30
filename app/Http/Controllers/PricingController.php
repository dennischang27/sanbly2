<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Payment;
use DB;
use Stripe;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::where('id', auth()->user()->id)->where(['active' => 1])->first();

        $date_now = date("Y-m-d");

        if(!empty($user->plan_expiration_date)){
            $user_expiration_date = $user->plan_expiration_date;
            $date_expiration_string = strtotime($user_expiration_date);
            $user_plan_expiration = date("Y-m-d", $date_expiration_string);
            
            if($user_plan_expiration > $date_now){
                $payment = Payment::where('user_id', auth()->user()->id)->latest('created_at')->first();
 
                $frequency = $payment->frequency;
                
                return view('pricing.index',['is_paid' => true,'frequency' => $frequency]); 
            } else {
               return view('pricing.index'); 
            } 
        } else {
           return view('pricing.index'); 
        }
        
		
    }
    
    public function payment(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $stripe_session = $stripe->checkout->sessions->create([
          'success_url' => url('/pricing?return_type=success'),
          'cancel_url' => url('/pricing?return_type=cancel'),
          'payment_method_types' => ['card'],
          'customer_email' => auth()->user()->email,
          'line_items' => [
            [
              'price' => $request->pricing_id,
               'quantity' => 1,
            ],
         
          ],
         
          'mode' => 'subscription',
        ]);
        
         return view('pricing.payment', ['stripe_s' => $stripe_session['id']]);
       
    }
    
       
}
