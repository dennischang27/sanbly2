<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Billings;
use App\Web;
use DB;

class BillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Billings $billings)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$billings = Billings::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('billings.index', ['billings' => $billings]);
			}else{ 
				return redirect()->route('billings.index')->withStatus(__('No Access'));
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
    public function update($id, Request $request, Billings $billings)
    {
		$billings =  Billings::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
		$email = $billings->user->email;
		
		$invoice_id = $billings->id;
		$digit = strlen($invoice_id);
		
		if($digit == 1){
			$invoice_id = "100".$invoice_id;
		} elseif($digit == 2) {
			$invoice_id = "10".$invoice_id;
		} elseif($digit == 3) {
			$invoice_id = "1".$invoice_id;
		}
		
		$billings->id = $invoice_id;
		
		return view('billings.invoice', ['billings' => $billings, 'email' => $email]);
    }
}
