<option value="">Select Activity</option>
@foreach ($activities as $activity)
<option value="{{ $activity->id }}">{{ $activity->title }}</option>
@endforeach