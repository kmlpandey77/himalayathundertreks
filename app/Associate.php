<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
	protected $attributes = [
	'status' => 1,
	];

	public function getIconAttribute()
	{
		$icon = config('associate.'.$this->slug);		
		if($icon){
			return asset('images/'. $icon);
		}else{
			return asset('images/'. $this->slug.'.png');
		}
	}

}
