@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('pages.actionedit')}} {{trans('groups.group')}}
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
	{{ Form::open(array('action' =>  array('GroupController@update', $group->id), 'method' => 'put')) }}
        <h2>{{trans('pages.actionedit')}} {{trans('groups.group')}}</h2>
    
        <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
            {{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => trans('groups.name'))) }}
            {{ ($errors->has('name') ? $errors->first('name') : '') }}
        </div>

        {{ Form::label(trans('groups.permisions')) }}
        <?php 
            $permissions = $group->getPermissions(); 
            if (!array_key_exists('admin', $permissions)) $permissions['admin'] = 0;
            if (!array_key_exists('users', $permissions)) $permissions['users'] = 0;
        ?>
        
        <div class="form-group">
            <label class="checkbox-inline">
                {{ Form::checkbox('adminPermissions', 1, $permissions['admin'] ) }} Admin
            </label>
            <label class="checkbox-inline">
                {{ Form::checkbox('userPermissions', 1, $permissions['users'] ) }} Users
            </label>
        </div>

        {{ Form::hidden('id', $group->id) }}
        {{ Form::submit(trans('pages.actionedit').' '.trans('groups.group'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    </div>
</div>

@stop