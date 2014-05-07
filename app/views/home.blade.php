@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('pages.helloworld')}}
@stop

{{-- Content --}}
@section('content')

<div class="jumbotron">
  <div class="container">
    <h1>{{trans('pages.helloworld')}}</h1>
    <p>{{trans('pages.description')}}</p>
  </div>
</div>

@if (Sentry::check() )
	<div class="panel panel-success">
		 <div class="panel-heading">
			<h3 class="panel-title"><span class="glyphicon glyphicon-ok"></span> {{trans('pages.loginstatus')}}</h3>
		</div>
		<div class="panel-body">
			<p><strong>{{trans('pages.sessiondata')}}:</strong></p>
			<pre>{{ var_dump(Session::all()) }}</pre>
		</div>
	</div>
@endif 
 
 
@stop