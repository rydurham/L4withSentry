@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Hello World
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<h1>Hello World!</h1>
	<p>This is an example of <a href="https://github.com/laravel/laravel/tree/develop">Laravel 4</a> running with <a href="https://github.com/cartalyst/sentry">Sentry</a>, using the <a href="http://gumbyframework.com">Gumby CSS Framework</a>. 
	@if (Sentry::check()) 
		You are currently logged in.
	@endif
	</p>
</div>

@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
<div class="row">
	<h3>Admin Options</h3>
		 <div class="medium primary btn"><a href="{{ URL::to('users') }}">View Users</a></div>
		 <div class="medium primary btn"><a href="{{ URL::to('groups') }}">View Groups</a></div>
</div>
@endif 
 
 
@stop