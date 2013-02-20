@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Log In
@stop

{{-- Content --}}
@section('content')
<div class="span3 well">
	<legend>Log In</legend>
	<form class="form-signin" action="users/register" method="post">
        
        <input name="email" type="text" class="span3" placeholder="Email address">
        <input name="password" type="password" class="span3" placeholder="Password">
        <label class="checkbox">
			<input type="checkbox" name="remember" value="1"> Remember Me
		</label>
        <button class="btn btn-primary" type="submit">Log In</button>
      </form>
  </div>

@stop