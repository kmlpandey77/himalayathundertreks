# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

A Laravel 13 (PHP ^8.3) web application for Himalaya Thunder Treks, a trekking/tour operator site. It is built on an in-house admin/CMS layer called "LotusCMS" (see `config/admin.php`), built by Lotus Design Nepal. There is a public-facing site (destinations, packages, blog, reviews, booking) plus a full `administrative/` back-office for managing all content.

## Commands

### PHP / Laravel
- Install dependencies: `composer install`
- Run the app locally: `php artisan serve`
- Run all tests: `vendor/bin/phpunit`
- Run a single test file: `vendor/bin/phpunit tests/Feature/ExampleTest.php`
- Run a single test method: `vendor/bin/phpunit --filter testMethodName`
- Clear/rebuild caches after config or route changes: `php artisan config:clear`, `php artisan route:clear`, `php artisan view:clear`
- Database migrations: `php artisan migrate` (note: the legacy `.sql` dump/seed files at the repo root are local-only and git-ignored — they contain user data — and are not Laravel migrations)

### Frontend assets
- Install JS dependencies: `npm install`
- Build dev assets: `npm run dev` (or `npm run watch` while iterating)
- Build production assets: `npm run prod`
- Asset pipeline is Laravel Mix (`webpack.mix.js`), compiling `resources/assets/sass/app.scss` and `resources/assets/js/app.js` into `public/css`/`public/js`.

Note: the test suite (`tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`) is still the Laravel scaffold default — there is no real application-level test coverage yet. Tests run against the `.env` MySQL database (not SQLite), because `routes/web.php` queries `pages`, `packages`, etc. at boot to register slug routes.

On this machine PHP comes from Laravel Herd; use `~/.config/herd/bin/php84/php.exe` explicitly if `php` on PATH resolves to the 7.4 build.

## Architecture

### Application bootstrap
The app uses the Laravel 11+ streamlined structure: there is no `app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php` or `RouteServiceProvider`. Routing, middleware and exception handling are configured in `bootstrap/app.php` (web routes are loaded with the `App\Http\Controllers` namespace so string actions like `'PageController@index'` keep working; 404s are checked against the admin-managed `App\Redirect` table there). Service providers are listed in `bootstrap/providers.php`. Class aliases used from Blade (`Minify`, `Breadcrumb`, plus Laravel's defaults like `Str`) are in `config/app.php`.

### Public site vs. admin
`routes/web.php` defines both the public routes (top-level, e.g. `HomeController`, `BlogController`, `ReviewController`) and an `administrative` route group (`middleware: auth`, `namespace: Admin`) that contains a full CRUD resource per content type (pages, menus, tags, destinations, activities, regions, packages, blogs, reviews, teams, slides, newsletters, subscribers, redirects, etc.). Admin controllers live in `app/Http/Controllers/Admin/`, public controllers directly in `app/Http/Controllers/`. Views mirror this split: `resources/views/admin/*` vs. top-level `resources/views/*.blade.php`.

Admin login is handled by `app/Http/Controllers/Auth/LoginController.php` (hand-rolled, rate limited to 5 attempts/minute; there is no `laravel/ui`).

Most admin resources follow a consistent pattern beyond the standard REST resource routes: a `showhide/{id}` toggle route and an `order/{model}` route for drag-and-drop ordering (backed by an `order_by` column and `ord_by()`-style static helpers on the model).

### Models extend `App\Base`
Nearly every content model (`Package`, `Destination`, `Region`, `Activity`, `Blog`, `Team`, etc.) extends `App\Base` (`app/Base.php`) rather than `Illuminate\Database\Eloquent\Model` directly. `Base` centralizes conventions used across the whole app:
- `$file_path` (set per-model) determines the `uploads/{file_path}/...` location for that model's images.
- `image($size)` / `getImagePathAttribute()` / `getThumbImageAttribute()` resolve an image URL, generating a resized/thumbnailed copy on first access and falling back to `images/default/{size}.jpg` when no image exists.
- `scopeActive()` filters on a `status` column (1 = published) — used throughout public controllers to only show live content.
- `getMTitleAttribute()` / `getMDescriptionAttribute()` / `getMKeywordAttribute()` provide meta-tag fallbacks (falls back to `title` / app name when meta fields are empty).
- `getFDateAttribute()` and `getUrlAttribute()` (handles the `home` slug specially, mapping it to `/`).

When adding a new content type, follow this pattern (extend `Base`, set `$file_path`, use `scopeActive`) rather than reinventing image/meta handling.

### Package is the central domain model
`App\Package` (`app/Package.php`) is the most complex model — it represents a trek/tour product and ties together `Region`/`Activity` (category), `Fact`, `Graph` (elevation profile data for `chart.js`-style display), `Itinerary`, `Review`, `Date` (departure dates), `Price`, `Slide`, and `Album`. Pricing is stored as a pipe-delimited string (`"usd|inr"`) and split via `getFPriceAttribute()`/`getUsdPriceAttribute()`/`getInrPriceAttribute()`. Trip-info boilerplate text is resolved dynamically through `config/tripinfo.php` plus `App\Page` lookups by `parent_id`, keyed by category — check that config when package "general info" / "other info" sections look wrong.

### Config-driven content
Several behaviors are driven by PHP config arrays rather than DB tables: `config/grade.php` (difficulty grade descriptions), `config/duration.php`, `config/price.php`, `config/tripinfo.php`, `config/facts.php`, `config/menu.php`. Check these first when a dropdown/label/description needs to change — it's often config, not a migration.

### Global helpers (`app/Helper.php`)
Autoloaded via composer's `files` directive (not a facade/service). Key helpers used throughout views and controllers:
- `__l($labelId)` — looks up `App\Label` (editable UI label strings).
- `__s($title, $default)` — looks up `App\Setting` (site-wide settings, admin-editable).
- `nmr_format($number)` — formats a number as a `$`-prefixed string.
- `static_path($path)` — builds a URL against a separate static-assets subdomain (`assets.{app.domain}`).
- `review_count()` — cached (15 days) count of `App\Review` rows.

Cache TTLs are in seconds (Laravel 5.8+), so code uses `now()->addDays(n)` rather than raw minute counts. `config/cache.php` `serializable_classes` restricts which classes may be unserialized from cache — add a model there if you start caching Eloquent objects (currently only `App\Page`).

### Image handling
`App\Smart\Services\Image\*` (`ImageService`, `ImageMaker`, `ImageFormat`, `ValidatesResolution`) wraps `intervention/image` v3 (GD driver; `Intervention\Image\ImageManager` is bound as a singleton in `AppServiceProvider` — there is no `Image` facade) for upload processing, used alongside the per-model `image()`/`imageCompress()`/`imageThumb()` methods on `Base`. The file manager (`unisharp/laravel-filemanager`, configured in `config/lfm.php`) is used in admin forms for broader media browsing/selection, separate from the per-model image upload flow.

### Other integrations worth knowing about
- `barryvdh/laravel-debugbar` is a dev dependency — expect a debug toolbar locally when `APP_DEBUG=true`.
- `dompdf/dompdf` (v3) powers PDF generation (see `resources/views/pdf.blade.php`, `PrintController`).
- `rap2hpoutre/laravel-log-viewer` exposes a log-viewing UI at `administrative/logs` (behind `auth`).
- Blade gotcha: Laravel 11+ registers a `@context` directive, so JSON-LD in views must write `"@@context"`.
