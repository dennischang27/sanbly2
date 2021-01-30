<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Customers;
use App\Companies;
use App\User;

use App\Products;
use App\ProductCategories;
use App\Taxes;

class CustomersController extends Controller
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
				$user = auth()->user();
				
				$customers = Customers::where(['user_id' => $user->id])->paginate(10);
				$user = User::where('id', '=', auth()->user()->id)->first();
				$company = Companies::where('user_id', '=', auth()->user()->id)->first();
				
				$products = Products::where(['user_id' => $user->id])->paginate(10);
				$categories = ProductCategories::where(['user_id' => $user->id])->get();
				$taxes = Taxes::where(['user_id' => $user->id])->get();
				
				return view('customers.index', ['products' => $products, 'customers' => $customers],compact('user','company','categories','taxes'));
				
				//return view('customers.index', ['customers' => $customers]);
			}else{ 
				return redirect()->route('customers.index')->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
    }

}
