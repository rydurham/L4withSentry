@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<div class="span3 well">
	<legend>Register New Account</legend>
	<form class="form-signin" action="{{ Request::fullUrl() }}" method="post">
        
        <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
        <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
        	<div class="controls">
        		{{{ $errors->first('email') }}}
        		<input name="email" value="{{ Request::old('email') }}" type="text" class="span3" placeholder="Email address">
        	</div>
        	{{{ $errors->first('password') }}}
	        <input name="password" type="password" class="span3" placeholder="Password">
	        
	        {{{ $errors->first('password_confirmation') }}}
	        <input name="password_confirmation" type="password" class="span3" placeholder="Password Confirmation">
	        	
	        <button class="btn btn-primary" type="submit">Register</button>
	    </div>
      </form>
  </div>


@stop