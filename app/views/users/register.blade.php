@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<form action="{{ URL::to('users/register') }}" method="post">
        {{ Form::token() }}
        
        <ul class="centered six columns">
        <h4>Register New Account</h4>

        <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}"><input type="text" name='email' placeholder="E-mail" class="text input" value="{{ Request::old('email') }}"></li>
            {{ $errors->first('email',  '<p class="form_error">:message</p>') }}
        <li class="field {{ $errors->has('password') ? 'danger' : '' }}"><input type="password" name="password" placeholder="Password" class="password input"></li>
            {{ $errors->first('password',  '<p class="form_error">:message</p>') }}
        <li class="field {{ $errors->has('password_confirmation') ? 'danger' : '' }}"><input type="password" name="password_confirmation" placeholder="Confirm Password" class="password input"></li>
            {{ $errors->first('password_confirmation',  '<p class="form_error">:message</p>') }}

        <div class="medium primary btn"><input type="submit" value="Register"></div>
        <div class="medium default btn"><input type="reset" value="Reset"></div> 
        </ul>

	</form>
</div>


@stop