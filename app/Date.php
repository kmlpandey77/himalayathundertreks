<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
	protected $statuses = [
		'1' => 'Available',
		'2' => 'Limited',
		'3' => 'Closed',
	];

	public function package()
	{
		return $this->belongsTo('App\Package');
	}

	public function start()
	{
		return date('M d, Y', strtotime($this->start));
	}
	public function end()
	{
		return date('M d, Y', strtotime($this->end));
	}

	public function getFinalpriceAttribute()
	{
		if($this->price){
			return $this->price;
		}else{
			return $this->package->price;
		}
	}
	public function status()
	{
		return $this->statuses[$this->status];
	}

	public function getUsdPriceAttribute()
    {
        $price = explode('|', $this->final_price);
        return isset($price[0]) && $price[0]? $price[0]:0;
    }
    public function getInrPriceAttribute()
    {
        $price = explode('|', $this->final_price);
        return isset($price[1]) && $price[1]? $price[1]:0;
    }

    public static function dateByMonth($pid)
    {
    	$datas = self::where('package_id', $pid)->orderBy('start')->where('start','>=', date('Y-m-d'))->get();
    	$month_dates = [];
    	foreach ($datas as $date) {
    		$month = date('F Y', strtotime($date->start));
    		$month_dates[$month][] = $date;
    	}
    	return $month_dates;
    }

}
