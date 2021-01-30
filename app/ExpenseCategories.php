<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategories extends Model
{
    protected $table = 'expense_categories';
    
    public function expenses() {
        return $this->hasMany('Expenses');
    }

}
