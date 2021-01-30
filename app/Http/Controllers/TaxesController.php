<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Taxes;
use App\Web;
use DB;

class TaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Taxes $taxes)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$taxes = Taxes::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('taxes.index', ['taxes' => $taxes]);
			}else{ 
				return redirect()->route('taxes.index')->withStatus(__('No Access'));
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
            return view('taxes.create');
        }else if(auth()->guest()){
            return redirect()->route('front');
        }else return redirect()->route('taxes.index')->withStatus(__('No Access'));
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
			'tax_name'  => 'required',
            'tax_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        
		$tax= new Taxes;
		$tax->tax_name = strip_tags($request->tax_name);
		$tax->tax_amount = strip_tags($request->tax_amount);
		$tax->user_id = auth()->user()->id;
		$tax->company_id = auth()->user()->company->id;
		$tax->save();
		
		return redirect()->route('taxes.index')->withStatus(__('Category successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
			'tax_name'  => 'required',
            'tax_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
		
		$taxes =  Taxes::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
        $taxes->tax_name = strip_tags($request->tax_name);
        $taxes->tax_amount = strip_tags($request->tax_amount);
        $taxes->user_id = auth()->user()->id;
        $taxes->company_id = auth()->user()->company->id;
        $taxes->save();
        return redirect()->route('taxes.index')->withStatus(__('Tax successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$taxes =  Taxes::where(['id' => $id])->first();
        $taxes->delete();
        return redirect()->route('taxes.index')->withStatus(__('Tax successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$taxes = Taxes::whereIn('id', $request->items)->delete(); 
			return 'Taxes successfully deleted!';
		} else {
			return "no data selected";
		}
	}
}
