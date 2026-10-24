<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
	public function scopeOfValue($query, $labelid)
	{
		$label = $query->where('labelid', $labelid)->first();
		return $label ? ($label->value ? $label->value : '&nbsp;') : $labelid;
	}

	public static function getValue($labelId)
	{
		list($page, $id) = explode(':', $labelId);

		$labels = \Cache::remember('labels.' . $page, now()->addDays(30), function () use($page) {
			return self::select('labelid', 'value')->where('page', $page)->get()->pluck('value', 'labelid')->toArray();
		});

		if(isset($labels[$labelId])){
			$value = $labels[$labelId];
			return $value??$labelId;
		}
		return $labelId;
	}
}