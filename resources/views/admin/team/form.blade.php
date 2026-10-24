<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('teams.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="teamcategory_id">Category</label>
		<div class="col-sm-6">
			<select class="form-control" name="teamcategory_id" id="teamcategory_id">
				<option value="">Select Category</option>
				@foreach ($categories as $category)
				<option value="{{ $category->id }}" {{ $category->id == old('teamcategory_id', isset($team) ? $team->teamcategory_id : null ) ? 'selected="selected"' : null }}>{{ $category->title }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="name">Name</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Name" name="name" value="{{ old('name', isset($team) ? $team->name : null) }}" type="text" id="name">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="position">Position</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Position" name="position" value="{{ old('position', isset($team) ? $team->position : null) }}" type="text" id="position">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="email">Email</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Email" name="email" value="{{ old('email', isset($team) ? $team->email : null) }}" type="text" id="email">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="phone">Phone</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Phone" name="phone" value="{{ old('phone', isset($team) ? $team->phone : null) }}" type="text" id="phone">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($team) ? $team->details : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
			Image size: {{ config('image.thumb.0') }}X{{ config('image.thumb.1') }}px
		</div>
	</div>
</div>