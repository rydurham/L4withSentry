@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'UserController@store')) }}
            {{ Form::token(); }}
            <h2>Register New Account</h2>

            <div class="form-group">
                <input name="email" type="text" class="form-control" placeholder="Email" value="{{ Request::old('email') }}" autofocus>
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password">
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>

            <div class="form-group">
                <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
                {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
            </div>
            
            <button class="btn btn-primary" type="submit">Register</button>
        {{ Form::close() }}
    </div>
</div>


@stop