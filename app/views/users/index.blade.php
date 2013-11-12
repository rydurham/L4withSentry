@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')
<h4>Current Users:</h4>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>User</th>
				<th>Status</th>
				<th>Options</th>
			</thead>
			<tbody>
				@foreach ($users as $user)
					<tr>
						<td><a href="{{ action('UserController@show', array($user->id)) }}">{{ $user->email }}</a></td>
						<td>{{ $user->status }} </td>
						<td>
							<button class="btn btn-default" type="button" onClick="location.href='{{ action('UserController@edit', array($user->id)) }}'">Edit</button> 
							<button class="btn btn-default" type="button" onClick="location.href='{{ URL::to('users/suspend') }}/{{ $user->id}}'">Suspend</button> 
							<button class="btn btn-default action_confirm" href="{{ URL::to('users/delete') }}/{{ $user->id}}" data-token="{{ Session::getToken() }}" data-method="post">Delete</button></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
  </div>
</div>
@stop
