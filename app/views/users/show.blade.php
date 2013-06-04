@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')

  @if (Sentry::check())
	<h4>Account Profile</h4>
	
  	<div class="well clearfix">
	    <div class="span7">
		    @if ($user->first_name)
		    	<p><strong>First Name:</strong> {{ $user->first_name }} </p>
			@endif
			@if ($user->last_name)
		    	<p><strong>Last Name:</strong> {{ $user->last_name }} </p>
			@endif
		    <p><strong>Email:</strong> {{ $user->email }}</p>
		    <button class="btn btn-info" onClick="location.href='{{ URL::to('users/edit') }}/{{ $user->id}}'">Edit Profile</button>
		</div>
		<div class="span4">
			<p><em>Account created: {{ $user->created_at }}</em></p>
			<p><em>Last Updated: {{ $user->updated_at }}</em></p>
		</div>
	</div>

	<h4>Group Memberships:</h4>
	<div class="well">
	    <ul>
	    	@if (count($myGroups) >= 1)
		    	@foreach ($myGroups as $group)
					<li>{{ $group['name'] }}</li>
				@endforeach
			@else 
				<li>No Group Memberships.</li>
			@endif
	    </ul>
	</div>

	<h4>User Object</h4>
	<div>
		<p>{{ var_dump($user) }}</p>
	</div>
  @endif


@stop
