<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategories;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductCategories $categories)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$categories = ProductCategories::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('product-categories.index', ['categories' => $categories]);
			}else{ 
				return redirect()->route('product-categories.index')->withStatus(__('No Access'));
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
            return view('product-categories.create');
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
			'product_category_name'  => 'required',
        ]);
		
        $category= new ProductCategories;
        $category->name = strip_tags($request->product_category_name);
		$category->user_id = auth()->user()->id;
		$category->company_id = auth()->user()->company->id;
        $category->save();
		
        return redirect()->route('product-categories.index')->withStatus(__('Category successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ProductCategories $categories)
    {
		$request->validate([
			'product_category_name'  => 'required',
        ]);
		
		$category = ProductCategories::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
		$category->name = strip_tags($request->product_category_name);
		$category->save();
		
        return redirect()->route('product-categories.index')->withStatus(__('Category successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ProductCategories $categories)
    {
		$category = ProductCategories::where(['id' => $id])->first();
        $category->delete();
        return redirect()->route('product-categories.index')->withStatus(__('Category successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$categories = ProductCategories::whereIn('id', $request->items)->delete(); 
			return 'Categories successfully deleted!';
		} else {
			return "no data selected";
		}
	}

}
