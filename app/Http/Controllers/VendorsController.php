<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendors;
use App\Customers;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vendors $vendors)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$company_id = auth()->user()->company->id;
                $vendors = Vendors::where(['company_id' => $company_id])->paginate(10);
                
				return view('vendors.index', ['vendors' => $vendors]);
			}else{ 
				return redirect()->route('vendors.index')->withStatus(__('No Access'));
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
			$company_id = auth()->user()->company->id;
			
            return view('vendors.create');
        }else return redirect()->route('login');
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
            'display_name'  => 'required'
        ]);
        
        if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
        
        $vendors = new Vendors;
		$vendors->vendor_name = strip_tags($request->display_name);
        $vendors->vendor_contact_name = strip_tags($request->contact_name);
        $vendors->vendor_phone = strip_tags($request->vendor_phone);
        $vendors->vendor_email = strip_tags($request->vendor_email);
        $vendors->vendor_website = strip_tags($request->vendor_website);
        $vendors->vbill_name = strip_tags($request->bill_name);
        $vendors->vbill_phone = strip_tags($request->bill_phone);
        $vendors->vbill_address = strip_tags($request->bill_address);
        $vendors->vbill_state = strip_tags($request->bill_state);
        $vendors->vbill_city = strip_tags($request->bill_city);
        $vendors->vbill_zipcode = strip_tags($request->bill_zipcode);
        $vendors->vbill_country = strip_tags($request->bill_country);
        $vendors->is_active = $active;
        
        $vendors->user_id = auth()->user()->id;
		$vendors->company_id = auth()->user()->company->id;
        $vendors->save();
        
        return redirect()->route('vendors.index')->withStatus(__('Vendor successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Vendors $vendors)
    {
		$request->validate([
            'display_name'  => 'required'
        ]);
        
        if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
		$vendors = Vendors::find($id);
        $vendors->vendor_name = strip_tags($request->display_name);
        $vendors->vendor_contact_name = strip_tags($request->contact_name);
        $vendors->vendor_phone = strip_tags($request->vendor_phone);
        $vendors->vendor_email = strip_tags($request->vendor_email);
        $vendors->vendor_website = strip_tags($request->vendor_website);
        $vendors->vbill_name = strip_tags($request->bill_name);
        $vendors->vbill_phone = strip_tags($request->bill_phone);
        $vendors->vbill_address = strip_tags($request->bill_address);
        $vendors->vbill_state = strip_tags($request->bill_state);
        $vendors->vbill_city = strip_tags($request->bill_city);
        $vendors->vbill_zipcode = strip_tags($request->bill_zipcode);
        $vendors->vbill_country = strip_tags($request->bill_country);
        $vendors->is_active = $active;
        
        $vendors->user_id = auth()->user()->id;
		$vendors->company_id = auth()->user()->company->id;
        $vendors->save();
		
        return redirect()->route('vendors.index')->withStatus(__('Vendor successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Vendors $vendors)
    {
		$vendors = Vendors::find($id);
        $vendors->delete();
        return redirect()->route('vendors.index')->withStatus(__('Vendor successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$vendors = Vendors::whereIn('id', $request->items)->delete(); 
			return 'Vendor successfully deleted!';
		} else {
			return "no data selected";
		}
	}
	
}
