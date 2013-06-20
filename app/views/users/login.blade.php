@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<form action="{{ URL::to('users/login') }}" method="post">   
        {{ Form::token(); }}
        
        <ul class="centered six columns">
            <h4>Login</h4>
                
                <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}"><input type="text" name='email' placeholder="E-mail" class="text input" value="{{ Request::old('email') }}"></li>
                {{ $errors->first('email',  '<p class="form_error">:message</p>') }}
                <li class="field {{ $errors->has('password') ? 'danger' : '' }}"><input type="password" name="password" placeholder="Password" class="password input"></li>
                {{ $errors->first('password',  '<p class="form_error">:message</p>') }}
                <li class="field">
                    <label for="rememberMe" class="checkbox">
                      <input type="checkbox" id="rememberMe" name="rememberMe" value="1">
                      <span></span> Remember Me
                    </label>
                </li>
                
                <div class="medium primary btn"><input type="submit" value="Log In" /></div>
                <div class="medium default btn"><button type="button" onClick="window.location='{{ URL::to('users/resetpassword') }}'">Forgot Password?</button></div>
                
        </ul>
  </form>
</div>

@stop
