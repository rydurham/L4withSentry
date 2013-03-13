@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Change Password
@stop

{{-- Content --}}
@section('content')
<div class="span3 well">
	<legend>Change Password</legend>
	<form class="form-signin" action="{{ Request::fullUrl() }}" method="post">
        
        <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
        <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
    		{{{ $errors->first('oldPassword') }}}
    		<input name="oldPassword" value="" type="password" class="span3" placeholder="Old Passord">

        	{{{ $errors->first('newPassword') }}}
	        <input name="newPassword" type="password" class="span3" placeholder="New Password">
	        
	        {{{ $errors->first('newPassword_confirmation') }}}
	        <input name="newPassword_confirmation" type="password" class="span3" placeholder="New Password Confirmation">
	        	
	        <button class="btn btn-primary" type="submit">Change Password</button>
	    </div>
      </form>
  </div>


@stop