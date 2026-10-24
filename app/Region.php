<?php

namespace App;

class Region extends \App\Base
{
	protected $file_path = 'region';
	
	protected $attributes = [
		'status' => 1,
	];
	
	public function activity()
	{
		return $this->belongsTo('App\Activity');
	}

	public function packages()
	{
		return $this->hasMany('App\Package')->orderby('order_by')->active();
	}

	public function slides()
    {
        return $this->hasMany('App\Slide');
    }

	
}
