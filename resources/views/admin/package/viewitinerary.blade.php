<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Change Order Itineray</h4>
</div>
<div class="modal-body" id="itinerarysortable">
	@foreach ($package->itineraries as $itineray)
		<p id="{{ $itineray->id }}"><b>{{ $itineray->day }}: </b> {{ $itineray->outline }}</p>
	@endforeach
  
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" id="saveItineraryOrder">Save Changes</button>
</div>

<script>
	$(function () {
		$( "#itinerarysortable" ).sortable();
		$('#saveItineraryOrder').on('click', function () {
			$('#jsModal').find('.modal-content').LoadingOverlay('show', {
				'text': 'saving ....'
			});
			var data = $( "#itinerarysortable" ).sortable('toArray')
			$.ajax("{{ route('packages.itineraryorder') }}", {
				type: 'POST',
				data:{
					package_id:"{{ $package->id }}",
					data: data,
				},
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success:function (response) {
					window.location.href = response;
				}
			});
		})
	});
</script>

