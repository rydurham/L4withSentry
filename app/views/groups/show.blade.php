@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
View Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="twelve columns">
		<h4>{{ $group['name'] }} Group Details</h4>
	    <h5>Permsissions</h5>
	    <div class="well">
	        {{ var_dump($groupPermissions) }}
	    </div>
	</div>
</div>
<div class="row">
	<div class="twelve columns">

	    <h5>Group Object</h5>
	    <div class="well">
	        {{ var_dump($group) }}
	    </div>
	</div>
</div>

@stop