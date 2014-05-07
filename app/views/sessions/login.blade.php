@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
{{trans('pages.login')}}
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'SessionController@store')) }}

            <h2 class="form-signin-heading">{{trans('pages.login')}}</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('users.email'), 'autofocus')) }}
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('users.pword')))}}
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>
            
            <label class="checkbox">
                {{ Form::checkbox('rememberMe', 'rememberMe') }} {{trans('users.remember')}}?
            </label>
            {{ Form::submit(trans('pages.login'), array('class' => 'btn btn-primary'))}}
            <a class="btn btn-link" href="{{ route('forgotPasswordForm') }}">{{trans('users.forgot')}}?</a>
        {{ Form::close() }}
    </div>
</div>

@stop