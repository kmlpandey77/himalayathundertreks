@extends('admin.app') 
@section('title')
News
@endsection

@section('actionbtn')
<a href="{{ route('news.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Url</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($news as $new)			
					<tr id="{{ $new->id }}">
						<td><img src="{{ $new->image_path }}" alt="{{ $new->title }}" width="80"></td>
						<td>{{ $new->title }}</td>
						<td>{{ '/' . $new->slug }}</td>
						<td>{{ $new->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('news.destroy', $new->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('news.edit', $new->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $news->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection