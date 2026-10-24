<?php

namespace App;

use App\Base;

class Review extends Base
{
	protected $file_path = 'reviews';

	protected $attributes = [
	'status' => 0,
	];

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

	public function thumb($size = '300x300')
	{
		if($this->image){
			$image = public_path('uploads/reviews/' . $this->image);
			if (file_exists($image)) {
				return url('upload/reviews/' . $size . '/' . $this->image);
			}else{
				return 'holder.js/' . $size . '/image not found';
			}
		}else{
			return 'holder.js/' . $size . '/image not found';
		}
	}
}
