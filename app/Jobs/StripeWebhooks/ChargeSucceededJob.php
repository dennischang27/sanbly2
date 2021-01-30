<?php

namespace App\Jobs\StripeWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Companies;
use App\Payment;

class ChargeSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
       $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        
       $charge = $this->webhookCall->payload['data']['object'];
        
       //Log::Debug(json_encode($charge));
        
         if(isset($charge['customer_email'])){
            $user = User::where('email',$charge['customer_email'])->first();
            $companies = Companies::where('user_id',$user->id)->first();

            $plan_expiration_date = '';
             switch($charge['lines']['data'][0]['plan']['interval']) {
                case 'month':
                    $plan_expiration_date = (new \DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
                    break;

                case 'year':
                    $plan_expiration_date = (new \DateTime())->modify('+12 months')->format('Y-m-d H:i:s');
                    break;
            }
             
             if(isset($user)){
                 Payment::create([
                    'name' =>$user->first_name . " " . $user->last_name,
                    'company_id' => $companies->id,
                    'user_id' =>$user->id,
                    'stripe_id'=>$charge['id'],
                    'product_description'=>$charge['description'],
                    'amount'=>$charge['amount_paid'],
                    'frequency'=>$charge['lines']['data'][0]['plan']['interval'],
                    'currency'=>$charge['currency'],
                    'country'=>$charge['account_country'],
                    'provider'=>'stripe'
                ]);

                User::where('id', $user->id)->update(array(
                    'plan_id' => $charge['lines']['data'][0]['plan']['id'],
                    'plan_expiration_date' => $plan_expiration_date
                ));
             }
             
         }

        
        
    }
}
