@extends('layouts.app') 
@section('title') Customize Trip
@endsection
 
@section('meta')
<meta name="description" content="Customize Trip">
<meta name="keywords" content="Customize Trip">
@endsection
 
@section('content')

<section class="content gray-bg customize_trip">
	<div class="container">

		<div class="row">
			<div class="col-sm-8">
				<div class="content-left">
					<h1>Customize Trip</h1>

					<form class="" role="form" action="" method="post">
						{{ csrf_field() }}
						<h5>Trip Information</h5>
						<div class="form-group">
							<label for="package">How many people are travelling? <span> *</span></label>							
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="package">Trip to Customize<span> *</span></label>
									<select class="form-control" id="package" name="package" readonly>
											<option value="">Select trip</option>			
		
											@foreach ($trips as $trip)
											<option {{ isset($package) && $package->id == $trip->id ? 'selected="selected"' : null }} value="{{ $trip->title }}">{{ $trip->title }}</option>
											@endforeach
		
										</select>
								</div>
							</div>
						</div>
						<h5>Your Personal Information</h5>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="text_name">Your Name <span> *</span></label>
									<input type="text" class="form-control" id="text_name" name="text_name" placeholder="" required>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="text_email">Your Email<span> *</span></label>
									<input type="email" class="form-control" id="text_email" name="text_email" placeholder="" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="text_phone">Phone no. <span> *</span></label>
									<input type="text" class="form-control" id="text_phone" name="text_phone" placeholder="" required>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="sel_country">Country <span> *</span></label>
									<select class="form-control" id="sel_country" name="sel_country">
											<option value="" selected="selected">Select Country</option>									
											@foreach ($countries as $country)
											<option value="{{ $country->name }}">{{ $country->name }}</option>
											@endforeach
		
										</select>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="texta_message" style="width:100%;">Tell us how you would like to customize this trip.</label>
									<textarea name="texta_message" rows="5" class="form-control" id="texta_message" placeholder=""></textarea>
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<button name="customizeTrip" type="submit" class="button button-primary button-pill">Submit</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
			<div class="col-sm-4">

				<div class="content-right">


				</div>

			</div>
		</div>
	</div>
</section>

<div class="inpage white-bg">
	<div class="container">
		<h1>Customize Trip</h1>
		<hr>
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<form class="" role="form" action="" method="post">
					{{ csrf_field() }}
					<h3>Trip Information</h3>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label for="package">Trip to Customize<span> *</span></label>
								<select class="form-control" id="package" name="package">
									<option value="">Select trip</option>			

									@foreach ($trips as $trip)
									<option {{ isset($package) && $package->id == $trip->id ? 'selected="selected"' : null }} value="{{ $trip->title }}">{{ $trip->title }}</option>
									@endforeach

								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<label for="trip_duration">Duration</label>
							<input type="text" class="form-control" id="trip_duration" name="trip_duration" placeholder="">
						</div>
						<div class="col-sm-4">
							<label for="trip_cost">Price Range</label>
							<select name="trip_cost" class="form-control" id="trip_cost">
								<option value="" selected="selected">Select Price Range</option>
								<option value="below $1000"> Below &lt; $1000</option>
								<option value="$1000-$2000">$1000-$2000</option>
								<option value="$2000-$4000">$2000-$4000</option>
								<option value="$4000-$8000">$4000-$8000</option>
								<option value="$8000-$12000">$8000-$12000</option>
								<option value="$12000 and Above">&lt; $12000  Above</option>
							</select>
						</div>
					</div>
					<h3>Your Personal Information</h3>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_name">Your Name <span> *</span></label>
								<input type="text" class="form-control" id="text_name" name="text_name" placeholder="" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_email">Your Email<span> *</span></label>
								<input type="email" class="form-control" id="text_email" name="text_email" placeholder="" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_phone">Phone no. <span> *</span></label>
								<input type="text" class="form-control" id="text_phone" name="text_phone" placeholder="" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="sel_country">Country <span> *</span></label>
								<select class="form-control" id="sel_country" name="sel_country">
									<option value="" selected="selected">Select Country</option>									
									@foreach ($countries as $country)
									<option value="{{ $country->name }}">{{ $country->name }}</option>
									@endforeach

								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="texta_message" style="width:100%;">Tell us how you would like to customize this trip.</label>
								<textarea name="texta_message" rows="5" class="form-control" id="texta_message" placeholder=""></textarea>
							</div>
						</div>
						{{--
						<div class="col-sm-12">
							<div class="form-group">
								<label for="captha">Captcha <span> *</span></label>
								<div class="captcha-hoder">
									<input type="text" class="" id="captcha" name="captcha_code" required>
								</div>
							</div>
						</div> --}}

						<div class="col-sm-12">
							<div class="form-group">
								<button name="customizeTrip" type="submit" class="btn btn-orange">Submit</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
@endsection