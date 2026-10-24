<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('redirects.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="from_url">From</label>
		<div class="col-sm-6">
			<div class="input-group-prepend">
				<div class="input-group-text">{{ config('app.url') }}/</div>
				<input class="form-control" placeholder="" name="from_url" value="{{ old('from_url', isset($redirect) ? $redirect->from_url : null) }}" type="text" id="from_url">
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="to_url">To</label>
		<div class="col-sm-6">
			<div class="input-group-prepend">
				<div class="input-group-text">{{ config('app.url') }}/</div>
				<input class="form-control" placeholder="" name="to_url" value="{{ old('to_url', isset($redirect) ? $redirect->to_url : null) }}" type="text" id="to_url">
			</div>
		</div>
	</div>
</div>