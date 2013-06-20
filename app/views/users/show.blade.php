@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')

  @if (Sentry::check())
	
	
  	<div class="row">
	    <div class="four columns">
	    	<h4>Account Profile</h4>
		    @if ($user->first_name)
		    	<p><strong>First Name:</strong> {{ $user->first_name }} </p>
			@endif
			@if ($user->last_name)
		    	<p><strong>Last Name:</strong> {{ $user->last_name }} </p>
			@endif
		    <p><strong>Email:</strong> {{ $user->email }}</p>
		    <div class="medium primary btn"><button type="button" onClick="location.href='{{ URL::to('users/edit') }}/{{ $user->id}}'">Edit Profile</button></div>
		</div>
		<div class="four columns">
			<h4>&nbsp;</h4>
			<p><em>Account created: {{ $user->created_at }}</em></p>
			<p><em>Last Updated: {{ $user->updated_at }}</em></p>
		</div>
		<div class="four columns">
		<h4>Group Memberships:</h4>
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
	</div>

	<div class="row">
		<div class="twelve columns">
		<h4>User Object</h4>
		    <div class="well">
		    	<p>{{ var_dump($user) }}</p>
		    </div>
		</div>
	</div>

  @endif


@stop
