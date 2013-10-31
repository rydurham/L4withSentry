@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
View Group
@stop

{{-- Content --}}
@section('content')
<div class="span10 well">
	<h1>{{ $group['name'] }} </h1>
    <p>Permsissions:
        <br /> 
        {{ var_dump($groupPermissions) }}</p>

    <p>Var dump: <br />
        {{ var_dump($group) }}</p>
</div>

@stop