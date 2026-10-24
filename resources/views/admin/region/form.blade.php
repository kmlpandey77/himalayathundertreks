<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('regions.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="activity_id">Activity</label>
		<div class="col-sm-3">
			<select class="form-control" name="activity_id" id="activity_id">
				<option value="">Select</option>
				@foreach ($destinations as $destination)
				<optgroup label = "{{ $destination->title }}">
					@foreach ($destination->activities as $activity)					
					<option value="{{ $activity->id }}" {{ $activity->id == old('activity_id', isset($region) ? $region->activity_id : null ) ? 'selected="selected"' : null }}>{{ $activity->title }}</option>
					@endforeach
				</optgroup>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($region) ? $region->title : null) }}" type="text" id="title">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($region) ? $region->details : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
			Image size: {{ config('image.trip_thumb.0') }}X{{ config('image.trip_thumb.1') }}px
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image_alt">Image Alt</label>
		<div class="col-sm-10">
			<input class="form-control" placeholder="Image Alt" name="image_alt"
				value="{{ old('image_alt', isset($region) ? $region->image_alt : null) }}" type="text"
				id="image_alt">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_title">Meta title</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta title" name="meta_title" id="meta_title">{{ old('meta_title', isset($region) ? $region->meta_title : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_description">Meta description</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta description" name="meta_description" id="meta_description">{{ old('meta_description', isset($region) ? $region->meta_description : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_keyword">Meta keyword</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta keyword" name="meta_keyword" id="meta_keyword">{{ old('meta_keyword', isset($region) ? $region->meta_keyword : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3 offset-sm-2">
			<div class="custom-control custom-checkbox mr-sm-2">
				<input type="checkbox" class="custom-control-input" id="status" name="status"  value="1" {{ old('status', isset($region) ? $region->status : 1) == 1 ? 'checked=checked' : null  }}>
				<label class="custom-control-label" for="status">Active</label>
			</div>
		</div>
	</div>
</div>