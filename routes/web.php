<?php

use UniSharp\LaravelFilemanager;


Route::get('/', 'HomeController@index')->name('home');
Route::get('/blogs/{blog}/{slug}', 'BlogController@view');

Route::get('/reviews', 'ReviewController@index');


Route::get('captcha', 'CaptchaController@image')->name('captchaimage');


/**
 * routes for admins
 */
Route::get('administrative/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('administrative/login', 'Auth\LoginController@login');
Route::get('administrative/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('administrative/logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'administrative', 'middleware' => ['auth'], 'namespace' => 'Admin'], function () {
    // Route::get('/', 'DashboardController@dashboard')->name('dashboard');
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/phpinfo', function () {
        phpinfo();
    });

    Route::resource('pages', 'PageController');
    Route::post('pages/order', 'PageController@order')->name('pages.order');
    Route::get('pages/showhide/{page}', 'PageController@showhide')->name('pages.showhide');
    Route::resource('menus', 'MenuController');
    Route::get('menus/showhide/{menu}', 'MenuController@showhide')->name('menus.showhide');

    Route::resource('tags', 'TagController');
    Route::get('tags/showhide/{tag}', 'TagController@showhide')->name('tags.showhide');

    Route::resource('destinations', 'DestinationController');
    Route::post('destinations/order', 'DestinationController@order')->name('destinations.order');
    Route::resource('activities', 'ActivityController');
    Route::get('activities/showhide/{activity}', 'ActivityController@showhide')->name('activities.showhide');
    Route::resource('regions', 'RegionController');
    Route::post('regions/order', 'RegionController@order')->name('regions.order');
    Route::get('regions/showhide/{region}', 'RegionController@showhide')->name('regions.showhide');
    Route::resource('packages', 'PackageController');
    Route::post('packages/order', 'PackageController@order')->name('packages.order');
    Route::post('packages/factdelete', 'PackageController@factdelete')->name('packages.factdelete');
    Route::post('packages/factorder', 'PackageController@factorder')->name('packages.factorder');
    Route::get('packages/showhide/{package}', 'PackageController@showhide')->name('packages.showhide');
    Route::post('packages/viewitinerary/{package}', 'PackageController@viewitinerary')->name('packages.viewitinerary');
    Route::post('packages/itineraryorder', 'PackageController@itineraryorder')->name('packages.itineraryorder');
    Route::get('packages/itinerarydelete/{itinerary}', 'PackageController@itinerarydelete')->name('packages.itinerarydelete');
    Route::resource('blogs', 'BlogController');
    Route::resource('reviews', 'ReviewController');
    Route::post('reviews/{id}/approve', 'ReviewController@approve')->name('review.approve');
    Route::post('reviews/{id}/decline', 'ReviewController@decline')->name('review.decline');
    Route::resource('teams', 'TeamController');
    Route::post('teams/order', 'TeamController@order')->name('teams.order');
    Route::resource('teamcategories', 'TeamcategoryController');
    Route::post('teamcategories/order', 'TeamcategoryController@order')->name('teamcategories.order');
    Route::resource('socials', 'SocialController');
    Route::resource('associates', 'AssociateController');
    Route::resource('labels', 'LabelController');
    Route::resource('legaldocs', 'LegaldocController');
    Route::post('legaldocs/photodelete', 'LegaldocController@photodelete')->name('legaldocs.photodelete');
    Route::resource('redirects', 'RedirectController');
    Route::resource('subscribers', 'SubcriberController');
    Route::resource('subscriber-groups', 'SubscriberGroupController');
    Route::resource('newsletters', 'NewsletterController');
    Route::post('newsletters/resend/{newsletter}', 'NewsletterController@resend')->name('resend');
    Route::resource('news', 'NewsController');

    Route::resource('slides', 'SlideController');
    Route::post('slides/order', 'SlideController@order')->name('slides.order');
    Route::get('slides/showhide/{slide}', 'SlideController@showhide')->name('slides.showhide');
    Route::get('tripslides/create/{trip}', 'TripslideController@create')->name('tripslides.create');
    Route::get('tripslides/{trip}', 'TripslideController@index')->name('tripslides.index');
    Route::post('tripslides/{trip}', 'TripslideController@store')->name('tripslides.store');
    Route::get('tripslides/{slide}/edit', 'TripslideController@edit')->name('tripslides.edit');
    Route::put('tripslides/{slide}', 'TripslideController@update')->name('tripslides.update');
    Route::delete('tripslides/{slide}', 'TripslideController@destroy')->name('tripslides.destroy');

    Route::get('activityslides/create/{trip}', 'ActivityslideController@create')->name('activityslides.create');
    Route::get('activityslides/{trip}', 'ActivityslideController@index')->name('activityslides.index');
    Route::post('activityslides/{trip}', 'ActivityslideController@store')->name('activityslides.store');
    Route::get('activityslides/{slide}/edit', 'ActivityslideController@edit')->name('activityslides.edit');
    Route::put('activityslides/{slide}', 'ActivityslideController@update')->name('activityslides.update');
    Route::delete('activityslides/{slide}', 'ActivityslideController@destroy')->name('activityslides.destroy');

    Route::get('regionslides/create/{trip}', 'RegionslideController@create')->name('regionslides.create');
    Route::get('regionslides/{trip}', 'RegionslideController@index')->name('regionslides.index');
    Route::post('regionslides/{trip}', 'RegionslideController@store')->name('regionslides.store');
    Route::get('regionslides/{slide}/edit', 'RegionslideController@edit')->name('regionslides.edit');
    Route::put('regionslides/{slide}', 'RegionslideController@update')->name('regionslides.update');
    Route::delete('regionslides/{slide}', 'RegionslideController@destroy')->name('regionslides.destroy');

    Route::get('tripdates/create/{trip}', 'TripdateController@create')->name('tripdates.create');
    Route::get('tripdates/{trip}', 'TripdateController@index')->name('tripdates.index');
    Route::post('tripdates/{trip}', 'TripdateController@store')->name('tripdates.store');

    Route::get('tripdates/{date}/edit', 'TripdateController@edit')->name('tripdates.edit');
    Route::put('tripdates/{date}', 'TripdateController@update')->name('tripdates.update');
    Route::delete('tripdates/{date}', 'TripdateController@destroy')->name('tripdates.destroy');

    Route::resource('cities', 'CityController');
    Route::resource('hotels', 'HotelController');
    Route::resource('videos', 'VideoController');
    Route::resource('albums', 'AlbumController');
    Route::post('albums/photodelete', 'AlbumController@photodelete')->name('albums.photodelete');

    Route::resource('settings', 'SettingController');
    Route::get('settings/showhide/{setting}', 'SettingController@showhide')->name('settings.showhide');
    Route::post('settings/script', 'SettingController@script')->name('setting.script');
    Route::put('settings/change-script/{setting}', 'SettingController@changescript')->name('change.script');

    Route::get('cache-clear', function () {
        \Artisan::call('cache:clear');
        return redirect()->back();
    })->name('cache-clear');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/phpinfo', function () {
        phpinfo();
    });

});


