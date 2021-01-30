<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Customers;
use App\Products;
use App\ProductCategories;
use App\Web;
use DB;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customers $customers)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$customers = Customers::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('customers.index', ['customers' => $customers]);
			}else{ 
				return redirect()->route('customers.index')->withStatus(__('No Access'));
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
            return view('customers.create');
        }else if(auth()->guest()){
            return redirect()->route('front');
        }else return redirect()->route('customers.index')->withStatus(__('No Access'));
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
			'name'  => 'required',
        ]);
		
		$languages = "";
		
		if($request->languages){
			$numItems = count($request->languages);
			$i = 0;
			
			foreach ($request->languages as $value) {
				if(++$i === $numItems) {
					$languages .= $value;
				} else {
					$languages .= $value."/";
				}
			}
		}
        
		$customer= new Customers;
		$customer->name = strip_tags($request->name);
		$customer->address = strip_tags($request->address);
		$customer->city = strip_tags($request->city);
		$customer->state = strip_tags($request->state);
		$customer->zipcode = strip_tags($request->zipcode);
		$customer->country = strip_tags($request->country);
		$customer->phone = strip_tags($request->phone);
		$customer->currency = strip_tags($request->currency);
		$customer->languages = $languages;
		$customer->user_id = auth()->user()->id;
		$customer->company_id = auth()->user()->company->id;
		$customer->save();
		
		return redirect()->route('customers.index')->withStatus(__('Customer successfully created!'));
    }
	
	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Customers $customers)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$user = auth()->user();
				
				//$customers = Customers::where(['user_id' => $user->id])->paginate(10);
				//$user = User::where('id', '=', auth()->user()->id)->first();
				//$company = Companies::where('user_id', '=', auth()->user()->id)->first();
				
				$products = Products::where(['user_id' => $user->id])->paginate(10);
				$categories = ProductCategories::where(['user_id' => $user->id])->get();
				//$taxes = Taxes::where(['user_id' => $user->id])->get();
				
				//return view('customers.index', ['products' => $products, 'customers' => $customers]);
				
				
				$customer =  Customers::where(['id' => $id])->first();
				return view('customers.edit',['products' => $products, 'categories' => $categories, 'customer' => $customer]);
				
			}else{ 
				return redirect()->route('customers.index')->withStatus(__('No Access'));
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
			'name'  => 'required',
        ]);
		
		$languages = "";
		
		if($request->languages){
			$numItems = count($request->languages);
			$i = 0;
			
			foreach ($request->languages as $value) {
				if(++$i === $numItems) {
					$languages .= $value;
				} else {
					$languages .= $value."/";
				}
			}
		}
		
		$id = $request->id;
		$customer = Customers::where(['id' => $id])->first();
		$customer->name = strip_tags($request->name);
		$customer->address = strip_tags($request->address);
		$customer->city = strip_tags($request->city);
		$customer->state = strip_tags($request->state);
		$customer->zipcode = strip_tags($request->zipcode);
		$customer->country = strip_tags($request->country);
		$customer->phone = strip_tags($request->phone);
		$customer->currency = strip_tags($request->currency);
		$customer->languages = $languages;
		$customer->user_id = auth()->user()->id;
		$customer->company_id = auth()->user()->company->id;
		$customer->save();
		
        return redirect()->route('customers.edit', $id)->with( [ 'tab' => 'general' ] )->withStatus(__('General successfully updated!'));
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
		
		$customers =  Customers::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
        $customers->tax_name = strip_tags($request->tax_name);
        $customers->tax_amount = strip_tags($request->tax_amount);
        $customers->user_id = auth()->user()->id;
        $customers->company_id = auth()->user()->company->id;
        $customers->save();
        return redirect()->route('customers.index')->withStatus(__('Customer successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$customers =  Customers::where(['id' => $id])->first();
        $customers->delete();
        return redirect()->route('customers.index')->withStatus(__('Customer successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$customers = Customers::whereIn('id', $request->items)->delete(); 
			return 'Customers successfully deleted!';
		} else {
			return "no data selected";
		}
	}
}
