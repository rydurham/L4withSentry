@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')

  @if (Sentry::check())
  	<div class="span10 well">
	    <h2>{{{ Sentry::getUser()->email }}}</h2>
	    <p align="right"><a href="user/changepassword">Change Password</a></p>
	    <p>{{ print_r(Sentry::getUser()) }}</p>
	</div>
  @endif


@stop