<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategories;
use App\Companies;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$user = User::where('id', '=', auth()->user()->id)->first();
				$company = Companies::where('user_id', '=', auth()->user()->id)->first();
				return view('account-settings.index')->with(compact('user','company'));
			}else{ 
				return redirect()->route('account-settings.index')->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGeneral(Request $request)
    {
		$request->validate([
			'first_name'  => 'required',
			'last_name'  => 'required',
			'email'  => 'required'
        ]);
		
		$id = $request->id;
		$user = User::where(['id' => $id])->first();
		$user->first_name = strip_tags($request->first_name);
		$user->last_name = strip_tags($request->last_name);
		$user->email = strip_tags($request->email);
		$user->save();
		
		$company = Companies::where(['user_id' => $id])->first();
		$company->name = strip_tags($request->company);
		$company->save();
		
        return redirect()->route('account-settings.index')->with( [ 'tab' => 'general' ] )->withStatus(__('General successfully updated!'));
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {	
		$request->validate([
			'old_password'  => 'required',
			'new_password'  => 'required',
			'retype_password'  => 'required'
        ]);
		
		$id = $request->id;
		$user = User::where(['id' => $id])->first();
		
		if( ! Hash::check($request->old_password,$user->password) ){
			return redirect()->route( 'account-settings.index' )->with( [ 'tab' => 'password', 'message' => 'Your old password is incorrect.' ] );
		}
		
		$user->password = Hash::make($request->new_password);
		$user->save();
		
		return redirect()->route('account-settings.index')->with( [ 'tab' => 'password' ] )->withStatus(__('Password successfully updated!'));
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
		$request->validate([
			'dob'  => 'required',
			'phone'  => 'required'
        ]);
		
		/*echo $request->dob."<br/>";
		echo $request->country."<br/>";
		echo $request->currency."<br/>";
		print_r($request->languages);
		echo $request->phone."<br/>";
		echo $request->website."<br/>";*/
		
		$languages = "";
		$numItems = count($request->languages);
		$i = 0;
		
		foreach ($request->languages as $value) {
			if(++$i === $numItems) {
				$languages .= $value;
		    } else {
			    $languages .= $value."/";
		    }
		}
		
		$id = $request->id;
		$user = User::where(['id' => $id])->first();
		$user->dob = strip_tags($request->dob);
		$user->country = strip_tags($request->country);
		$user->currency = strip_tags($request->currency);
		$user->languages = $languages;
		$user->phone = strip_tags($request->phone);
		$user->save();
		
		$company = Companies::where(['user_id' => $id])->first();
		$company->website = strip_tags($request->website);
		$company->save();
		
        return redirect()->route('account-settings.index')->with( [ 'tab' => 'info' ] )->withStatus(__('Info successfully updated!'));
    }

}
