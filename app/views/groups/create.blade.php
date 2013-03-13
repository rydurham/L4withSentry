@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')
<div class="span3 well">
	<legend>New Group</legend>
	<form class="form-reset" action="/groups" method="post">   
    <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
    {{{ $errors->first('newGroup') }}}
    <input name="newGroup" type="text" class="span3" placeholder="New Group Name">
    <p>Permissions<p>
    	<label class="checkbox">
            <input type="checkbox" value="1" name="adminPermissions"> Admin
        </label>
    	<label class="checkbox">
            <input type="checkbox" value="1" name="userPermissions"> User
        </label>
    <button class="btn btn-primary" type="submit">Create New Group</button>
  </form>
</div>

@stop