@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <form action="{{ URL::to('users/edit') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}
       
        <ul class="centered six columns">
        <h4>Edit 
        @if ($user->email == Sentry::getUser()->email)
            Your
        @else 
            {{ $user->email }}'s 
        @endif 
        Profile</h4>
        
            <li class="field {{ ($errors->has('firstName')) ? 'danger' : '' }}"><input type="text" name='firstName' placeholder="First Name" class="text input" value="{{ Request::old('firstName') }}"></li>
            {{ $errors->first('firstName',  '<p class="form_error">:message</p>') }}
            <li class="field {{ ($errors->has('lastName')) ? 'danger' : '' }}"><input type="text" name='lastName' placeholder="Last Name" class="text input" value="{{ Request::old('lastName') }}"></li>
            {{ $errors->first('lastName',  '<p class="form_error">:message</p>') }}
            <div class="small primary btn"><input type="submit" value="Submit Changes"></div>
            <div class="small default btn"><input type="reset" value="Reset"></div>            
        </ul>
        
    </form>
</div>

<div class="row">
	<form action="{{ URL::to('users/changepassword') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}

        <ul class="centered six columns">
            <h4>Change Password</h4>
            <li class="field {{ $errors->has('oldPassword') ? 'danger' : '' }}"><input type="password" name="oldPassword" placeholder="Old Password" class="password input"></li>
                {{ $errors->first('oldPassword',  '<p class="form_error">:message</p>') }}
            <li class="field {{ $errors->has('newPassword') ? 'danger' : '' }}"><input type="password" name="newPassword" placeholder="New Password" class="password input"></li>
                {{ $errors->first('newPassword',  '<p class="form_error">:message</p>') }}
            <li class="field {{ $errors->has('newPassword_confirmation') ? 'danger' : '' }}"><input type="password" name="newPassword_confirmation" placeholder="Confirm New Password" class="password input"></li>
                {{ $errors->first('newPassword_confirmation',  '<p class="form_error">:message</p>') }}
            <div class="small primary btn"><input type="submit" value="Change Password"></div>
            <div class="small default btn"><input type="reset" value="Reset"></div>        
        </ul>
      </form>
  </div>

@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))

<div class="row">
    <form action="{{ URL::to('users/updatememberships') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}
    
        <ul class="centered six columns">
            <h4>Group Memberships</h4>
            @foreach ($allGroups as $group)
                <li class="field">
                    <label for="permissions[{{ $group->id }}]" class="checkbox {{ ( $user->inGroup($group)) ? 'checked' : '' }}">
                      <input type="checkbox"  name="permissions[{{ $group->id }}]" {{ ( $user->inGroup($group)) ? 'checked="checked"' : '' }}>
                      <span></span> {{ $group->name }}
                    </label>
                </li>
            @endforeach
            <div class="small primary btn"><input type="submit" value="Update Memberships"></div>
        </ul>
    </form>
</div>
@endif    

@stop