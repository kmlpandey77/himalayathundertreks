<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('legaldocs.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="name">Name</label>
		<div class="col-sm-6">
			<input class="form-control" placeholder="Name" name="name" value="{{ old('name', isset($legaldoc) ? $legaldoc->name : null) }}" type="text" id="name">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="8" placeholder="Details" name="details" id="details">{{ old('details', isset($legaldoc) ? $legaldoc->details : null) }}</textarea>
		</div>
	</div>

	@if (isset($legaldoc) && $legaldoc->image)
		<div class="row">
			<label class="col-sm-2 col-form-label text-right"></label>
			<div class="col-sm-3">
				<div class="album-photo" style="margin-bottom: 30px;">
					<img src="{{ asset('uploads/legaldocs/'.$legaldoc->image) }}" class="img-fluid" height="150">
					{{-- <a href="javascript:void(0)" class="btn btn-danger btn-block photo-delete" data-id="{{$legaldoc->id}}"><span class="lnr lnr-cross-circle"></span> delete </a> --}}
				</div>
			</div>
		</div>
	@endif

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">	
			{{-- Image Size: {{ config('image.default.0') }}X{{ config('image.default.1') }}px	 --}}
		</div>
	</div>
</div>

@section('script')
	<script>
		$(function() {
			$('.photo-delete').click(function () {
				$(this).parent().parent().remove();
				id = $(this).data('id');
				url = "{{ route('legaldocs.photodelete') }}"
				$.ajax(url, {
					data: {
						id: id,
						_token: "{{csrf_token()}}",
					},
					type:'POST',
				});
			});
		});
	</script>
@endsection