<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
	protected $file_path = null;

	public function getUrlAttribute()
	{
		return url($this->slug == 'home' ? '/' : $this->slug);
	}

	public function getFDateAttribute()
	{
		return $this->created_at->format('d M, Y');
	}

	public function image($size = '400x300')
	{
		$image = 'uploads/'. $this->file_path .'/' . $this->image;

		if($this->image && file_exists(public_path($image))){
			return url('upload/'. $this->file_path .'/' . $size . '/' . $this->image);
		}else{
			return asset('images/default/' . $size . '.jpg');
		}
	}

	/**
	 * URL of a resized WebP rendition (generated on first request by ImageController),
	 * or null when the original image is missing.
	 */
	public function webp($size)
	{
		if($this->image && file_exists(public_path('uploads/'. $this->file_path .'/' . $this->image))){
			return url('upload/'. $this->file_path .'/' . $size . '/' . $this->image . '.webp');
		}
		return null;
	}

	public function scopeActive($query)
	{
		return $query->where('status', 1);
	}

	public function getMTitleAttribute()
	{
		return $this->meta_title ? $this->meta_title : $this->title . ' - ' . config('app.name');
	}

	public function getMDescriptionAttribute()
	{
		return $this->meta_description ? $this->meta_description : $this->title;
	}

	public function getMKeywordAttribute()
	{
		return $this->meta_keyword ? $this->meta_keyword : $this->title;
	}

	public function getImagePathAttribute()
	{
		return asset('uploads/' . $this->file_path . '/' . $this->image);
	}

	public function getThumbImageAttribute()
	{
		$path = public_path('uploads/' . $this->file_path . '/thumb/' . $this->image);
		if(!file_exists($path)){
			$this->imageThumb(public_path('uploads/' . $this->file_path . '/' . $this->image), $this->file_path);
		}
		return asset('uploads/' . $this->file_path . '/thumb/' . $this->image);
	}


	public function imageCompress($path, $folder, $type = 'default')
	{
		$size = config('image.' . $type);
		list($width, $height, $quality) = $size;

		if($path && file_exists($path)){
			$image_name = explode('.', $this->image);

			list($name, $ext) = $image_name;
			$save_path = public_path('uploads/' . $folder . '/' . $this->image);
			$image = app(\Intervention\Image\ImageManager::class)->read($path)->cover($width, $height)->save($save_path, quality: $quality);
		}
	}

	public function imageThumb($path, $folder, $type='thumb')
	{
		$folder = $folder.'/thumb';
		$folder_path = public_path('uploads/'.$folder);
		if (!file_exists($folder_path)) {
            mkdir($folder_path, 0777, true);
        }
		$this->imageCompress($path, $folder, $type);
	}

}
