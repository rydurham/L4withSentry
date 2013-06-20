<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title') 
			@show 
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="{{ asset('css/gumby.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">

		<!-- Modernizr -->
		<script src="{{ asset('js/libs/modernizr-2.6.2.min.js') }}"></script>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	
	</head>

	<body>
	
<!-- Navbar -->
<nav id="navbar-main-nav" class="navbar">
    <div class="row">

      <a href="#" gumby-trigger="#nav1 &gt; .row &gt; ul" class="toggle"><i class="icon-menu"></i></a>
     	<h1 class="four columns logo">
	      <a href="/">
	        <img gumby-retina="" src="http://gumbyframework.com/img/gumby_mainlogo.png">
	      </a>
	    </h1>
		@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
			<ul class="two columns">
				<li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ URL::to('/users') }}">Users</a></li>
				<li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ URL::to('/groups') }}">Groups</a></li>
			</ul>
		@endif

		@if (Sentry::check())
			<ul id="main-nav" class="three columns pull_right">
				<li {{ (Request::is('users/show/' . Sentry::getUser()->id) ? 'class="active"' : '') }}><a href="/users/show/{{ Sentry::getUser()->id }}">{{ Sentry::getUser()->email }}</a></li>
				<li><a href="{{ URL::to('users/logout') }}">Logout</a></li>
			</ul>

		@else
			<ul id="main-nav" class="three columns pull_right">
				<li {{ (Request::is('users/login') ? 'class="active"' : '') }}><a href="{{ URL::to('users/login') }}">Login</a></li>
				<li {{ (Request::is('users/register') ? 'class="active"' : '') }}><a href="{{ URL::to('users/register') }}">Register</a></li>
			</ul>
		@endif
    </div>
  </nav>


		<!-- Container -->

			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->


		<!-- ./ container -->

		<!-- Javascripts
		================================================== -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="{{ asset('js/libs/gumby.min.js') }}"></script>
		<script src="{{ asset('js/restfulizer.js') }}"></script> <!-- Thanks to Zizaco for this script:  http://zizaco.net  -->
		

	</body>
</html>
