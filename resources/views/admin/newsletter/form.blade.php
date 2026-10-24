<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('newsletters.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
				<div class="col-sm-10">
					<input class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($newsletter) ? $newsletter->title : null) }}" type="text" id="title">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="type">Type</label>
				<div class="col-sm-10 mt-2">
					<input type="radio" name="type" value="plain" onclick="show_plain();" {{ isset($newsletter) && $newsletter->type == 'plain' ? "checked='checked'" : null }}> Plain &nbsp
					<input type="radio" name="type" value="html" onclick="show_html();" {{ isset($newsletter) && $newsletter->type == 'html' ? "checked='checked'" : null }}> HTML
				</div>
			</div>

			<div id="plain" style="display: none;">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($newsletter) ? $newsletter->details : null) }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
					<div class="col-sm-10">
						<input type="file" name="image">
					</div>
				</div>
			</div>

			<div id="html" style="display: none;">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label text-right" for="html_file">HTML File</label>
					<div class="col-sm-10">
						<input type="file" name="html_file">
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group row">
				<label class="col-sm-12 col-form-label" for="subscriber_group">Subscriber Group</label>
				<div class="col-sm-12">
					@foreach($subscriber_groups as $sub_group)
					<label class="">
						<input type="checkbox" name="subscriber_groups[]"  value="{{ $sub_group->id }}" {{ isset($newsletter) && in_array($sub_group->id, $newsletter->subscriber_group_id) ? "checked='checked'" : null}}>
						{{ $sub_group->title }}
					</label>
					<br>
					@endforeach
					@if(count($subscriber_groups) > 0)
						<label class="">
							<input type="checkbox" name="all_subscribers" value="1">
							All
						</label>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@section('script')
	<script type="text/javascript">
		function show_plain(){
		  	document.getElementById('plain').style.display ='block';
		  	document.getElementById('html').style.display ='none';
		}

		function show_html(){
		  	document.getElementById('html').style.display ='block';
		  	document.getElementById('plain').style.display ='none';
		}
	</script>
@endsection