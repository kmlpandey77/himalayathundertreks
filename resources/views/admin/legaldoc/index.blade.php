@extends('admin.app') 
@section('title')
Legal Docs
@endsection

@section('actionbtn')
<a href="{{ route('legaldocs.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Name</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($legaldocs as $legaldoc)			
					<tr id="{{ $legaldoc->id }}">
						<td><img src="{{ $legaldoc->image_path }}" width="80" alt="{{ $legaldoc->name }}"></td>
						<td>{{ $legaldoc->name }}</td>
						<td>{{ $legaldoc->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('legaldocs.destroy', $legaldoc->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('legaldocs.edit', $legaldoc->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $legaldocs->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection

@section('script')
@if (request()->category)
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('legaldocs.order') }}";
				$.ajax(url, {
					data: {
						'_token': "{{ csrf_token() }}",
						'data':data
					},
					type: 'POST',
				});
			}
		});
	} );
</script>
@endif
@endsection