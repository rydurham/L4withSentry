@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Suspend User
@stop

{{-- Content --}}
@section('content')

<div class="row">


	<form action="{{ URL::to('users/suspend') }}/{{ $user->id }}" method="post">   
    	{{ Form::token() }}

        <ul class="centered six columns">
            <h4>Suspend {{ $user->email }}</h4>
            
            <li class="field {{ ($errors->has('suspendTime')) ? 'danger' : '' }}"><input type="text" name='suspendTime' placeholder="Minutes" class="text input" value="{{ Request::old('suspendTime') }}"></li>
                {{ $errors->first('suspendTime',  '<p class="form_error">:message</p>') }}

            <div class="medium primary btn"><input type="submit" value="Suspend User" /></div>
        </ul>
    	
  </form>
</div>

@stop