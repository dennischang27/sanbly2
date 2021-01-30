<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    
    protected $fillable = ['name','stripe_id','company_id','user_id','frequency','amount','currency','country','provider'];
}
