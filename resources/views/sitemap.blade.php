{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd">
	@foreach (App\Page::active()->get() as $page)
	<url>
		<loc>{{ url($page->slug == 'home' ? '/' : $page->slug) }}</loc>
		@if($page->slug == 'home')
			<priority>1.0</priority>
		@else
			<priority>0.8</priority>
		@endif
		<lastmod>{{ $page->updated_at->format('c') }}</lastmod>
	</url>
	@endforeach

	@foreach (App\Destination::active()->get() as $destination)
	<url>
		<loc>{{ url($destination->slug) }}</loc>
		<priority>0.8</priority>
		<lastmod>{{ $destination->updated_at->format('c') }}</lastmod>
		@if ($destination->image)
		<image:image>
			<image:loc>{{ $destination->image_path }}</image:loc>
			<image:caption>{{ $destination->title }}</image:caption>
		</image:image>
		@endif
	</url>
	@endforeach

	@foreach (App\Activity::active()->get() as $activity)
	<url>
		<loc>{{ url($activity->slug) }}</loc>
		<priority>0.8</priority>
		<lastmod>{{ $activity->updated_at->format('c') }}</lastmod>
		@if ($activity->image)
		<image:image>
			<image:loc>{{ $activity->image_path }}</image:loc>
			<image:caption>{{ $activity->title }}</image:caption>
		</image:image>
		@endif
	</url>
	@endforeach

	@foreach (App\Region::active()->get() as $region)
	<url>
		<loc>{{ url($region->slug) }}</loc>
		<priority>0.8</priority>
		<lastmod>{{ $region->updated_at->format('c') }}</lastmod>
		@if ($region->image)
		<image:image>
			<image:loc>{{ $region->image_path }}</image:loc>
			<image:caption>{{ $region->title }}</image:caption>
		</image:image>
		@endif
	</url>
	@endforeach

	@foreach (App\Package::active()->get() as $package)
	<url>
		<loc>{{ url($package->slug) }}</loc>
		<priority>0.8</priority>
		<lastmod>{{ $package->updated_at->format('c') }}</lastmod>
		@if ($package->image)
		<image:image>
			<image:loc>{{ $package->image_path }}</image:loc>
			<image:caption>{{ $package->title }}</image:caption>
		</image:image>
		@endif

		@if ($package->slides->count())
			@foreach ($package->slides as $slide)

			@if($slide->image_path)
			<image:image>
				<image:loc>{{ $slide->image_path }}</image:loc>
				<image:caption>{{ $slide->title }}</image:caption>
			</image:image>
			@endif

			@endforeach
		@endif


		@if($package->map && file_exists(public_path('uploads/maps/'.$package->map)))
		<image:image>
			<image:loc>{{ asset('uploads/maps/'.$package->map) }}</image:loc>
			<image:caption>{{ $package->title }} Route Map</image:caption>
		</image:image>
		@endif
	</url>
	@endforeach

	@foreach (App\Blog::active()->get() as $blog)
	<url>
		<loc>{{ $blog->url }}</loc>
		<priority>0.8</priority>
		<lastmod>{{ $blog->updated_at->format('c') }}</lastmod>
	</url>
	@endforeach


</urlset>