<?php

namespace App;

use App\Base;

class Tag extends Base
{

	public function packages()
	{
		return $this->belongsToMany(Package::class);
	}

}
