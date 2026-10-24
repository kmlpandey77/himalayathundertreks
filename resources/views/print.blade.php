<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $package->title }} Printable Itinerary</title>

	<meta content="{{ $package->title }} Printable Itinerary" name="description" />
	<meta content="{{ $package->title }} Print Itinerary" name="keywords" />
	<link rel="canonical" href="{{ $package->url }}">
	<meta name="robots" content="noindex, follow">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
	<link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
	<link href="{{ asset('vendors/print.css') }}" rel="stylesheet" media="print">
	<link href="{{ asset('stylesheets/print.css') }}" rel="stylesheet">

	<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

</head>

<body class="A4">
	<a href="#" class="print_btn">Print</a> {{-- <a href="javascript: history.back()" class="back_btn">Back</a> --}}
	<section class="sheet padding-10mm">
		<div class="logo">
			<img src="{{ asset('images/logo.png') }}" alt="" height="85" />
		</div>

		<div class="overview">
			<h1 class="title">{{ $package->title }}</h1>

			<div class="facts">
				<h4>Trip Facts</h4>
				<hr>
				<p>
					<b>Price:</b> USD {{ $package->price }}</p>
				<p>
					<b>Duration:</b> {{ $package->duration }} days</p>
				@foreach ($package->facts as $fact)
				<p>
					<b>{{ $fact->title }}:</b> {{ $fact->value }}</p>
				@endforeach
			</div>

			{!! $package->details !!}

		</div>

		<div class="itinerary">
			<h2 class="sub_title">Day to Day Itinerary </h2>
			@foreach ($package->itineraries as $itinerary)
			<p>
				<strong>{{ $itinerary->day }}:{{ $itinerary->outline }}</strong>
				<br />{!! $itinerary->details !!}
			</p>
			@endforeach
		</div>

		@if($package->map)
		<div class="map">
			<h2 class="sub_title">Route Map</h2>
			<img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map" title="{{ $package->title }} map" class="img-fluid">
		</div>
		@endif

		<div class="includes">
			<h2 class="sub_title">Trip Cost Includes</h2>
			{!! $package->include !!}
		</div>

		<div class="excludes">
			<h2 class="sub_title">Trip Cost Excludes</h2>{!! $package->exclude !!}
		</div>

		<div class="excludes">
			{!! $package->trip_details !!}
		</div>

		{{-- <div class="footer">
			{!! $contact !!}
		</div> --}}
		</div>

	</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		$(function () {
			total_wd = $(document).width();
			sheet_wd = $('.sheet').outerWidth();
			btn_wd = $('.print_btn').outerWidth();
			right_pos = ((total_wd - sheet_wd) / 2) - btn_wd;
			$('.print_btn').css('right', right_pos);
			$(".print_btn").click(function () {
				$('.print_btn').hide();
				window.print();
				$('.print_btn').show();
			});
		});
	</script>
</body>

</html>