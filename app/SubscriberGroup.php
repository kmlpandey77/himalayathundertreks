<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberGroup extends Model
{
    protected $attributes = [
    	'status' => 1,
    ];

    protected $fillable = [
    	'title', 'details',
    ];

    public function subscribers()
	{
		return $this->belongsToMany(Subscriber::class);
	}
}
