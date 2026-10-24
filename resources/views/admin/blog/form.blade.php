<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('blogs.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($blog) ? $blog->title : null) }}" type="text" id="title">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="event_date">Event Date</label>
		<div class="col-sm-6">
			<input class="form-control datepicker" placeholder="Event Date" name="event_date" value="{{ old('event_date', isset($blog) ? $blog->event_date : null) }}" type="text" id="event_date">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($blog) ? $blog->details : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
			Image size: {{ config('image.default.0') }}X{{ config('image.default.1') }}px
		</div>
	</div>
</div>