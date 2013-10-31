@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')
<h4>New Group</h4>
<div class="well">
	<form class="form-horizontal" action="{{ URL::to('groups') }}" method="post">   
        {{ Form::token() }}
    
        <div class="control-group {{ ($errors->has('newGroup')) ? 'error' : '' }}" for="newGroup">
            <label class="control-label" for="newGroup">New Group</label>
            <div class="controls">
                <input name="newGroup" value="{{ Request::old("newGroup") }}" type="text" class="input-xlarge" placeholder="New Group">
                {{ ($errors->has('newGroup') ? $errors->first('newGroup') : '') }}
            </div>
        </div>

        <div class="control-group" for="permissions">
            <label class="control-label" for="permissions">Permissions</label>
            <div class="controls">
                <label class="checkbox inline">
                    <input type="checkbox" value="1" name="adminPermissions"> Admin
                </label>
                <label class="checkbox inline">
                    <input type="checkbox" value="1" name="userPermissions"> User
                </label>
            </div>
        </div>
        
        <div class="form-actions">
            <input class="btn btn-primary" type="submit" value="Create New Group"> 
        </div>
    </form>
</div>

@stop