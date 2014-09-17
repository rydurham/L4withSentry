@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('groups.create')}}
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
	{{ Form::open(array('action' => 'GroupController@store')) }}
        <h2>{{trans('groups.create')}}</h2>
    
        <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
            {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => trans('groups.name'))) }}
            {{ ($errors->has('name') ? $errors->first('name') : '') }}
        </div>

        {{ Form::label(trans('groups.permissions')) }}
        <div class="form-group">
            <label class="checkbox-inline">
                {{ Form::checkbox('adminPermissions', 1) }} Admin
            </label>
            <label class="checkbox-inline">
                {{ Form::checkbox('userPermissions', 1) }} User
            </label>

        </div>

        {{ Form::submit(trans('groups.create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    </div>
</div>

@stop