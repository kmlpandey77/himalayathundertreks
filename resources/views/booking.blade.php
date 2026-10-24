@extends('layouts.app')

@section('meta')
<meta content="{{ $package->title }} Booking" name="description" />
<meta content="{{ $package->title }} Booking" name="keywords" />
@endsection

@section('canonical', $package->url)

@section('content')

<section class="content gray-bg">
	<div class="container">
	  <div class="row">
		<div class="col-sm-8">
		  <div class="overview">
			<h1>{{ $package->title }} Booking Form</h1>
			@if($errors->any())
				<div class="alert alert-danger">
					<ul class="mb-0">
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form class="booking-form" role="form" action="" method="post">
				{{ csrf_field() }}
					<br>
					<input type="hidden" name="trip_name" value="{{ $package->title }}">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_fname" >First Name <span> *</span></label>
								<input type="text" class="form-control" id="text_fname" name="text_fname" placeholder="" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_lname">Last Name <span> *</span></label>
								<input type="text" class="form-control" id="text_lname" name="text_lname" placeholder="" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_phone">Phone no. </label>
								<input type="text" class="form-control" id="text_phone" name="text_phone" placeholder="" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="text_email">Email Address <span> *</span></label>
								<input type="text" class="form-control" id="text_email" name="text_email" placeholder="" required>
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
					</div>
					<hr>
					<h4>Trip Details</h4>
					<div class="spacer1"></div>
					<div class="row">
						<div class="col-sm-3">
							<label>No. of Child <span> *</span></label>
	                        <input type="number" min="0" class="form-control" id="number_of_child_traveller" name="number_of_child_traveller" placeholder="Child Travellers">
                        </div>
                        <div class="col-sm-3">
	                        <label>No. of Adults <span> *</span></label>
	                        <input type="number" min="1" class="form-control" id="number_of_adult_traveller" name="number_of_adult_traveller" placeholder="Adult Travellers">
	                    </div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="check_in" >Arrival date <span> *</span></label>
								<input type="text" class="form-control datepicker" id="check_in" name="check_in" required value="">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="check_out">Departure date <span> *</span></label>
								<input type="text" class="form-control deparute_date" id="check_out" name="check_out" required value="">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Airport pickup?</label>
								<label class="radio-inline">
									<input type="radio" name="pickup" id="" checked value="Yes">
								Yes </label>
								<label class="radio-inline">
									<input type="radio" name="pickup" id="" value="No">
								No </label>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="texta_message">Message</label>
								<textarea class="form-control form-massage" id="texta_message" name="texta_message" placeholder=""></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="row form-group">
		                        <div class="col-md-2">
		                            <img src="{{ route('captchaimage') }}" alt="Captcha">
		                        </div>

		                        <div class="col-md-10">
		                            <input type="text" class="form-control {{ $errors->has('captcha') ? ' is-invalid' : '' }}" id="captcha" name="captcha" placeholder="Enter Captcha">
		                            @if ($errors->has('captcha'))
		                                <span class="help-block text-danger"><strong>{{ $errors->first('captcha') }}</strong></span>
		                            @endif
		                        </div>
		                    </div>
						</div>
						<div class="col-sm-12">
							<label for="captha"> &nbsp; </label>
							<input type="checkbox" id="accept" required>
							<label for="accept" class="accept">I have read and accept the Booking <a href="{{ url('terms-and-conditions') }}">terms and conditions</a></label>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label for="captha"> &nbsp; </label>
								<button name="btnBokking" type="submit" class="button button-primary button-rounded button-raised">Submit</button>
							</div>
						</div>
					</div>
				</form>

		  </div>
		</div>
		<div class="col-sm-4">

		  <div class="content-right card">
				<div class="booking-overview card-body">
					<img src="{{ $package->image_path }}" alt="{{ $package->title }}" title="{{ $package->title }}" class="img-fluid">
					<h4 class="mt-">{{ $package->title }}</h4>
					<ul>
						<li><b>Duration: </b> {{ $package->duration }} Day(s)</li>
						<li><b>Package Price: </b> US$ {{ $package->price }}</li>
						<li><b>Grade: </b> {{ config('grade.title.' . $package->grade) }}
							<a href="#!" data-toggle="popover" data-trigger="hover" data-content="{{ $package->grade_content }}"
								data-placement="top">
								<i class="fa fa-info-circle"></i>
							</a>
						</li>
					</ul>
				</div>
		  </div>

		</div>
	  </div>
	</div>
  </section>

@endsection
