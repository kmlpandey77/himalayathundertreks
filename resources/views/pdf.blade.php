<html>

<head>
	<style>
		@page {
			margin: 120px 50px 100px 50px;
		}

		/* #content {
			margin: 180px auto;
			width: 770px;
		} */

		h1,
		h2,
		h3,
		p,
		ul,
		ol {
			margin: 0;
			padding: 0;
		}

		ul,
		ol {
			margin-top: 5px;
			margin-bottom: 5px;
			margin-left: 30px;
			list-style: square;
		}

		p {
			padding: 5px 0;
		}

		#header {
			position: fixed;
			left: 0px;
			top: -90px;
			right: 0px;
			height: 70px;
			border-bottom: #aaa 1px dotted;
			overflow: hidden;
		}

		#header .logo{
			text-align: center;
		}

		#header .logo img{
			/*width: 100px;*/
		}
		#header .title {
			text-align: center;
		}

		#header .logo p {
			margin: 0;
			margin-top: -10px;
		}

		#header .title h2 {
			margin-top: 5px;
		}

		#header .count {
			background: #aaa;
			color: #fff;
			float: right;
			font-size: 18px;
			font-weight: bold;
			width: 30px;
			height: 30px;
			line-height: 30px;
			margin-top: 5px;
			text-align: center;
		}

		#header .count:after {
			content: counter(page);
		}

		#footer {
			position: fixed;
			left: 0px;
			bottom: -160px;
			right: 0px;
			height: 150px;
			border-top: #aaa 1px dotted;
			padding-top: 10px;
		}
		#footer p{
			text-align: center;
			color: #666;
		}


		#watermark {
			position: fixed;
			bottom: 0px;
			left: 0px;
			top: 0;
			right: 0;
			z-index: -1000;
			text-align: center;

		}

		#watermark img {
			width: 100%;
		}

		.overview {
			 page-break-after: always; 
		}

		.overview h2 {
			text-align: center;
			margin-bottom: 10px;
		}

		p {
			text-align: justify;
		}

		.trip_fact {
			margin-bottom: 10px;
			background: #f1f1f1;
			padding: 10px;
		}

		.trip_fact h3 {
			margin-bottom: 5px;
		}

		.trip_fact p {
			padding: 0 0 5px 0;
		}

		.itineraries {
			margin-top: 10px;
			/*page-break-before: always;*/
		}

		.itineraries h2{
			margin-bottom: 10px;
		}

		.itineraries .itinerary{
			margin-bottom: 10px;
		}

		.itineraries .itinerary .details{
			text-align: justify;
		}

		.itineraries .itinerary .outline{
			margin-bottom: 10px;
			font-weight: bold;
		}

		.itineraries .itinerary .itinerary_highlight span{
			display: inline-block;
			margin-right: 20px;
		}
		.itineraries .itinerary .itinerary_highlight span::after{
			content: ' | ';
			margin-left: 20px;
		}
		.itineraries .itinerary .itinerary_highlight span:last-child::after{
			content: '';
		}

		.note {
			border: 1px solid #ddd;
			background: #f1f1f1;
			padding: 5px;
			margin-top: 10px;
		}

		.map {
			page-break-after: always;
			text-align: center;
		}

		.includes,
		.excludes,
		.trip_details {
			margin-top: 10px;
		}

	</style>

	<body>

		<div id="watermark">
			<img src="{{ public_path('images/watermark.png') }}" />
		</div>


		<div id="header">
			<div class="logo">
				<img src="{{ public_path('images/logo.png') }}" alt="" width="200" />
			</div>
			<div class="title">
				{{-- <h2>{!! $package->title !!}</h2> --}}
				<div class="count"></div>
			</div>
		</div>

		<div id="footer">
			{!! $contact !!}
		</div>
		<div id="content">


			<div class="overview">
				<h2>{!! $package->title !!}</h2>
				<hr>
				@if($package->price || $package->duration || $package->facts()->count() > 0)
				<div class="trip_fact">
					<h3>Trip Facts</h3>

					@if($package->duration)
					<p><b>Duration:</b> {{ $package->duration }} days <br></p>
					@endif

					@foreach ($package->facts as $fact)
					<p><b>{{ $fact->title }}:</b> {{ $fact->value }}</p>
					@endforeach

					@if($package->price)
					<p><b>USD Price:</b> {{ $package->usd_price }} <br></p>
					<p><b>INR Price:</b> {{ $package->inr_price }} <br></p>
					@endif
				</div>
				@endif
				{!! $package->highlight !!}
				{!! $package->details !!}
			</div>

			@if($package->map)
			<div class="map">				
				<img src="{{ public_path('uploads/maps/'. $package->map ) }}" width="700">
			</div>
			@endif

			@if($package->itineraries()->count())
			<div class="itineraries">

				<h2>Day to Day Itinerary </h2>
				@foreach ($package->itineraries as $itinerary)

				<div class="itinerary">
					<div class="outline">{{ $itinerary->day }}:{{ $itinerary->outline }}</div>
					<div class="itinerary_highlight">
						@if ($itinerary->hour)
						<span><b>Walking hr:</b> {{ $itinerary->hour }}</span>
						@endif
						@if ($itinerary->accommodation)
						<span><b>Accommodation:</b> {{ $itinerary->accommodation }}</span>
						@endif
						@if ($itinerary->meal)
						<span><b>Meal:</b> {{ $itinerary->meal }}</span>
						@endif
					</div>
					<div class="details">{!! $itinerary->details !!}</div>
				</div>

				@endforeach

				<div class="note">
					{!! $package->itinerary_note !!}
				</div>
			</div>
			@endif

			@if($package->include)
			<div class="includes">
				<h2>Trip Cost Includes</h2>
				{!! $package->include !!}
			</div>
			@endif @if($package->include)
			<div class="excludes">
				<h2>Trip Cost Excludes</h2> {!! $package->exclude !!}
			</div>
			@endif @if($package->trip_details)
			<div class="trip_details">
				{!! $package->trip_details !!}
			</div>
			@endif


		</div>
	</body>

</html>