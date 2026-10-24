<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $attributes = [
        'status' => 1,
    ];

    protected $fillable = [
        'package_id', 'slug',
    ];

    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function photos()
    {
    	return $this->hasMany('App\Photo');
    }

    public function getThumbAttribute()
    {
    	$photo = $this->photos()->first();
    	if($photo){
    		return $photo->image();
    	}
    	return false;
    }
}
