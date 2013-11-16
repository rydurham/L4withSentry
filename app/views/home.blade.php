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
  </div>
</div>

@if (Sentry::check() )
	<div class="panel panel-success">
		 <div class="panel-heading">
			<h3 class="panel-title"><span class="glyphicon glyphicon-pushpin">You are currently logged in.</h3>
		</div>
		<div class="panel-body">
			<p><strong>Session Data:</strong></p>
			<pre>{{ var_dump(Session::all()) }}</pre>
		</div>
	</div>
@endif 
 
 
@stop