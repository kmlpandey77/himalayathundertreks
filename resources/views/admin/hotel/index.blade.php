@extends('admin.app')

@section('title')
Hotels
@endsection

@section('content')

<div class="add-new">
	<a href="{{ route('hotels.create') }}" class="btn btn-primary"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
</div>

<div class="content-table">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Image</th>
				<th>Name</th>
				<th>City</th>
				<th>Url</th>
				<th>Price</th>
				<th>Rating</th>
				<th>Created At</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="sortable">
			@foreach ($hotels as $hotel)			
			<tr>
				<td><img src="{{ asset('uploads/hotel/'.$hotel->image) }}" alt="{{ $hotel->name }}" width="80"></td>
				<td>{{ $hotel->name }}</td>
				<td>{{ $hotel->city ? $hotel->city->name : '-' }}</td>
				<td>{{ '/' . $hotel->slug }}</td>
				<td>{{ $hotel->price }}</td>
				<td>{{ $hotel->rating }}</td>
				<td>{{ $hotel->created_at->format('M d, Y') }}</td>
				<td class="text-right">					
					<a class="btn btn-primary btn-sm" href="{{ route('hotels.edit', $hotel->id) }}"><i class="lnr lnr-pencil"></i></a>
					<div class="pull-right" style="margin-left: 10px;"> 
						<form onsubmit="return confirm('Are you sure?')" action="{{ route('hotels.destroy', $hotel->id) }}" method="post">
							{{ method_field('DELETE') }}
							{{ csrf_field() }}
							<button type="submit" class="btn btn-danger btn-sm"><i class="lnr lnr-trash"></i></button>
						</form>
					</div>
				</td>
			</tr>			
			@endforeach
		</tbody>
	</table>
</div>
@endsection