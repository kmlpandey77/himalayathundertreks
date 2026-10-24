<?php

namespace App;

use MatthiasMullie\Minify;

class Min
{
	private $minify_path;
	private $source_file = [];
	private $type;
	private $last_mod = 0;
	private $isCombine;

	public function __construct($type)
	{
		$this->type = $type;
		$this->isCombine = config('minify.combine');
		$this->minify_path();
		$this->source_file();
		$this->generate();
	}

	private function minify_path(){

		$this->minify_path = config('minify.' . $this->type .'.min_path');
	}

	private function source_file(){

		$this->source_file = config('minify.' . $this->type .'.files');
	}

	private function generate(){

		if($this->isCombine){
			$minify_path = public_path($this->minify_path);

			if(file_exists($minify_path)){
				$this->last_mod = filemtime($minify_path);
			}

			$update = false;
			if(!file_exists($minify_path)){
				$update = true;
			}else{
				foreach ($this->source_file as $file) {
					$mod = filemtime($file);
					if($this->last_mod < $mod){
						$update = true;
						break;
					}
				}
			}

			if($update){
				if($this->type == 'js'){
					$minifier = new Minify\JS($this->source_file);
				}else{
					$minifier = new Minify\CSS($this->source_file);
				}
				$minifier->minify($minify_path);
			}

		}

	}

	public function linkFiles()
	{
		if($this->isCombine){
			return $this->type =='css'
			? '<link rel="stylesheet" href="' . $this->versioned($this->minify_path) .'">'
			: '<script src="' . $this->versioned($this->minify_path) .'" defer></script>';
		}else{
			$_rtn = null;
			foreach ($this->source_file as $file) {
				$_rtn .= $this->type =='css'
				? '<link rel="stylesheet" href="' . $this->versioned($file) .'">'
				: '<script src="' . $this->versioned($file) .'"></script>';
			}
			return $_rtn;
		}
	}

	/**
	 * Asset URL with the file's modification time as cache buster, so browsers
	 * cache it until the file actually changes (a random string defeated caching).
	 */
	private function versioned($file)
	{
		$path = public_path($file);
		return asset($file) . (file_exists($path) ? '?v=' . filemtime($path) : '');
	}

	public function __toString()
	{
		return $this->linkFiles();
	}


}
