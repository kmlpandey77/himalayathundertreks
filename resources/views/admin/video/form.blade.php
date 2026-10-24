<div class="form-group">
	<label class="col-sm-2 control-label" for="title">Title</label>
	<div class="col-sm-6">
		<input class="col-md-4 form-control" placeholder="Title" name="title" value="{{ old('title', isset($video) ? $video->title : null) }}" type="text" id="title">
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="link">Link</label>
	<div class="col-sm-6">
		<input class="col-md-4 form-control" placeholder="Link" name="link" value="{{ old('link', isset($video) ? $video->link : null) }}" type="text" id="link">
	</div>
</div>