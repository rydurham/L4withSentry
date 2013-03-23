@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')
<h4>Available Groups</h4>
<div class="well">
	<table class="table">
		<thead>
			<th>Name</th>
			<th>Options</th>
		</thead>
		<tbody>
		@foreach ($allGroups as $group)
			<tr>
				<td>{{ $group['name'] }}</td>
				<td>&nbsp;</td>
			</tr>	
		@endforeach
		</tbody>
	</table> 
	 <button class="btn btn-info" onClick="location.href='groups/create'">New Group</button>
</div>

@stop