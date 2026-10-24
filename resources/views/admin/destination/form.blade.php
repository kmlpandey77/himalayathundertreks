<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('destinations.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($destination) ? $destination->title : null) }}" type="text" id="title">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($destination) ? $destination->details : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
			Image size: {{ config('image.trip_slide.0') }}X{{ config('image.trip_slide.1') }}px
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_title">Meta title</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta title" name="meta_title" id="meta_title">{{ old('meta_title', isset($destination) ? $destination->meta_title : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_description">Meta description</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta description" name="meta_description" id="meta_description">{{ old('meta_description', isset($destination) ? $destination->meta_description : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_keyword">Meta keyword</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta keyword" name="meta_keyword" id="meta_keyword">{{ old('meta_keyword', isset($destination) ? $destination->meta_keyword : null) }}</textarea>
		</div>
	</div>
</div>