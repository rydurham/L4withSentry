@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'UserController@forgot', 'method' => 'post')) }}
            <h2>Forgot your Password?</h2>
            <div class="form-group">
                <input name="email" type="text" class="form-control" placeholder="Email" value="{{ Request::old('email') }}" autofocus>
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

    	<button class="btn btn-primary" type="submit">Send Instructions</button>
  </form>
</div>

@stop