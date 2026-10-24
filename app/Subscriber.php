<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
	protected $attributes = [
	'status' => 1,
	];

	protected $fillable = [
		'name', 'email', 'phone',
	];

	public function subscriber_groups()
	{
		return $this->belongsToMany(SubscriberGroup::class);
	}
}
