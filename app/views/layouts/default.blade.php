<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title') 
			@show 
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Bootstrap 3.0: Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">

		<style>
		@section('styles')
			body {
				padding-top: 60px;
			}
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	
	</head>

	<body>
		

		<!-- Navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">L4 with Sentry</a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
	           <li {{ (Request::is('/') ? 'class="active"' : '') }}><a href="{{ URL::to('') }}">Home</a></li>
				@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
					<li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ URL::to('/users') }}">Users</a></li>
					<li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ URL::to('/groups') }}">Groups</a></li>
				@endif
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	            @if (Sentry::check())
				<li class="navbar-text">{{ Sentry::getUser()->email }}</li>
				<li class="divider-vertical"></li>
				<li {{ (Request::is('users/show/' . Sentry::getUser()->id) ? 'class="active"' : '') }}><a href="/users/show/{{ Sentry::getUser()->id }}">Account</a></li>
				<li><a href="{{ URL::to('users/logout') }}">Logout</a></li>
				@else
				<li {{ (Request::is('users/login') ? 'class="active"' : '') }}><a href="{{ URL::to('users/login') }}">Login</a></li>
				<li {{ (Request::is('users/register') ? 'class="active"' : '') }}><a href="{{ URL::to('users/register') }}">Register</a></li>
				@endif
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>
		<!-- ./ navbar -->

		<!-- Container -->
		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->
		</div>

		<!-- ./ container -->

		<!-- Javascripts
		================================================== -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/restfulizer.js') }}"></script> <!-- Thanks to Zizaco for this script:  http://zizaco.net  -->
		<!-- Bootstrap 3.0:  Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	</body>
</html>
