<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('pages.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
		<div class="col-sm-8">
			<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($page) ? $page->title : null) }}"
			 type="text" id="title">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="parent_id">Parent</label>
		<div class="col-sm-3">
			<select class="form-control" name="parent_id" id="parent_id">
			<option value="0">None</option>
			@foreach ($parents as $parent)
			<option value="{{ $parent->id }}" {{ $parent->id == old('parent_id', isset($page) ? $page->parent_id : null ) ? 'selected="selected"' : null }}>{{ $parent->title }}</option>
			@endforeach
		</select>
		</div>
		<label class="col-sm-2 col-form-label text-right" for="menu">Menu</label>
		<div class="col-sm-3">
			@foreach($menus as $menu)
			<label class="">
				<input type="checkbox" name="menus[]"  value="{{ $menu->id }}"
				{{ is_array(old('menus', isset($page) ? $page->menus()->allRelatedIds()->toArray():null)) && in_array($menu->id, old('menus', isset($page) ? $page->menus()->allRelatedIds()->toArray():null)) ? 'checked=checked': null }} >
				{{ $menu->menu }}
			</label>
			<br>
			@endforeach
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($page) ? $page->details : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_title">Meta title</label>
		<div class="col-sm-10">
			<textarea class="col-md-8 form-control" rows="4" placeholder="Meta title" name="meta_title" id="meta_title">{{ old('meta_title', isset($page) ? $page->meta_title : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_description">Meta description</label>
		<div class="col-sm-10">
			<textarea class="col-md-8 form-control" rows="4" placeholder="Meta description" name="meta_description" id="meta_description">{{ old('meta_description', isset($page) ? $page->meta_description : null) }}</textarea>
		</div>

	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="meta_keyword">Meta keyword</label>
		<div class="col-sm-10">
			<textarea class="col-md-8 form-control" rows="4" placeholder="Meta keyword" name="meta_keyword" id="meta_keyword">{{ old('meta_keyword', isset($page) ? $page->meta_keyword : null) }}</textarea>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3 offset-sm-2">
			<div class="custom-control custom-checkbox mr-sm-2">
				<input type="checkbox" class="custom-control-input" id="status" name="status"  value="1" {{ old('status', isset($page) ? $page->status : 1) == 1 ? 'checked=checked' : null  }}>
				<label class="custom-control-label" for="status">Active</label>
			</div>
		</div>
	</div>
</div>