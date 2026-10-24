@extends('admin.app')

@section('title')
Subscriber
@endsection

@section('content')

<hr>

<div class="content-table">
	@if (count($subscribers) > 0)		

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Email</th>
				<th>Created At</th>
			</tr>
		</thead>
		<tbody id="sortable">
			@foreach ($subscribers as $team)
			<tr id="">
				<td>{{ $team->email }}</td>
				<td>{{ $team->created_at->format('M d, Y') }}</td>				
			</tr>			
			@endforeach
		</tbody>
	</table>
	@else
	<p>Record not found.</p>
	@endif
</div>
@endsection
@section('script')

@endsection