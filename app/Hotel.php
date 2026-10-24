<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
    	'city_id', 'name', 'slug', 'price', 'image', 'details', 'rating',
    ];

    public function city()
    {
    	return $this->belongsTo('App\City');
    }
}
