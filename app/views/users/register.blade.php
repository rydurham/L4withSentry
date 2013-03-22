@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<div class="well">
	<legend>Register New Account</legend>
	<form class="form-signin" action="{{ Request::fullUrl() }}" method="post">
        
        <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
        <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
        	
    		<p>
    			{{{ $errors->first('email') }}}
    			<input name="email" value="{{ Request::old('email') }}" type="text" class="span3" placeholder="Email address">
    		</p>
        	
        	<p>	
        		{{{ $errors->first('password') }}}
	        	<input name="password" type="password" class="span3" placeholder="Password">
			</p>
	        
	        <p>
		        {{{ $errors->first('password_confirmation') }}}
		        <input name="password_confirmation" type="password" class="span3" placeholder="Password Confirmation">
		    </p>
	        	
	        <div class="form-actions"><button class="btn btn-primary" type="submit">Register</button></div>
	    </div>
      </form>
  </div>


@stop