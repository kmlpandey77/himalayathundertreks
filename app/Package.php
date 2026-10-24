<?php

namespace App;

class Package extends \App\Base
{
    protected $file_path = 'packages';

    /**
     * Per-instance cache for computed attributes that hit the database.
     */
    protected $memo = [];

	protected $attributes = [
	'status' => 1,
	];

    protected $casts = [
        'type' => 'array',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeFeature($query)
	{
		return $query->where('type', 'like', '%feature_trip%');
    }

    public function scopeFeatureTrek($query)
	{
		return $query->where('category_id', 1)->feature();
    }

    public function scopeFeatureTour($query)
	{
		return $query->where('category_id', 2)->feature();
	}

    public function region()
    {
        return $this->belongsTo('App\Region', 'region_id');
    }
    public function activity()
    {
        return $this->belongsTo('App\Activity', 'category_id');
    }

    public function facts()
    {
        return $this->hasMany('App\Fact')->orderBy('order_by');
    }

    public function graphs()
    {
        return $this->hasMany('App\Graph');
    }

    public function getFGraphsAttribute()
    {
        if($this->graphs()->count() > 0){

            $data = [];
            foreach($this->graphs as $graph){
                $data['labels'][] = $graph->point;
                $data['datas'][] = $graph->value;
            }
            return json_encode($data);

        }else{
            return false;
        }
    }

    public function itineraries()
    {
        return $this->hasMany('App\Itinerary')->orderBy('order_by');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function dates()
    {
        return $this->hasMany('App\Date')->orderBy('start')->where('start','>=', date('Y-m-d'));
    }
    public function slides()
    {
        return $this->hasMany('App\Slide');
    }
    public function price_detail()
    {
        return $this->hasOne('App\Price');
    }

    public function category()
    {
        $region = $this->region;
        if($region){
        	return $region;
        }else{
        	return $this->activity;
        }
    }

	public function image($size = '400x300')
    {
        $image = null;

        if($this->image){
            $image = public_path('uploads/packages/' . $this->image);
            $image_url = url('upload/packages/' . $size . '/' . $this->image);
        }

        if(!file_exists($image) && count($this->slides) > 0){
            $image = public_path('uploads/slide/' . $this->slides->first()->image);
            $image_url = url('upload/slide/' . $size . '/' . $this->slides->first()->image);
        }

        if($image && file_exists($image)){
            return $image_url;
        }else{
            return asset('images/default/' . $size .'.jpg');
        }
    }

    public function days()
    {
        return !is_numeric($this->duration) ? $this->duration : (($this->duration==1) ?  '1 Day' : $this->duration . ' Days');
    }

    public function getNightAttribute()
    {
        return ($this->duration - 1) . ' Night';
    }

    public function getGradeContentAttribute()
    {
        return config('grade.content.'.$this->grade);
    }

    public function getFPriceAttribute()
    {
        $price = explode('|', $this->price);
        $prices['usd'] = isset($price[0]) && $price[0]? $price[0]:0;
        $prices['inr'] = isset($price[1]) && $price[1]? $price[1]:0;
        return $prices;
    }

    public function getOldPriceAttribute()
    {
        $price = $this->price * 1.1;
        $price = ceil($price / 10) * 10;
        return $price;
    }

    public function getUsdPriceAttribute()
    {
        $price = explode('|', $this->price);
        return isset($price[0]) && $price[0]? $price[0]:0;
    }
    public function getInrPriceAttribute()
    {
        $price = explode('|', $this->price);
        return isset($price[1]) && $price[1]? $price[1]:0;
    }

    public function getFDurationAttribute()
    {
        return is_numeric($this->duration) ? $this->duration . ($this->duration == 1 ? ' Day' :' Days' ) : $this->duration;
    }

    public function has_date()
    {
        return count($this->dates) > 0 ? true : false ;
    }

    public function getOtherInfoAttribute()
    {
        $otherinfo = null;
        foreach (config('otherinfo') as $key => $value) {
            if(in_array($this->category_id, $value)){
                $page = \App\Page::find($key);
                if($page){
                    $otherinfo = $page->details;
                }
                break;
            }
        }
        return $otherinfo;
    }

    public static function ord_by($activity=null, $region=null)
    {
        if($region){
            $pck = self::where('region_id', $region);
        }else{
            $pck = self::where('category_id', $activity);
        }

        $ord_by = $pck->max('order_by');
        return $ord_by + 1;
    }

    public static function tripInfo($category)
    {
        $info[] = config('tripinfo.general_info');
        $info_id = config('tripinfo.trip_info.' . $category);
        if($info_id){
            $info[] = $info_id;
        }
        return \App\Page::whereIn('parent_id', $info)->get();
    }

    public function getMaxAltitudeAttribute()
    {
        if (array_key_exists('max_altitude', $this->memo)) {
            return $this->memo['max_altitude'];
        }

        $titles = ['Max. Altitude', 'Maximum Altitude', 'Max Altitude'];
        // Use eager-loaded facts when available (listing pages) to avoid a query per card.
        $max_alt = $this->relationLoaded('facts')
            ? $this->facts->first(fn ($fact) => in_array(strtolower(trim($fact->title)), array_map('strtolower', $titles)))
            : \App\Fact::where('package_id', $this->id)->whereIn('title', $titles)->first();

        return $this->memo['max_altitude'] = $this->parseAltitude($max_alt);
    }

    protected function parseAltitude($max_alt)
    {
        if($max_alt){
            preg_match_all('!\d+!', $max_alt->value, $matches);
            // print_r();
            return isset($matches[0][0]) ? $matches[0][0] . "M" : null;
        }

        return null;
    }

    public function album()
    {
        return $this->hasOne('App\Album');
    }
}
