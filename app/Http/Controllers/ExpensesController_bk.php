<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expenses;

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
				$expenses = Expenses::where('user_id', '=', auth()->user()->id)->paginate(10);
				return view('expenses.index', ['expenses' => $expenses]);
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
            return view('expenses.create');
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
		
        $expenses= new Expenses;
        $expenses->name = strip_tags($request->name);
		$expenses->description = strip_tags($request->description);
		$expenses->is_active = $active;
		$expenses->user_id = auth()->user()->id;
		$expenses->company_id = auth()->user()->company->id;
        $expenses->save();
		
        return redirect()->route('expenses.index')->withStatus(__('Expenses successfully created!'));
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
			'name'  => 'required',
        ]);
		
		if (!isset($request->active)) {
			$active = 0;
		} else {
			$active = 1;
		}
		
		$expenses = Expenses::where(['id' => $id])->where('company_id',auth()->user()->company->id)->first();
		$expenses->name = strip_tags($request->name);
		$expenses->description = strip_tags($request->description);
		$expenses->is_active = $active;
		$expenses->save();
		
        return redirect()->route('expenses.index')->withStatus(__('Expenses successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Expenses $expenses)
    {
		$expenses = Expenses::where(['id' => $id])->first();
        $expenses->delete();
        return redirect()->route('expenses.index')->withStatus(__('Expenses successfully deleted!'));
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
			return 'Expenses successfully deleted!';
		} else {
			return "no data selected";
		}
	}

}
