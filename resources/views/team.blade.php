<div class="team">
	<div class="row">
		@if($team->image)
		<div class="col-sm-3 pt-4"> <img src="{{ $team->thumb() }}" alt="{{ $team->name }}" class="img-fluid"></div>
		@endif
		<div class="col-sm-{{ $team->image? 9:12}}">
			<h4>{{ $team->name }} <br> <small class="text-muted">{{ $team->position }}</small></h4>
			{!! $team->details !!}
		</div>
	</div>
</div>

<hr>