Route::get('upload/{type}/{size}/{imageName}', 'ImageController@index')
    ->where(['type' => '[A-Za-z0-9_-]+', 'size' => '[0-9]+x[0-9]+'])
    ->name('image');

$pages = App\Page::select('slug')->get(); // only the slug is needed to register the route
foreach ($pages as $page) {
    if ($page->slug == 'legal-documents') {
        $router->get($page->slug, 'PageController@legaldoc');
    } elseif ($page->slug == 'contact') {
        $router->get($page->slug, 'PageController@contact')->name('contact');
        $router->post($page->slug, 'PageController@contact');
    } elseif ($page->slug == 'blogs') {
        $router->get($page->slug, 'BlogController@index');
    } elseif ($page->slug == 'reviews') {
        $router->get($page->slug, 'ReviewController@index');
    } elseif ($page->slug == 'our-team') {
        $router->get($page->slug, 'PageController@ourteam');
    } elseif ($page->slug == 'video-gallery') {
        $router->get($page->slug, 'PageController@video');
    } elseif ($page->slug == 'photo-gallery') {
        $router->get($page->slug, 'PageController@photo');
    } elseif ($page->slug <> '/') {
        $router->get($page->slug, 'PageController@index');
    }
}

Route::get('photo-gallery/{album}', 'PageController@viewphoto')->name('photo-gallery');

$cities = App\City::select('slug')->get(); // only the slug is needed to register the route
foreach ($cities as $city) {
    $router->get($city->slug, 'PageController@city');
}
$router->get('hotelbooking/{id}', 'PageController@hotelbooking')->name('hotelbooking');
$router->post('hotelbooking/{id}', 'PageController@hotelbooking');

$router->get('sitemap.xml', 'PageController@sitemap');

$destinations = App\Destination::select('slug')->get(); // only the slug is needed to register the route
foreach ($destinations as $dest) {
    $router->get($dest->slug, 'DestinationController@index');
}

$activities = App\Activity::select('slug')->get(); // only the slug is needed to register the route
foreach ($activities as $activity) {
    $router->get($activity->slug, 'ActivityController@index');
}

$regions = App\Region::select('slug')->get(); // only the slug is needed to register the route
foreach ($regions as $region) {
    $router->get($region->slug, 'RegionController@index');
}

$packages = App\Package::select('slug')->get(); // only the slug is needed to register the route
foreach ($packages as $package) {
    $router->get($package->slug, 'PackageController@index');
}

$tags = App\Tag::whereNotIn('id', [1, 2])->get();
foreach ($tags as $tag) {
    $router->get($tag->slug, 'TagController@index');
}

Route::get('pdf/{slug}', 'PrintController@pdf')->name('pdf');
Route::post('sendinquiry', 'BookingController@inquiry')->name('sendinquiry');
Route::post('customize', 'CustomizeController@index')->name('customize');

Route::get('booking/{slug}', 'BookingController@index')->name('booking');
Route::post('booking/{slug}', 'BookingController@index');
Route::get('print/{slug}', 'PrintController@index')->name('print');


Route::post('requestcallback', 'BookingController@requestcallback')->name('requestcallback');
Route::post('downloadbrochure', 'BookingController@downloadbrochure')->name('downloadbrochure');

Route::get('thankyou', 'BookingController@thankyou')->name('thankyou');

Route::post('subscriber', 'BookingController@subscriber')->name('subscriber');


Route::get('/write-review', 'ReviewController@writereview')->name('write-review');
Route::post('/write-review', 'ReviewController@reviewstore');
