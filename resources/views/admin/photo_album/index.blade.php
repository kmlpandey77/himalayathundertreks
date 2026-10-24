@extends('admin.app') 
@section('title')
Photo Albums
@endsection

@section('actionbtn')
<a href="{{ route('albums.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Package</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($albums as $album)			
					<tr id="{{ $album->id }}">
						<td>{{ $album->package->title }}</td>
						<td>{{ $album->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('albums.destroy', $album->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('albums.edit', $album->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection