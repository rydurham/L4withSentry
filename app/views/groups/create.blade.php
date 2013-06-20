@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<form action="{{ URL::to('groups') }}" method="post">   
        {{ Form::token() }}

        <ul class="centered six columns">
            <h4>New Group</h4>

            <li class="field {{ ($errors->has('newGroup')) ? 'danger' : '' }}"><input type="text" name='newGroup' placeholder="New Group Name" class="text input" value="{{ Request::old('newGroup') }}"></li>
                {{ $errors->first('newGroup',  '<p class="form_error">:message</p>') }}

            <h5>Permissions: </h5>
            <li class="field">
                <label for="adminPermissions" class="checkbox">
                  <input type="checkbox" id="adminPermissions" name="adminPermissions">
                  <span></span> Admin
                </label>
                <label for="userPermissions" class="checkbox">
                  <input type="checkbox" id="userPermissions" name="userPermissions">
                  <span></span> User
                </label>
            </li>

            <div class="medium primary btn"><input type="submit" value="Create New Group" /></div>

        </ul>
    
    </form>
</div>

@stop