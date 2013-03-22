@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Reset Password
@stop

{{-- Content --}}
@section('content')
<div class="well">
	<legend>Reset Password</legend>
	<form class="form-reset" action="{{ Request::fullUrl() }}" method="post">   
    	<input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
    	<p>
	    	{{{ $errors->first('email') }}}
	    	<input name="email" type="text" class="span3" placeholder="Email address">
	    </p>
    	<div class="form-actions"><button class="btn btn-primary" type="submit">Reset Password</button></div>
  </form>
</div>

@stop