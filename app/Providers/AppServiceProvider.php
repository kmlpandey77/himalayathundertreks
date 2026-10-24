<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // Laravel 5.5 rendered Bootstrap 3 pagination by default; newer versions default to Tailwind.
        Paginator::useBootstrapThree();
        view()->composer('inc.navbar', function ($view) {
            $view->with('main_menu', \App\Menu::main());
        });
        view()->composer('inc.footer', function ($view) {
            $view->with('footer_link', \App\Menu::link(3));
            $view->with('footer_dests', \Cache::remember('footer_dests', now()->addDays(15), function(){
                return \App\Region::select('title', 'slug')->where('activity_id', 1)->active()->get()->toArray();
            }));
            $view->with('socials', \Cache::remember('socials', now()->addDays(15), function(){
                return \App\Social::select('title', 'class', 'link', 'icon')->active()->get()->toArray();
            }));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImageManager::class, fn () => ImageManager::gd());
    }
}
