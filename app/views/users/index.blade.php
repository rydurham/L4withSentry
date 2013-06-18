@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')

  @if (Sentry::check())
  	
    @if($user->hasAccess('admin'))
		<h4>Current Users:</h4>
		<div class="well">
			<table class="table">
				<thead>
					<th>User</th>
					<th>Status</th>
					<th>Options</th>
				</thead>
				<tbody>
					@foreach ($allUsers as $user)
						<tr>
							<td><a href="{{ URL::to('users/show') }}/{{ $user->id }}">{{ $user->email }}</a></td>
							<td>{{ $userStatus[$user->id] }} </td>
							<td><button class="btn" onClick="location.href='{{ URL::to('users/edit') }}/{{ $user->id}}'">Edit</button> <button class="btn" onClick="location.href='{{ URL::to('users/suspend') }}/{{ $user->id}}'">Suspend</button> <button class="btn action_confirm" href="{{ URL::to('users/delete') }}/{{ $user->id}}" data-token="{{ Session::getToken() }}" data-method="post">Delete</button></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
    @else 
		<h4>You are not an Administrator</h4>
    @endif
  @else
    <h4>You are not logged in</h4>
  @endif


@stop
