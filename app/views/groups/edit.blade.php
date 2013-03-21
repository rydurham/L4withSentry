@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="span3 well">
	<legend>Edit Group</legend>
	<form class="form-reset" action="/groups/{{ $group['id'] }}" method="POST">   
    <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
    <input type="hidden" name="_method" value="PUT">
    {{{ $errors->first('newGroup') }}}
    <input name="newGroup" type="text" class="span3" placeholder="New Group Name" value={{ $group['name'] }}>
    <p>Permissions<p>
    	<label class="checkbox">
            <input type="checkbox" value="1" name="adminPermissions" @if ( isset($group['permissions']['admin']) ) checked @endif > Admin
        </label>
    	<label class="checkbox">
            <input type="checkbox" value="1" name="userPermissions"  @if ( isset($group['permissions']['user']) ) checked @endif> User
        </label>
    <button class="btn btn-primary" type="submit">Save Changes</button>
  </form>
</div>

@stop