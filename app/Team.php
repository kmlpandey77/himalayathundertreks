<?php

namespace App;

use App\Base;

class Team extends Base
{
	protected $file_path = 'teams';
	
	protected $attributes = [
	'status' => 1,
	];	

	public function thumb($size = '300x300')
	{
		if($this->image){
			$image = public_path('uploads/teams/' . $this->image);
			if (file_exists($image)) {
				return url('upload/teams/' . $size . '/' . $this->image);
			}else{				
				return 'holder.js/200x200/image not found';
			}
		}else{			
			return 'holder.js/200x200/image not found';
		}
	}

	public function teamcategory()
	{
		return $this->belongsTo('App\Teamcategory');
	}
}
