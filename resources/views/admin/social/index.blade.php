@extends('admin.app') 
@section('title')
Socials
@endsection

@section('actionbtn')
<a href="{{ route('socials.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Link</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($socials as $social)			
					<tr id="{{ $social->id }}">
						<td>{{ $social->title }}</td>
						<td>{{ $social->link }}</td>
						<td>{{ $social->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('socials.destroy', $social->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('socials.edit', $social->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{{-- {!! $socials->links('vendor.pagination.bootstrap-4') !!} --}}
	</div>
</div>
@endsection