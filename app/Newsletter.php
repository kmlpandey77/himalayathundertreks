<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $attributes = [
		'status' => 1,
	];

    protected $fillable = [
    	'title', 'details', 'image', 'html_file', 'type', 'subscriber_group_id',
    ];

    protected $casts = [
        'subscriber_group_id' => 'array',
    ];
}
