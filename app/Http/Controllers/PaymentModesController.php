<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentModes;

class PaymentModesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentModes $payment_modes)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$payment_modes = PaymentModes::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('payment-modes.index', ['payment_modes' => $payment_modes]);
			}else{ 
				return redirect()->route('payment-modes.index')->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if(auth()->user() && auth()->user()->hasRole('admin') || auth()->user() && auth()->user()->hasRole('owner')){
            return view('payment-modes.create');
        }else if(auth()->guest()){
            return redirect()->route('front');
        }else return redirect()->route('orders.index')->withStatus(__('No Access'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$request->validate([
			'payment_mode_name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
        $payment_modes= new PaymentModes;
        $payment_modes->name = strip_tags($request->payment_mode_name);
		$payment_modes->description = strip_tags($request->description);
		$payment_modes->is_active = $active;
		$payment_modes->user_id = auth()->user()->id;
		$payment_modes->company_id = auth()->user()->company->id;
        $payment_modes->save();
		
        return redirect()->route('payment-modes.index')->withStatus(__('Payment Mode successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, PaymentModes $payment_modes)
    {
		$request->validate([
			'payment_mode_name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
		$payment_modes = PaymentModes::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
		$payment_modes->name = strip_tags($request->payment_mode_name);
		$payment_modes->description = strip_tags($request->description);
		$payment_modes->is_active = $active;
		$payment_modes->save();
		
        return redirect()->route('payment-modes.index')->withStatus(__('Payment Mode successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PaymentModes $payment_modes)
    {
		$payment_modes = PaymentModes::where(['id' => $id])->first();
        $payment_modes->delete();
        return redirect()->route('payment-modes.index')->withStatus(__('Payment Mode successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$payment_modes = PaymentModes::whereIn('id', $request->items)->delete(); 
			return 'Payment Mode successfully deleted!';
		} else {
			return "no data selected";
		}
	}

}
