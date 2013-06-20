@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="twelve columns">
		<h4>Available Groups</h4>
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
					<td class="table_center">{{ (isset($group['permissions']['admin'])) ? '<i class="icon-check"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-check"></i> Users' : ''}}</td>
					<td class="table_center">
						<div class="medium primary btn"><a href="{{ URL::to('groups') }}/{{ $group->id }}/edit/">Edit</a></div>
					 	<div class="medium primary btn {{ ($group->id == 2) ? 'disabled' : '' }}"><a href="{{ URL::to('groups') }}/{{ $group->id }}/{{ $group->id}}" class="action_confirm {{ ($group->id == 2) ? 'disabled' : '' }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</a></div>
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

