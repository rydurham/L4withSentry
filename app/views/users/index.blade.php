@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
User Index
@stop

{{-- Content --}}
@section('content')
<div class="row">
  @if (Sentry::check())
  	
    @if($user->hasAccess('admin'))
		<div class="twelve columns">
		<h4>Current Users:</h4>
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
							<td class="table_center">{{ $userStatus[$user->id] }} </td>
							<td class="table_center">
								<div class="medium primary btn"><a href="{{ URL::to('users/edit') }}/{{ $user->id}}">Edit</a></div>
								<div class="medium primary btn"><a href="{{ URL::to('users/suspend') }}/{{ $user->id}}">Suspend</a></div>
								<div class="medium primary btn"><a href="{{ URL::to('users/delete') }}/{{ $user->id}}" class="action_confirm" data-token="{{ Session::getToken() }}" data-method="post">Delete</a></div>
							</td>
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
</div>

@stop
