<?php
namespace App;

class Page extends \App\Base
{
	protected $file_path = 'page';

	protected $attributes = [
		'status' => 1,
	];

	public function menus()
	{
		return $this->belongsToMany(Menu::class);
	}

	public function parent()
	{
		return $this->belongsTo('App\Page', 'parent_id')->active();
	}

	public function child()
	{
		return $this->hasMany('App\Page', 'parent_id')->orderBy('order_by')->active();
	}

	static function endsWith( $str, $sub = '?' ) {
		return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
	}

	public function scopeHome($query)
	{
		return $query->where('id', 1);
	}	
	
}