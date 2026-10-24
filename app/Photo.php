<?php

namespace App;

use App\Base;

class Photo extends Base
{
    protected $file_path = 'photo';

    protected $attributes = [
        'status' => 1,
    ];

    protected $fillable = [
    	'album_id', 'image', 'caption',
    ];

    public function album()
    {
    	return $this->belongsTo('App\Album');
    }
}
