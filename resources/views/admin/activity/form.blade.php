<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('activities.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="destination_id">Destination</label>
		<div class="col-sm-3">
			<select class="form-control" name="destination_id" id="destination_id">
				<option value="">None</option>
				@foreach ($destinations as $destination)
				<option value="{{ $destination->id }}" {{ $destination->id == old('destination_id', isset($activity) ? $activity->destination_id : null ) ? 'selected="selected"' : null }}>{{ $destination->title }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($activity) ? $activity->title : null) }}" type="text" id="title">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3 offset-sm-2">
			<div class="custom-control custom-checkbox mr-sm-2">
				<input type="checkbox" class="custom-control-input" id="show_in_menu" name="show_in_menu"  value="1" {{ old('show_in_menu', isset($activity) ? $activity->show_in_menu : null) == 1 ? 'checked=checked' : null  }}>
				<label class="custom-control-label" for="show_in_menu">Show in Main Menu</label>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="collapse" id="menu_title">
				<input type="text" name="menu_title" class="form-control" placeholder="Menu Title (optional)" value="{{ old('menu_title', isset($activity) ? $activity->menu_title : null) }}">
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($activity) ? $activity->details : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Thumb Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
			Image size: {{ config('image.activities_thumb.0') }}X{{ config('image.activities_thumb.1') }}px
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image_alt">Image Alt</label>
		<div class="col-sm-10">
			<input class="form-control" placeholder="Image Alt" name="image_alt"
				value="{{ old('image_alt', isset($activity) ? $activity->image_alt : null) }}" type="text"
				id="image_alt">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_title">Meta title</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta title" name="meta_title" id="meta_title">{{ old('meta_title', isset($activity) ? $activity->meta_title : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_description">Meta description</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta description" name="meta_description" id="meta_description">{{ old('meta_description', isset($activity) ? $activity->meta_description : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_keyword">Meta keyword</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="4" placeholder="Meta keyword" name="meta_keyword" id="meta_keyword">{{ old('meta_keyword', isset($activity) ? $activity->meta_keyword : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3 offset-sm-2">
			<div class="custom-control custom-checkbox mr-sm-2">
				<input type="checkbox" class="custom-control-input" id="status" name="status"  value="1" {{ old('status', isset($activity) ? $activity->status : 1) == 1 ? 'checked=checked' : null  }}>
				<label class="custom-control-label" for="status">Active</label>
			</div>
		</div>
	</div>
</div>