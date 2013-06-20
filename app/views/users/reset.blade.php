@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Reset Password
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<form action="{{ URL::to('users/resetpassword') }}" method="post">   
    	{{ Form::token() }}

        <ul class="centered six columns">
        <h4>Reset Password</h4>

         <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}"><input type="text" name='email' placeholder="E-mail" class="text input" value="{{ Request::old('email') }}"></li>
            {{ $errors->first('email',  '<p class="form_error">:message</p>') }}

        <div class="medium primary btn"><input type="submit" value="Reset Password"></div>

        </ul>
    </form>
</div>

@stop