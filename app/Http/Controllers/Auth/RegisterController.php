<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Notifications\EmailVerification;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Log;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
    }


    protected function register( Request $request)
    {
        
        //Validate first
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email', 'max:255']
        ]);
        
       //Create the user
        $verification_code = Str::random(80);
        
        $owner = new User;
        $owner->first_name = strip_tags($request->first_name);
        $owner->last_name = strip_tags($request->last_name);
        $owner->email = strip_tags($request->email);
        $owner->phone = strip_tags($request->phone_owner)|"";
        $owner->password = "";
        $owner->active = 0;
        $owner->api_token = Str::random(80);
        $owner->verification_code = $verification_code;
        
        $owner->save();


        
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);
        
        //Send email to the owner
        $owner->notify(new EmailVerification($verification_code,$owner));

        return redirect()->route('company.register')->with(['email'=> $request->email, 'status'=> 'Thank you for submitting your information. Please check your email for verification.']);
    }

    // Register
    public function showRegistrationForm(){
      $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image blank-page', 'navbarType' => 'hidden'];  

     return view('/auth/register', [
         'pageConfigs' => $pageConfigs
     ]);
   }
    
    
   
    
    


}
