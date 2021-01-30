<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpensesCategories;

class ExpensesCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpensesCategories $expenses_categories)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$expenses_categories = ExpensesCategories::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('expenses-categories.index', ['expenses_categories' => $expenses_categories]);
			}else{ 
				return redirect()->route('expenses-categories.index')->withStatus(__('No Access'));
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
            return view('expenses-categories.create');
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
			'name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
        $expenses_categories= new ExpensesCategories;
        $expenses_categories->name = strip_tags($request->name);
		$expenses_categories->description = strip_tags($request->description);
		$expenses_categories->is_active = $active;
		$expenses_categories->user_id = auth()->user()->id;
		$expenses_categories->company_id = auth()->user()->company->id;
        $expenses_categories->save();
		
        return redirect()->route('expenses-categories.index')->withStatus(__('Expenses Category successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ExpensesCategories $expenses_categories)
    {
		$request->validate([
			'name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
		$expenses_categories = ExpensesCategories::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
		$expenses_categories->name = strip_tags($request->name);
		$expenses_categories->description = strip_tags($request->description);
		$expenses_categories->is_active = $active;
		$expenses_categories->save();
		
        return redirect()->route('expenses-categories.index')->withStatus(__('Expenses Category successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ExpensesCategories $expenses_categories)
    {
		$expenses_categories = ExpensesCategories::where(['id' => $id])->first();
        $expenses_categories->delete();
        return redirect()->route('expenses-categories.index')->withStatus(__('Expenses Category successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$expenses_categories = ExpensesCategories::whereIn('id', $request->items)->delete(); 
			return 'Expenses Category successfully deleted!';
		} else {
			return "no data selected";
		}
	}

}
