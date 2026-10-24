<?php

if(!function_exists('nmr_format')){

    function nmr_format($number)
    {
        return '$' . number_format($number);
    }
}

if(!function_exists('__l')){

    function __l($labelId)
    {
        return \App\Label::getValue($labelId);
    }
}

if (!function_exists('__s'))
{
    function __s ($title, $default=null)
    {
        return \App\Setting::getValue($title, $default);
    }
}

if(!function_exists('static_path')){

    function static_path($path)
    {
        $url = '//assets.' . config('app.domain');
        return $url . '/' . $path;
    }
}

if(!function_exists('review_count')){

    function review_count()
    {
        return \Cache::remember('review_count_approved', now()->addDays(15), function(){
            return \App\Review::active()->count();
        });
    }
}