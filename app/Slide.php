<?php

namespace App;

use App\Base;

class Slide extends Base
{
	protected $attributes = [
		'status' => 1,
	];

	protected $file_path = 'slide';

	public function scopeActive($query)
	{
		return $query->where('status', 1);
	}

	public function scopeHome($query)
	{
		return $query->where('package_id', 0)->where('activity_id', 0)->where('region_id', 0)->active()->orderBy('order_by');
	}

}
