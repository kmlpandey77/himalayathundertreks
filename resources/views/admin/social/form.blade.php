<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('socials.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($social) ? $social->title : null) }}" type="text" id="title">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="class">Class</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Class" name="class" value="{{ old('class', isset($social) ? $social->class : null) }}" type="text" id="class">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="icon">Icon</label>
		<div class="col-sm-6">
			<select name="icon" id="icon" class="form-control">
				@foreach($data as $key => $value)
					<option value="{{ $value }}" {{ isset($social) && $social->icon == $value ? 'selected' : null }}>{{ $value }}</option>
				@endforeach()
			</select>
		</div>
		{{-- <div class="col-sm-6">
			<input class="form-control" placeholder="Icon" name="icon" value="{{ old('icon', isset($social) ? $social->icon : null) }}" type="text" id="icon">
		</div> --}}
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="link">Link</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Link" name="link" value="{{ old('link', isset($social) ? $social->link : null) }}" type="text" id="link">
		</div>
	</div>
</div>