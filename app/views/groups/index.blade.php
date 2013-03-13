@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')
<div class="span10 well">
  @if (Sentry::check())
    <p>You are a member of the following groups:</p>
  @else
    <h2>You are not logged in</h2>
  @endif
</div>

@stop