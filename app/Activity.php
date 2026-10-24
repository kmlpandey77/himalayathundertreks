<?php
namespace App;

class Activity extends \App\Base
{
	protected $file_path = 'activities';
	protected $attributes = [
	'status' => 1,
	];
	public function destination()
    {
        return $this->belongsTo('App\Destination');
    }

    public function regions()
    {
        return $this->hasMany('App\Region')->active()->orderBy('order_by');
    }

    public function packages()
    {
        return $this->hasMany('App\Package', 'category_id')->where('region_id', null)->active()->orderby('order_by');
    }


	public function slides()
    {
        return $this->hasMany('App\Slide');
    }

    public function getUrlAttribute()
    {
    	return url($this->slug);
    }
}
