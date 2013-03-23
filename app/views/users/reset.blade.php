@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Reset Password
@stop

{{-- Content --}}
@section('content')
<h4>Reset Password</h4>
<div class="well">
	<form class="form-horizontal" action="{{ Request::fullUrl() }}" method="post">   
    	<input type="hidden" name="_token" id="_token" value="{{ Session::getToken() }}" />
    	
		<div class="control-group {{ ($errors->has('email')) ? 'error' : '' }}" for="email">
            <label class="control-label" for="email">E-mail</label>
            <div class="controls">
                <input name="email" id="email" value="{{ Request::old('email') }}" type="text" class="input-xlarge" placeholder="E-mail">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>
        </div>

    	<div class="form-actions">
    		<button class="btn btn-primary" type="submit">Reset Password</button>
    	</div>
  </form>
</div>

@stop