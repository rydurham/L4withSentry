@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Hello World
@stop

{{-- Content --}}
@section('content')

<div class="jumbotron">
  <div class="container">
    <h1>Hello, world!</h1>
    <p>This is an example of <a href="https://github.com/laravel/laravel/tree/develop">Laravel 4</a> running with <a href="https://github.com/cartalyst/sentry">Sentry 2.0</a> and <a href="http://getbootstrap.com/">Bootstrap 3.0</a>.</p>

    @if (Sentry::check()) 
		<span class="glyphicon glyphicon-flag"></span> You are currently logged in.
	@endif

  </div>
</div>

@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
	<h4>Admin Options</h4>
	<div class="well">
		 <button class="btn btn-info" onClick="location.href='{{ URL::to('users') }}'">View Users</button>
		 <button class="btn btn-info" onClick="location.href='{{ URL::to('groups') }}'">View Groups</button>
	</div>
@endif 
 
 
@stop