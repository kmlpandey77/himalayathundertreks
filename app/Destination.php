<?php

namespace App;

class Destination extends \App\Base
{

	protected $file_path = 'destination';

	protected $attributes = [
		'status' => 1,
	];

	public function activities()
	{
		return $this->hasMany('App\Activity')->active();
	}
	
}
