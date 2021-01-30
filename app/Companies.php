<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{

    protected $fillable = ['name', 'user_id', 'address','phone','logo','description'];

    /**
     * Get the user that owns the restorant.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

//    public function getAliasAttribute()
//    {
//        return $this->subdomain;
//    }

//    public function getLogomAttribute()
//    {
//        return $this->getImge($this->logo,config('global.restorant_details_image'));
//    }
//    public function getIconAttribute()
//    {
//        return $this->getImge($this->logo,str_replace("_large.jpg","_thumbnail.jpg",config('global.restorant_details_image')),"_thumbnail.jpg");
//    }
//
//    public function getCovermAttribute()
//    {
//        return $this->getImge($this->cover,config('global.restorant_details_cover_image'),"_cover.jpg");
//    }


}
