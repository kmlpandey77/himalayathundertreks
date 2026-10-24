<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
	public function icon()
	{
		$icon = \Illuminate\Support\Str::slug($this->title);
		return config('facts.'.$icon);
	}
	public function col()
	{
		$length = strlen($this->title . $this->value);
		if($length > 30){
			$col = 'col-sm-12';
		}else{
			$col = 'col-sm-6';
		}
		// var_dump($col);
		return $col;
	}
}
