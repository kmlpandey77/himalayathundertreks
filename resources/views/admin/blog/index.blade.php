@extends('admin.app') 
@section('title')
Blogs
@endsection

@section('actionbtn')
<a href="{{ route('blogs.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					{{-- <th>Image</th> --}}
					<th>Title</th>
					<th>Url</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($blogs as $blog)			
					<tr id="{{ $blog->id }}">
						{{-- <td><img src="{{ $blog->thumb() }}" alt="{{ $blog->title }}"></td> --}}
						<td>{{ $blog->title }}</td>
						<td>{{ '/' . $blog->slug }}</td>
						<td>{{ $blog->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('blogs.destroy', $blog->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('blogs.edit', $blog->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $blogs->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection