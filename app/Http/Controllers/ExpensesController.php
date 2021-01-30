<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expenses;
use App\Customers;
use App\ExpenseCategories;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Expenses $expenses)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$company_id = auth()->user()->company->id;
                
				$expenses = Expenses::with('expenseCat')->where(['expenses.company_id' => $company_id])->paginate(10);
                
				$categories = ExpenseCategories::where(['company_id' => $company_id])->where(['is_active' => 1])->get();
                $customers = Customers::where(['company_id' => $company_id])->get();
                
				return view('expenses.index', ['expenses' => $expenses],compact('categories', 'customers'));
			}else{ 
				return redirect()->route('expenses.index')->withStatus(__('No Access'));
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
			$categories = ExpenseCategories::where(['company_id' => $company_id])->where(['is_active' => 1])->get();
			$customers = Customers::where(['company_id' => $company_id])->get();
            return view('expenses.create',compact('categories', 'customers'));
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
            'expense_name'  => 'required',
			'expense_date'  => 'required',
			'expense_amount'  => 'required',
        ]);
        
        $expenses = new Expenses;
		$expenses->name = strip_tags($request->expense_name);
        $expenses->expense_category_id = $request->expense_category;
        $expenses->expense_amount = $request->expense_amount;
        $expenses->expense_date = date("Y-m-d", strtotime($request->expense_date));
        $expenses->expense_notes = strip_tags($request->notes);
        $expenses->customer_id = $request->customer;
        $expenses->vendor_id = $request->vendor_id;
        
        $expenses->user_id = auth()->user()->id;
		$expenses->company_id = auth()->user()->company->id;
        $expenses->save();
        
        return redirect()->route('expenses.index')->withStatus(__('Expense successfully created!'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Expenses $expenses)
    {
		$request->validate([
            'expense_name'  => 'required',
			'expense_date'  => 'required',
			'expense_amount'  => 'required',
        ]);
		
		$expenses = Expenses::find($id);
        $expenses->name = strip_tags($request->expense_name);
        $expenses->expense_category_id = $request->expense_category;
        $expenses->expense_amount = $request->expense_amount;
        $expenses->expense_date = date("Y-m-d", strtotime($request->expense_date));
        $expenses->expense_notes = strip_tags($request->notes);
        $expenses->customer_id = $request->customer;
        $expenses->vendor_id = $request->vendor_id;
        
        $expenses->user_id = auth()->user()->id;
		$expenses->company_id = auth()->user()->company->id;
        $expenses->save();
		
        return redirect()->route('expenses.index')->withStatus(__('Expense successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Expenses $expenses)
    {
		$expenses = Expenses::find($id);
        $expenses->delete();
        return redirect()->route('expenses.index')->withStatus(__('Expense successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$expenses = Expenses::whereIn('id', $request->items)->delete(); 
			return 'Expense successfully deleted!';
		} else {
			return "no data selected";
		}
	}
	
}
