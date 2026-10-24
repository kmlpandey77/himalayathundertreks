<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('tripdates.index', $trip) }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="start">Start date</label>
		<div class="col-sm-6">
			<input class="form-control datepicker" placeholder="Start date" name="start" value="{{ old('start', isset($date) ? $date->start : null) }}" type="text" id="start">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="end">End date</label>
		<div class="col-sm-6">
			<input class="form-control deparute_date" placeholder="End date" name="end" value="{{ old('end', isset($date) ? $date->end : null) }}" type="text" id="end">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="price">Price</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Price" name="price" value="{{ old('price', isset($date) ? $date->price : null) }}" type="text" id="price">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="status">Status</label>
		<div class="col-sm-4">
			<select name="status" id="status" class="form-control">
				<option value="">Select</option>
				<option value="1" {{ old('status', isset($date) ? $date->status : 0) == 1 ? 'selected="selected"':null }}>Available</option>
				<option value="2" {{ old('status', isset($date) ? $date->status : 0) == 2 ? 'selected="selected"':null }}>Limited</option>
				<option value="3" {{ old('status', isset($date) ? $date->status : 0) == 3 ? 'selected="selected"':null }}>Closed</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-3 offset-2">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="is_fullmoon" id="is_fullmoon" value="1" {{ old('is_fullmoon', isset($date) ? $date->is_fullmoon : 0) == 1 ? 'checked=checked' : null  }}> Is Fullmoon?
				</label>
			</div>
		</div>
	</div>
</div>