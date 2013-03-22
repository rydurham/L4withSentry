@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')
<div class="well">
	<legend>Log In</legend>
	<form class="form-signin" action="{{ Request::fullUrl() }}" method="post">   
    <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
    <p>{{{ $errors->first('email') }}}
    <input name="email" type="text" class="span3" placeholder="Email address"></p>
    <p>{{{ $errors->first('password') }}}
    <input name="password" type="password" class="span3" placeholder="Password"></p>
    <label class="checkbox">
      <input type="checkbox" name="rememberMe" value="1"> Remember Me
    </label>
    <div class="form-actions"><input class="btn btn-primary" type="submit" value="Log In"> <a href="/user/resetpassword">Forgot Password?</a></div>
  </form>
</div>

@stop