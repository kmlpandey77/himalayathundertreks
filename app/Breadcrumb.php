<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
	public $value;
	public $breadcrumb;
	public $list_position = 1;

	public function __construct($value, $page=null)
	{
		$this->value = $value;

		$this->breadcrumb =  '<nav itemscope itemtype="http://schema.org/BreadcrumbList" aria-label="breadcrumb" class="hidden-xs">';
		$this->breadcrumb .=  '<ol class="breadcrumb">';
		$this->breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
		$this->breadcrumb .=  '<a itemprop="item"  href="'. url('/') .'">';
		$this->breadcrumb .=  '<span itemprop="name">Home</span>';
		$this->breadcrumb .=  '</a>';
		$this->breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
		$this->breadcrumb .=  '</li>';

		if($page && $page == 'blog'){
			$this->breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
			$this->breadcrumb .=  '<a itemprop="item"  href="'. url('blogs') .'">';
			$this->breadcrumb .=  '<span itemprop="name">Blogs</span>';
			$this->breadcrumb .=  '</a>';
			$this->breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
			$this->breadcrumb .=  '</li>';
		}

		if($page && $page == 'news'){
			$this->breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
			$this->breadcrumb .=  '<a itemprop="item"  href="'. url('news') .'">';
			$this->breadcrumb .=  '<span itemprop="name">News</span>';
			$this->breadcrumb .=  '</a>';
			$this->breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
			$this->breadcrumb .=  '</li>';
			$this->list_position++;
		}

		$this->breadcrumb .= $this->generate();
		$this->breadcrumb .= '</ol></nav>';
	}

	public function __toString()
	{
		return $this->breadcrumb;
	}

	public function generate()
	{
		$breadcrumb = '';

		//DESTINATION
		if($this->value->destination){
			$breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
			$breadcrumb .=  '<a itemprop="item"  href="'. url($this->value->destination->slug) .'">';
			$breadcrumb .=  '<span itemprop="name">'. $this->value->destination->title .'</span>';
			$breadcrumb .=  '</a>';
			$breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
			$breadcrumb .=  '</li>';
		}

		//ACTIVITY
		if($this->value->activity){

			if($this->value->activity->destination){//for region
				$breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
				$breadcrumb .=  '<a itemprop="item"  href="'. url($this->value->activity->destination->slug) .'">';
				$breadcrumb .=  '<span itemprop="name">'. $this->value->activity->destination->title .'</span>';
				$breadcrumb .=  '</a>';
				$breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
				$breadcrumb .=  '</li>';

			}

			$breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
			$breadcrumb .=  '<a itemprop="item"  href="'. url($this->value->activity->slug) .'">';
			$breadcrumb .=  '<span itemprop="name">'. $this->value->activity->title .'</span>';
			$breadcrumb .=  '</a>';
			$breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
			$breadcrumb .=  '</li>';
		}

		//REGION
		if($this->value->region){

			$breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">';
			$breadcrumb .=  '<a itemprop="item"  href="'. url($this->value->region->slug) .'">';
			$breadcrumb .=  '<span itemprop="name">'. $this->value->region->title .'</span>';
			$breadcrumb .=  '</a>';
			$breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
			$breadcrumb .=  '</li>';

		}

		//PAGE
		// $breadcrumb .=  '<li class="breadcrumb-item active">' . $this->value->title . '</li>';
		$breadcrumb .=  '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item active">';
		$breadcrumb .=  '<span itemprop="name">'. $this->value->title .'</span>';
		$breadcrumb .=  '<meta itemprop="position" content="' . $this->list_position++ .'" />';
		$breadcrumb .=  '</li>';

		return $breadcrumb;
	}
}
