<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseCategories;

class ExpenseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseCategories $expense_categories)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
                $company_id = auth()->user()->company->id;
				$expense_categories = ExpenseCategories::where('company_id', '=', $company_id)->paginate(10);
				return view('expense-categories.index', ['expense_categories' => $expense_categories]);
			}else{ 
				return redirect()->route('expense-categories.index')->withStatus(__('No Access'));
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
            return view('expense-categories.create');
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
			'expense_category_name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
        $expense_categories= new ExpenseCategories;
        $expense_categories->name = strip_tags($request->expense_category_name);
		$expense_categories->description = strip_tags($request->description);
		$expense_categories->is_active = $active;
		$expense_categories->user_id = auth()->user()->id;
		$expense_categories->company_id = auth()->user()->company->id;
        $expense_categories->save();
		
        return redirect()->route('expense-categories.index')->withStatus(__('Payment Mode successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ExpenseCategories $expense_categories)
    {
		$request->validate([
			'expense_category_name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
		$expense_categories = ExpenseCategories::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
		$expense_categories->name = strip_tags($request->expense_category_name);
		$expense_categories->description = strip_tags($request->description);
		$expense_categories->is_active = $active;
		$expense_categories->save();
		
        return redirect()->route('expense-categories.index')->withStatus(__('Payment Mode successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ExpenseCategories $expense_categories)
    {
		$expense_categories = ExpenseCategories::where(['id' => $id])->first();
        $expense_categories->delete();
        return redirect()->route('expense-categories.index')->withStatus(__('Payment Mode successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$expense_categories = ExpenseCategories::whereIn('id', $request->items)->delete(); 
			return 'Payment Mode successfully deleted!';
		} else {
			return "no data selected";
		}
	}

}
