<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpLookUp extends Model
{
    public static function getData(){

        $ip = request()->ip();        
        // $ip = '27.34.16.73';
        $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.config('services.ipstack.key'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $api_result = json_decode($json, true);

        return $api_result;
    }
}
