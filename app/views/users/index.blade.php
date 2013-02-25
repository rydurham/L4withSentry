@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Log In
@stop

{{-- Content --}}
@section('content')
<div class="span6 well">
  @if (Sentry::check())
    <h2>{{{ Sentry::getUser()->email }}}</h2>
    <p align="right"><a href="user/changepassword">Change Password</a></p>
    <p>{{ print_r(Sentry::getUser()) }}</p>
  @else
    <h2>You are not logged in</h2>
  @endif
</div>

@stop