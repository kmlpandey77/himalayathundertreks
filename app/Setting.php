<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $attributes = [
		'status' => 1,
	];

	protected $fillable = [
		'title', 'value',
	];

	public function scopeOfValue($query, $title)
	{
		$setting = $query->where('title', $title)->first();
		return $setting ? ($setting->value ? $setting->value : '&nbsp;') : $title;
	}

	public static function getValue($title, $default = null)
	{
		// $settings=self::select('title','value')->get()->pluck('value','title')->toArray();
		$settings = \Cache::remember('settings', now()->addDays(30), function() {
			return self::select('title','value')->get()->pluck('value','title')->toArray();
		});
		// dd($settings);

		if(isset($settings[$title])){
			$value = $settings[$title];
			return $value??$default;
		}
		return $default;
	}

	// public static function getLogo($default = 'img/avatar5.png')
	// {
	// 	$setting = Setting::whereTitle('logo')->first();
	// 	if($setting)
	// 	{
	// 		return asset('uploads/logo/'.$setting->value);
	// 	}
	// 	else
	// 	{
	// 		return asset($default);
	// 	}
	// }
}
