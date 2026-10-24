@extends('admin.app') 
@section('title')
Menus
@endsection

@section('actionbtn')
<a href="{{ route('menus.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-header">
		<form>
			<div class="form-group row mt-2 mb-2">
				<div class="col-sm-3">
					<input type="text" class="form-control form-control-sm" name="keyword" placeholder="Keyword" value="{{ request()->keyword }}">					
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-primary btn-sm"> Search </button>					
				</div>
			</div>
		</form>
	</div>
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>MenuID</th>
					<th>Menu</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($menus as $menu)
				<tr id="{{ $menu->id }}">
					<td>#{{ $menu->id }}</td>
					<td>{{ Str::limit($menu->menu, 35) }}</td>					
					<td>
						@if ($menu->status)
							<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" href="{{ route('menus.showhide', $menu->id) }}">
								<i class="lnr lnr-checkmark-circle"></i>
								Active
							</a>
						@else
							<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" href="{{ route('menus.showhide', $menu->id) }}">
								<i class="lnr lnr-cross-circle"></i>
								Draft
							</a>
						@endif 
					</td>
					<td class="text-right">
						<div class="ml-auto">
							<form onsubmit="return confirm('Are you sure?')" action="{{ route('menus.destroy', $menu->id) }}" method="post">
								{{ method_field('DELETE') }} {{ csrf_field() }}
								<a class="button button-secondary button-small button-square button-rounded" href="{{ route('menus.edit', $menu->id) }}"><i class="lnr lnr-pencil"></i></a>
								<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
							</form>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $menus->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection

@section('script')
@if(request()->filter)
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('menus.order') }}";
				$.ajax(url, {
					data: {
						'_token': "{{ csrf_token() }}",
						'order': "{{ (request()->filter == 'main_menu' ? 'menu_order' : (request()->filter == 'footer' ? 'footer_order' : 'order_by')) }}",
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