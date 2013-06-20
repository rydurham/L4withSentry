@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<form action="{{ URL::to('groups') }}/{{ $group['id'] }}" method="POST">   
        {{ Form::token() }}
        <input type="hidden" name="_method" value="PUT">

        <ul class="centered six columns">
            <h4>Edit Group</h4>
            
            <li class="field {{ ($errors->has('name')) ? 'danger' : '' }}"><input type="text" name='name' placeholder="Group Name" class="text input" value="{{ (Request::old('name')) ? Request::old('name') : $group['name'] }}"></li>
                {{ $errors->first('name',  '<p class="form_error">:message</p>') }}

            <h5>Permissions: </h5>
            <li class="field">
                <label for="adminPermissions" class="checkbox {{ (isset($group['permissions']['admin'])) ? 'checked' : '' }}">
                  <input type="checkbox" id="adminPermissions" name="adminPermissions" value="1">
                  <span></span> Admin
                </label>
                <label for="userPermissions" class="checkbox {{ (isset($group['permissions']['users'])) ? 'checked' : '' }}">
                  <input type="checkbox" id="userPermissions" name="userPermissions" value="1">
                  <span></span> User
                </label>
            </li>

            <div class="medium primary btn"><input type="submit" value="Save Changes" /></div>
        </ul>
  </form>
</div>

@stop