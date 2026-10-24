<?php

namespace App;

use App\Base;

class Blog extends Base
{
	protected $file_path = 'blogs';

	protected $attributes = [
		'status' => 1,
	];

	protected $casts = [
		'event_date' => 'date',
	];

	public function image($size = '450x300')
	{
		if($this->image && file_exists(public_path('uploads/blogs/' . $this->image))){
			return url('upload/blogs/' . $size . '/' . $this->image);
		}else{
			return asset('images/default/' . $size .'.jpg');
		}
	}

	public function getUrlAttribute()
	{
		return url('blogs/'.$this->id.'/'.$this->slug);
	}

	public function getFDateAttribute()
	{
		return $this->event_date ? $this->event_date->format('d M, Y') : $this->created_at->format('d M, Y');
	}

}
