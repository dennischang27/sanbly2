<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $table = 'expenses';

    
    public function expenseCat()
    {
        return $this->belongsTo('App\ExpenseCategories', 'expense_category_id');
    }
}
