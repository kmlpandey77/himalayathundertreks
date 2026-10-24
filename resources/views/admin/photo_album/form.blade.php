<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('albums.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="title">Album Title</label>
		<div class="col-sm-6">
			<select class="form-control" name="package_id" id="package_id">
				<option value="">None</option>
				@foreach($packages as $package)
					<option value="{{ $package->id }}" {{ isset($album) && $album->package_id == $package->id ? "selected='selected'" : null }}>{{ $package->title }}</option>
				@endforeach
			</select>
		</div>
	</div>

	@if (isset($album) && $album->photos->count() > 0)
		<hr>
		<div class="row">
			@foreach ($album->photos as $photo)
			<div class="col-sm-3">
				<div class="album-photo" style="margin-bottom: 30px;">
					<img src="{{ $photo->thumb_image }}" class="img-fluid" height="150">
					<input type="hidden" name="edit_image_id[]" value="{{$photo->id}}">
					<textarea class="form-control" name="edit_image_caption[]">{{$photo->caption}}</textarea>
					<a href="javascript:void(0)" class="btn btn-danger btn-block photo-delete" data-id="{{$photo->id}}"><span class="lnr lnr-cross-circle"></span> delete </a>
				</div>
			</div>
			@endforeach
		</div>
		<hr>
	@endif

	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="image">Image</label>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4"><input type="file" name="image[]" id="image1"></div>
				<div class="col-sm-8"><textarea name="image_caption[]" placeholder="Image caption (optional)" class="form-control"></textarea></div>
			</div>
			<div class="row">
				<div class="col-sm-4"><input type="file" name="image[]" id="image2"></div>
				<div class="col-sm-8"><textarea name="image_caption[]" placeholder="Image caption (optional)" class="form-control"></textarea></div>
			</div>
			<div class="row">
				<div class="col-sm-4"><input type="file" name="image[]" id="image3"></div>
				<div class="col-sm-8"><textarea name="image_caption[]" placeholder="Image caption (optional)" class="form-control"></textarea></div>
			</div>
			<div class="row">
				<div class="col-sm-4"><input type="file" name="image[]" id="image4"></div>
				<div class="col-sm-8"><textarea name="image_caption[]" placeholder="Image caption (optional)" class="form-control"></textarea></div>
			</div>
			<div class="row">
				<div class="col-sm-4"><input type="file" name="image[]" id="image5"></div>
				<div class="col-sm-8"><textarea name="image_caption[]" placeholder="Image caption (optional)" class="form-control"></textarea></div>
			</div>
		</div>
	</div>
</div>

@section('script')
	<script>
		$(function() {
			$('.photo-delete').click(function () {
				$(this).parent().parent().remove();
				id = $(this).data('id');
				url = "{{ route('albums.photodelete') }}"
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