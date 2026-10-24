<div class="form-group">
	<label class="col-sm-2 control-label" for="city_id">City</label>
	<div class="col-sm-6">
		<select class="col-md-5 form-control" name="city_id">
			<option value="">Select City</option>
			@foreach($cities as $city)
				<option value="{{ $city->id }}" {{ $city->id == old('city_id', isset($hotel) ? $hotel->city_id : null) ? 'selected="selected"' : null}}  >{{ $city->name }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="name">Name</label>
	<div class="col-sm-6">
		<input class="col-md-5 form-control" placeholder="Name" name="name" value="{{ old('name', isset($hotel) ? $hotel->name : null) }}" type="text" id="name">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="price">Price</label>
	<div class="col-sm-6">
		<input class="col-md-5 form-control" placeholder="Price" name="price" value="{{ old('price', isset($hotel) ? $hotel->price : null) }}" type="text" id="price">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="rate">Rating</label>
	<div class="col-sm-6">
		<select class="col-md-5 form-control" name="rate">
			<option value="0">Rate This Hotel</option>
			<option value="1" {{ isset($hotel) && $hotel->rating == 1 ? 'selected="selected"' : null }}>1 stars</option>
<<<<<<< HEAD
			<option value="2" {{ isset($hotel) &&$hotel->rating == 2 ? 'selected="selected"' : null }}>2 stars</option>
			<option value="3" {{ isset($hotel) && $hotel->rating == 3 ? 'selected="selected"' : null }}>3 stars</option>
			<option value="4" {{ isset($hotel) && $hotel->rating == 4 ? 'selected="selected"' : null }}>4 stars</option>
			<option value="5" {{ isset($hotel) && $hotel->rating == 5 ? 'selected="selected"' : null }}>5 stars</option>
=======
			<option value="2" {{ isset($hotel) &&  $hotel->rating == 2 ? 'selected="selected"' : null }}>2 stars</option>
			<option value="3" {{ isset($hotel) &&  $hotel->rating == 3 ? 'selected="selected"' : null }}>3 stars</option>
			<option value="4" {{ isset($hotel) &&  $hotel->rating == 4 ? 'selected="selected"' : null }}>4 stars</option>
			<option value="5" {{ isset($hotel) &&  $hotel->rating == 5 ? 'selected="selected"' : null }}>5 stars</option>
>>>>>>> ab41dd73368c2889503e6e74991199a883c434ed
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="image">Image</label>
	<div class="col-sm-6">
		<input class="col-md-5" name="image" type="file">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="details">Details</label>
	<div class="col-sm-10">
		<textarea class="col-md-8 form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($hotel) ? $hotel->details : null) }}</textarea>
	</div>
</div>