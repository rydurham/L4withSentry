@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('users.forgot')}}
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'UserController@forgot', 'method' => 'post')) }}
            
            <h2>{{trans('users.forgotupword')}}</h2>
            
            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('users.email'), 'autofocus')) }}
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            {{ Form::submit(trans('users.resendpword'), array('class' => 'btn btn-primary'))}}

  		{{ Form::close() }}
  	</div>
</div>

@stop