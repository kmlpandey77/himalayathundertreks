<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
	protected $attributes = [
	'status' => 1,
	];

	public function vId()
	{
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->link, $match);
		$youtube_id = $match[1];
		return $youtube_id;
	}

	public function getThumbAttribute()
	{
		return 'https://img.youtube.com/vi/' . $this->vId() . '/hqdefault.jpg';
	}

	public function getVideoIdAttribute()
	{
		return $this->vId();
	}

}
