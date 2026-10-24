<div class="form-group">
	<label class="col-sm-2 control-label" for="teamcategory_id">Category</label>
	<div class="col-sm-6">
		<select class="form-control" name="teamcategory_id" id="teamcategory_id">
			<option value="">Select Category</option>
			@foreach ($categories as $category)
			<option value="{{ $category->id }}" {{ $category->id == old('teamcategory_id', isset($team) ? $team->teamcategory_id : null ) ? 'selected="selected"' : null }}>{{ $category->title }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="name">Name</label>
	<div class="col-sm-6">
		<input class="col-md-4 form-control" placeholder="Name" name="name" value="{{ old('name', isset($team) ? $team->name : null) }}" type="text" id="name">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="position">Position</label>
	<div class="col-sm-6">
		<input class="col-md-4 form-control" placeholder="Position" name="position" value="{{ old('position', isset($team) ? $team->position : null) }}" type="text" id="position">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="email">Email</label>
	<div class="col-sm-6">
		<input class="col-md-4 form-control" placeholder="Email" name="email" value="{{ old('email', isset($team) ? $team->email : null) }}" type="text" id="email">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="phone">Phone</label>
	<div class="col-sm-6">
		<input class="col-md-4 form-control" placeholder="Phone" name="phone" value="{{ old('phone', isset($team) ? $team->phone : null) }}" type="text" id="phone">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="details">Details</label>
	<div class="col-sm-10">
		<textarea class="col-md-8 form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($team) ? $team->details : null) }}</textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="image">Image</label>
	<div class="col-sm-10">
		<input type="file" name="image" id="image">
		{{-- Image size: 900X400px --}}
	</div>
</div>