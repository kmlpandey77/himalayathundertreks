<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

	public function pages()
	{
		return $this->belongsToMany(Page::class)->active();
	}


	public static function main($id=2)
	{
		return \Cache::remember('menu_' . $id, now()->addDays(15), function() use($id){
			$pages = Menu::find($id)->pages;
			$i = 1;
			$menu = [];
			foreach ($pages as $page) {

				if($i == 2){

					$activities = Activity::active()->where('show_in_menu', 1)->take(5)->get();

					foreach ($activities as $activities) {
						$menu += self::activities_chain($activities);
					}



					$destinations = Destination::active()->orderBy('order_by')->get();
					$d_i = 1;
					foreach ($destinations as $destination) {
						$menu += self::dest_chain($destination);
					}
				}

				$menu += self::page_child($page);
				$i++;
			}
			return $menu;
		});
	}

	public static function link($id, $child = false)
	{
		return \Cache::remember('menu_' . $id, now()->addDays(15), function() use($id){
			$menu = self::find($id);
			return $menu->pages()->select('title', 'slug')->get()->toArray();
		});
	}

	public static function page_child($page)
	{
		if($page){

			$menu[$page->slug] = $page->title;
			if(count($child = $page->child) > 0){
				$sub = [];
				foreach ($child as $c) {
					$sub += self::page_child($c);
				}
				$menu[$page->slug] = $menu + array('sub' => $sub);
			}

			return $menu;
		}else{
			return false;
		}
	}

	public static function dest_chain($destination)
	{
		if($destination){

			$dest_items[$destination->slug] = $destination->title;

			if($destination->id == 1){

				if(count($activities = $destination->activities)){
					foreach ($activities as $activity) {
						if($activity->id <> 9){
							$act_items[$activity->slug] = $activity->title;
							if(count($regions = $activity->regions)){
								$reg_items = [];

								foreach ($regions as $region) {
									$reg_items[$region->slug] = $region->title;
									if(count($reg_packages = $region->packages)){
										$reg_pack_items = [];
										foreach ($reg_packages as $reg_package) {
											$reg_pack_items[$reg_package->slug] = $reg_package->title. ' - ' . $reg_package->days();
										}
										$reg_items[$region->slug] = $reg_items + array('sub'=>$reg_pack_items);
									}
								}

								$act_items[$activity->slug] = $act_items + array('sub'=>$reg_items);
							}

							if(count($packages = $activity->packages)){
								$pack_items=[];
								foreach ($packages as $package) {
									$pack_items[$package->slug] = $package->title . ' - ' . $package->days();
								}
								if(isset($act_items[$activity->slug]['sub'])){
									$act_items[$activity->slug]['sub'] += $pack_items;
								}else{
									$act_items[$activity->slug] = $act_items + array('sub'=>$pack_items);
								}
							}
						}
					}
					$dest_items[$destination->slug] = $dest_items + array('sub'=>$act_items);
				}
			}else{

				if(count($activities = $destination->activities)){
					$pack_items=[];
					foreach ($activities as $activity) {
						if(count($packages = $activity->packages)){
							foreach ($packages as $package) {
								$pack_items[$package->slug] = $package->title . ' - ' . $package->days();
							}

						}
					}
					$dest_items[$destination->slug] = $dest_items + array('sub'=>$pack_items);
				}

			}

			return $dest_items;

		}else{
			return false;
		}
	}

	public static function activities_chain($activity)
	{
		if($activity){

			$act_items[$activity->slug] = $activity->menu_title?:$activity->title;
			if(count($regions = $activity->regions)){
				$reg_items = [];

				foreach ($regions as $region) {
					$reg_items[$region->slug] = $region->title;
					if(count($reg_packages = $region->packages)){
						$reg_pack_items = [];
						foreach ($reg_packages as $reg_package) {
							$reg_pack_items[$reg_package->slug] = $reg_package->title. ' - ' . $reg_package->days();
						}
						$reg_items[$region->slug] = $reg_items + array('sub'=>$reg_pack_items);
					}
				}

				$act_items[$activity->slug] = $act_items + array('sub'=>$reg_items);
			}

			if(count($packages = $activity->packages)){
				$pack_items=[];
				foreach ($packages as $package) {
					$pack_items[$package->slug] = $package->title . ' - ' . $package->days();
				}
				if(isset($act_items[$activity->slug]['sub'])){
					$act_items[$activity->slug]['sub'] += $pack_items;
				}else{
					$act_items[$activity->slug] = $act_items + array('sub'=>$pack_items);
				}
			}

			return $act_items;

		}else{
			return false;
		}
	}

	public static function html($menus, $i=0)
	{
		$i++;
		$html = null;
		foreach($menus as $link => $menu){
	        if(is_array($menu)){
	        	// dd($menu);
	        	$html .= '<li class="'. ($i==1?'nav-item ': null) .'dropdown">';
	        	$html .= '<a class="'.($i==1? 'nav-link' : 'dropdown-item').' dropdown-toggle" href="'.url($link).'">'.$menu[$link].'</a>';
	        	$html .= '<ul class="dropdown-menu">';
	        	$html .= self::html($menu['sub'], $i);
	        	$html .= '</ul>';
	        	$html .= '</li>';
	        }else{
	        	$html .= '<li class="'. ($i==1?'nav-item ': null) .'"><a class="'.($i==1? 'nav-link' : 'dropdown-item').'" href="'.url($link=='home'?'/':$link).'">'.$menu.'</a></li>';
	        }
	    }

	    return $html;
	}
}