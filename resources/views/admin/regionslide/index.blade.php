@extends('admin.app') 
@section('title')
Slides - {{ $region->title }}
@endsection

@section('actionbtn')
<a href="{{ route('regions.index') }}" class="button button-secondary button-pill button-small"><i class="lnr lnr-arrow-left"></i> <span>Back</span></a>
<a href="{{ route('regionslides.create', $region->id) }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($slides as $slide)			
					<tr id="{{ $slide->id }}">
						<td><img src="{{ $slide->image_path }}" alt="{{ $slide->title }}" width="80"></td>
						<td>{{ $slide->title }}</td>
						<td>{{ $slide->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('regionslides.destroy', $slide->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('regionslides.edit', $slide->id) }}"><i class="lnr lnr-pencil"></i></a>
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