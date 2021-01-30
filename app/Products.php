<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Products extends Model
{
    protected $table = 'products';
	
	public function category()
    {
        //return $this->belongsTo(ServiceCategories::class, 'id');
		//return $this->hasOne('App\ProductCategories', 'id', 'id_product_categories');
    }
	
}
