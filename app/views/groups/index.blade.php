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
			<th>Permissions</th>
			<th>Options</th>
		</thead>
		<tbody>
		@foreach ($allGroups as $group)
			<tr>
				<td>{{ $group->name }}</td>
				<td>{{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}</td>
				<td><button class="btn" onClick="location.href='{{ URL::to('groups') }}/{{ $group->id }}/edit'">Edit</button>
				 	<button class="btn action_confirm {{ ($group->id == 2) ? 'disabled' : '' }}" data-method="delete" href="{{ URL::to('groups') }}/{{ $group->id }}">Delete</button></td>
			</tr>	
		@endforeach
		</tbody>
	</table> 
	 <button class="btn btn-info" onClick="location.href='{{ URL::to('groups/create') }}'">New Group</button>
</div>
<!--  
	The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
	Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
-->
@stop

