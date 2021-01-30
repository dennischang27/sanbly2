<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\ProductCategories;
use App\Taxes;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Products $products)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$user = auth()->user();
				$products = Products::where(['user_id' => $user->id])->paginate(10);
				$categories = ProductCategories::where(['user_id' => $user->id])->get();
				$taxes = Taxes::where(['user_id' => $user->id])->get();
				return view('products.index', ['products' => $products],compact('categories','taxes'));
			}else{ 
				return redirect()->route('products.index')->withStatus(__('No Access'));
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
			$user = auth()->user();
			$categories = ProductCategories::where(['user_id' => $user->id])->get();
			$taxes = Taxes::where(['user_id' => $user->id])->get();
            return view('products.create',compact('categories','taxes'));
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
			'product_name'  => 'required',
			'price'  => 'required',
			'cost'  => 'required',
        ]);
		
		if (!isset($request->price_includes_tax)) {
			$price_includes_tax = 0;
		} else {
			$price_includes_tax = 1;
		}
		
        $products = new Products;
        $products->item_code = strip_tags($request->item_code);
		$products->name = strip_tags($request->product_name);
		$products->category_id = $request->product_category;
		$products->category = strip_tags($request->category_name);
		$products->serial_number = strip_tags($request->serial_number);
		$products->price_includes_tax = $price_includes_tax;
		$products->price = $request->price;
		$products->tax_id = $request->tax;
		$products->tax = strip_tags($request->tax_name);
		$products->cost = $request->cost;
		$products->stock_level = $request->stock_level;
		$products->notes = strip_tags($request->notes);
		$products->user_id = auth()->user()->id;
		$products->company_id = auth()->user()->company->id;
        $products->save();
		
        return redirect()->route('products.index')->withStatus(__('Product successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Products $products)
    {
		$request->validate([
			'product_name'  => 'required',
			'price'  => 'required',
			'cost'  => 'required',
        ]);
		
		if (!isset($request->price_includes_tax)) {
			$price_includes_tax = 0;
		} else {
			$price_includes_tax = 1;
		}
		
		$products = Products::find($id);
        $products->item_code = strip_tags($request->item_code);
		$products->name = strip_tags($request->product_name);
		$products->category_id = $request->product_category;
		$products->category = strip_tags($request->category_name);
		$products->serial_number = strip_tags($request->serial_number);
		$products->price_includes_tax = $price_includes_tax;
		$products->price = $request->price;
		$products->tax_id = $request->tax;
		$products->tax = strip_tags($request->tax_name);
		$products->cost = $request->cost;
		$products->stock_level = $request->stock_level;
		$products->notes = strip_tags($request->notes);
		$products->user_id = auth()->user()->id;
		$products->company_id = auth()->user()->company->id;
        $products->save();
		
        return redirect()->route('products.index')->withStatus(__('Product successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Products $products)
    {
		$products = Products::find($id);
        $products->delete();
        return redirect()->route('products.index')->withStatus(__('Product successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$products = Products::whereIn('id', $request->items)->delete(); 
			return 'Products successfully deleted!';
		} else {
			return "no data selected";
		}
	}
	
}
