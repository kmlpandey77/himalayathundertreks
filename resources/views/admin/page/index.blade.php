@extends('admin.app') 
@section('title')
Pages
@endsection

@section('actionbtn')
<a href="{{ route('pages.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
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
				<label class="col-sm-2 offset-2 col-form-label col-form-label-sm text-right">Filter</label>
				<div class="col-sm-3">
					<select name="filter" class="custom-select form-control-sm" onchange="this.form.submit()">
						<option value="0">All</option>
						@foreach ($parents as $parent)
							@if ($parent->child()->count() > 0)
							<option {{ request()->filter == $parent->id ? 'selected=selected' : null }} value="{{ $parent->id }}">{{ $parent->title }}</option>							
							@endif
						@endforeach
						<option {{ request()->filter == 'main_menu' ? 'selected=selected' : null }} value="main_menu">Main Menu</option>
						<option {{ request()->filter == 'footer' ? 'selected=selected' : null }} value="footer">Footer</option>
					</select>
				</div>
			</div>
		</form>
	</div>
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Parent</th>
					<th>Title</th>
					<th>Url</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($pages as $page)
				<tr id="{{ $page->id }}">
					<td>{{ $page->parent ? $page->parent->title : 'None' }}</td>
					<td>{{ Str::limit($page->title, 35) }}</td>
					<td>{{ $page->slug == 'home' ? '/' : '/' . Str::limit($page->slug, 35) }}</td>
					<td>
						@if ($page->status)
							<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" data-method="post" href="{{ route('pages.showhide', $page->id) }}">
								<i class="lnr lnr-checkmark-circle"></i>
								Active
							</a>
						@else
							<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" data-method="post" href="{{ route('pages.showhide', $page->id) }}">
								<i class="lnr lnr-cross-circle"></i>
								Draft
							</a>
						@endif 
					</td>
					<td class="text-right">
						<div class="ml-auto">
							<form onsubmit="return confirm('Are you sure?')" action="{{ route('pages.destroy', $page->id) }}" method="post">
								{{ method_field('DELETE') }} {{ csrf_field() }}
								<a class="button button-secondary button-small button-square button-rounded" href="{{ route('pages.edit', $page->id) }}"><i class="lnr lnr-pencil"></i></a>
								<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
							</form>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $pages->links('vendor.pagination.bootstrap-4') !!}
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
				url = "{{ route('pages.order') }}";
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