@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'UserController@resend', 'method' => 'post')) }}
        	<h2>Resend Activation Email</h2>
    		<div class="form-group">
                <input name="email" type="text" class="form-control" placeholder="Email" value="{{ Request::old('email') }}" autofocus>
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

        	<button class="btn btn-primary" type="submit">Resend</button>
        {{ Form::close() }}
    </div>
</div>

@stop