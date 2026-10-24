<?php

namespace App;

use App\Base;

class News extends Base
{
	protected $file_path = 'news';

	protected $attributes = [
		'status' => 1,
	];	

	public function event_date(){
		return date('m.d.Y', strtotime($this->created_at));		
	}
	public function date(){
		return date('d M, Y', strtotime($this->created_at));
	}
	public function image($size = '450x300')
	{
		if($this->image && file_exists(public_path('uploads/news/' . $this->image))){
			return url('upload/news/' . $size . '/' . $this->image);			
		}else{			
			return asset('images/default/' . $size .'.jpg');
		}
	}

	public function thumb($size = '100x80')
	{
		if($this->image){
			$image = public_path('uploads/news/' . $this->image);
			if (file_exists($image)) {
				return url('upload/news/' . $size . '/' . $this->image);
			}else{				
				return 'holder.js/' . $size . '/image not found';
			}
		}else{			
			return 'holder.js/' . $size . '/image not found';
		}
	}

	public function meta_title()
	{
		return $this->title;
	}

	public function meta_description()
	{
		return $this->title;
	}

	public function meta_keyword()
	{
		return $this->title;
	}

	public function getUrlAttribute()
	{
		return url('news/'. $this->id);
	}

}
