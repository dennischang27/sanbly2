<?php

namespace App\Http\Controllers;

use App\User;
use App\Companies;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\RestaurantCreated;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{

    public function showCompleteRegister()
    {
        $pageConfigs = ['navbarType' => 'hidden'];  

        if(session('email')){
            return view('auth.verify', [
             'pageConfigs' => $pageConfigs, 'email' =>session('email')
            ]);
        } else {
             return redirect('/');
        }
    }
    
    public function resendEmail(Request $request)
    {
        $pageConfigs = ['navbarType' => 'hidden'];  
   
        $owner = User::where('email', $request->email)->where(['active' => 0])->first();
        
        if($owner){
            $owner->notify(new EmailVerification($owner->verification_code,$owner));
            
            return view('auth.verify', [
             'pageConfigs' => $pageConfigs, 'email' =>$request->email
            ]);
        } else {
             return redirect('/');
        }

    }

    public function activateCompany(Request $request)
    {
        //Validate first
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password'  => 'min:6|required_with:retype_password|same:retype_password',
			'retype_password'  => 'min:6'
        ]);


        if(request()->has('code')){
            //User not active and new website 
            $user = User::where('verification_code', request()->code)->where(['active' => 0])->first();
            
            if(isset($user)){
                //Activate the website
                $user->active = 1;
                $user->password = Hash::make($request->password);
                $user->update();
                
                //Assign role
                $user->assignRole('owner');
   
                //Create Web 
                $web = new Companies;
                $web->name = strip_tags($request->name);
                $web->user_id = $user->id;
                $web->address = "";
                $web->phone = "";
                $web->active = 1;
                $web->logo = "";
                $web->save();
                return redirect('/')->with(['status'=> 'Account successfully activated.']);
            } else {
                return redirect('/')->with(['status'=> 'Account has been activated.']);
            }

        } else {
            return redirect('/');
        }
       
    }
    
    public function verifyEmail(Request $request){
        
        if(request()->has('code')){
            
            //User not active and new website 
            $user = User::where('verification_code', request()->code)->where(['active' => 0])->first();
            
            if(isset($user)){
                
                $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image blank-page', 'navbarType' => 'hidden'];  
                
                return view('company.register',['user_name' => $user->name, 'code'=> request()->code, 'pageConfigs' => $pageConfigs]);
            } else {
                return redirect('/')->with(['status'=> 'This account has been activated. Please try to login.']);
            }

            
        } else {
            return redirect('/');
        }
    }
}
