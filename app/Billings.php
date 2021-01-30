<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    protected $table = 'payments';
	
	public function user()
    {
		return $this->hasOne('App\User', 'id', 'user_id');
    }
}
