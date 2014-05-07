@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('groups.group')}}
@stop

{{-- Content --}}
@section('content')
<h4>{{ $group['name'] }}</h4>
<div class="well clearfix">
	<div class="col-md-10">
	    <strong>{{trans('groups.permisions')}}:</strong>
	    <ul>
	    	@foreach ($group->getPermissions() as $key => $value)
	    		<li>{{ ucfirst($key) }}</li>
	    	@endforeach
	    </ul>
	</div>
	<div class="col-md-2">
		<button class="btn btn-primary" onClick="location.href='{{ action('GroupController@edit', array($group->id)) }}'">{{trans('pages.actionedit')}}</button>
	</div> 
</div>
<hr />
<h4>Group Object</h4>
<div>
    {{ var_dump($group) }}
</div>

@stop
