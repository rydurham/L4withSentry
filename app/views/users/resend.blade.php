@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Reset Password
@stop

{{-- Content --}}
@section('content')
<h4>Resend Activation</h4>
<div class="well">
	<form class="form-horizontal" action="{{ URL::to('users/resend') }}" method="post">   
    	{{ Form::token() }}
    	
		<div class="control-group {{ ($errors->has('email') ? 'error' : '') }}" for="email">
            <label class="control-label" for="email">E-mail</label>
            <div class="controls">
                <input name="email" id="email" value="{{ Request::old('email') }}" type="text" class="input-xlarge" placeholder="E-mail">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>
        </div>

    	<div class="form-actions">
    		<button class="btn btn-primary" type="submit">Resend Activation</button>
    	</div>
  </form>
</div>

@stop