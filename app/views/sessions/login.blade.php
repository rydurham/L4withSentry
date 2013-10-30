@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'SessionController@store')) }}
            {{ Form::token(); }}
            <h2 class="form-signin-heading">Sign In</h2>

            <div class="form-group">
                <input name="email" type="text" class="form-control" placeholder="Email" value="{{ Request::old('email') }}" autofocus>
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password">
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>
            
            <label class="checkbox">
                <input type="checkbox" value="rememberMe"> Remember me
            </label>
            <button class="btn btn-primary" type="submit">Sign in</button>
            <button class="btn btn-link" type="">Forgot Password</button>
        {{ Form::close() }}
    </div>
</div>

@stop