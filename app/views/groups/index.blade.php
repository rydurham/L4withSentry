@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')
<div class="span10">
	<h2>Available Groups</h2>
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
</div>

@stop