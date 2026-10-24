<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class CaptchaController extends Controller
{
    public function image()
    {
		$pass = $this->generate_string();
		session()->put('rand_pass', $pass);

    	$width = (int) config('captcha.width');
    	$height = (int) config('captcha.height');

		$img = app(ImageManager::class)->create($width, $height)->fill('#000');
		$img->text($pass, intdiv($width, 2), intdiv($height, 2), function($font) {
			$font->filename(public_path('font/gothambook.ttf'));
		    $font->size(16);
		    $font->color('#fff');
		    $font->align('center');
		    $font->valign('center');
		    $font->angle(0);
		});
		$encoded = $img->toPng();
		return response((string) $encoded, 200, ['Content-Type' => $encoded->mediaType()]);
    }



    protected function generate_string()
	{
		$chars = config('captcha.chars');
		$number_of_char = config('captcha.number_of_char');

		$chars_length = strlen($chars);

	    $random_string = '';

	    for($i = 0; $i < $number_of_char; $i++) {

	        $random_string .= $chars[mt_rand(0, $chars_length - 1)];

	    }

	    return $random_string;
	}


}
