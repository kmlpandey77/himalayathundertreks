<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teamcategory extends Model
{
	protected $attributes = [
	'status' => 1,
	];

	public function teams()
		{
			return $this->hasMany('App\Team');
		}	
}
