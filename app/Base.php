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
		if ($this->meta_title) {
			// Short custom titles (e.g. "Reviews") get the brand so they stand on their own in results.
			$brand = config('app.name');
			return mb_strlen($this->meta_title) < 40 && stripos($this->meta_title, $brand) === false
				? $this->meta_title . ' | ' . $brand
				: $this->meta_title;
		}
		return $this->title . ' - ' . config('app.name');
	}

	public function getMDescriptionAttribute()
	{
		if ($this->meta_description) {
			return $this->meta_description;
		}
		// Fall back to the opening of the page's own content rather than repeating the title.
		$text = \Illuminate\Support\Str::squish(html_entity_decode(strip_tags((string) $this->details), ENT_QUOTES | ENT_HTML5));
		return $text !== ''
			? \Illuminate\Support\Str::limit($text, 155, '…', preserveWords: true)
			: $this->title;
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
