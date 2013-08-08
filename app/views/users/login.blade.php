@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')
<h4>Login</h4>
<div class="well">
	<form class="form-horizontal" action="{{ URL::to('users/login') }}" method="post">   
        {{ Form::token(); }}

        <div class="control-group {{ ($errors->has('email')) ? 'error' : '' }}" for="email">
            <label class="control-label" for="email">E-mail</label>
            <div class="controls">
                <input name="email" id="email" value="{{ Request::old('email') }}" type="text" class="input-xlarge" placeholder="E-mail">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>
        </div>
    
       <div class="control-group {{ $errors->has('password') ? 'error' : '' }}" for="password">
            <label class="control-label" for="password">New Password</label>
            <div class="controls">
                <input name="password" value="" type="password" class="input-xlarge" placeholder="New Password">
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>
        </div>

        <div class="control-group" for"rememberme">
            <div class="controls">
                <label class="checkbox inline">
                    <input type="checkbox" name="rememberMe" value="1"> Remember Me
                </label>
            </div>
        </div>
    
        <div class="form-actions">
            <input class="btn btn-primary" type="submit" value="Log In"> 
            <a href="{{ URL::to('users/resetpassword') }}" class="btn btn-link">Forgot Password?</a>
        </div>
  </form>
</div>

@stop