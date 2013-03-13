@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')
<div class="span3 well">
	<legend>Log In</legend>
	<form class="form-signin" action="{{ Request::fullUrl() }}" method="post">   
    <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
    {{{ $errors->first('email') }}}
    <input name="email" type="text" class="span3" placeholder="Email address">
    {{{ $errors->first('password') }}}
    <input name="password" type="password" class="span3" placeholder="Password">
    <label class="checkbox">
      <input type="checkbox" name="rememberMe" value="1"> Remember Me
    </label>
    <p align="right"><a href="/user/resetpassword">Forgot Password?</a></p>
    <button class="btn btn-primary" type="submit">Log In</button>
  </form>
</div>

@stop