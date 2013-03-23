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
							<td><a href="/user/show/{{ $user->id }}">{{ $user->email }}</a></td>
							<td>Status</td>
							<td><button class="btn" onClick="location.href='/user/edit/{{ $user->id}}'">Edit User</button> <button class="btn" onClick="location.href='/#/{{ $user->id}}'">Suspend User</button></td>
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