@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

<h4>Edit 
@if ($user->email == Sentry::getUser()->email)
	Your
@else 
	{{ $user->email }}'s 
@endif 

Profile</h4>
<div class="well">
	{{ Form::open(array(
        'action' => array('UserController@update', $user->id), 
        'class' => 'form-horizontal', 
        'role' => 'form'
        )) }}
        
        <div class="form-group {{ ($errors->has('firstName')) ? 'has-warning' : '' }}" for="firstName">
            {{ Form::label('edit_firstName', 'First Name', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('firstName', $user->firstName, array('class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'edit_firstName'))}}
            </div>
            {{ ($errors->has('firstName') ? $errors->first('firstName') : '') }}    			
    	</div>


        <div class="form-group {{ ($errors->has('lastName')) ? 'has-warning' : '' }}" for="lastName">
            {{ Form::label('edit_lastName', 'Last Name', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('lastName', $user->lastName, array('class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'edit_lastName'))}}
            </div>
            {{ ($errors->has('lastName') ? $errors->first('lastName') : '') }}                
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::submit('Submit Changes', array('class' => 'btn btn-primary'))}}
            </div>
      </div>
    {{ Form::close()}}
</div>

<h4>Change Password</h4>
<div class="well">
    {{ Form::open(array(
        'action' => array('UserController@update', $user->id), 
        'class' => 'form-inline', 
        'role' => 'form'
        )) }}
        
        <div class="form-group {{ $errors->has('oldPassword') ? 'has-warning' : '' }}">
        	{{ Form::label('oldPassword', 'Old Password', array('class' => 'sr-only')) }}
			{{ Form::password('oldPassword', array('class' => 'form-control', 'placeholder' => 'Old Password')) }}
    	</div>

        <div class="form-group {{ $errors->has('newPassword') ? 'has-warning' : '' }}">
        	{{ Form::label('newPassword', 'New Password', array('class' => 'sr-only')) }}
            {{ Form::password('newPassword', array('class' => 'form-control', 'placeholder' => 'New Password')) }}
    	</div>

    	<div class="form-group {{ $errors->has('newPassword_confirmation') ? 'has-warning' : '' }}">
        	{{ Form::label('newPassword_confirmation', 'Confirm New Password', array('class' => 'sr-only')) }}
            {{ Form::password('newPassword_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm New Password')) }}
    	</div>

        {{ Form::submit('Change Password', array('class' => 'btn btn-primary'))}}
	        	
      {{ ($errors->has('oldPassword') ? $errors->first('oldPassword') : '') }}
      {{ ($errors->has('newPassword') ?  $errors->first('newPassword') : '') }}
      {{ ($errors->has('newPassword_confirmation') ? $errors->first('newPassword_confirmation') : '') }}

      {{ Form::close() }}
  </div>

@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
<h4>User Group Memberships</h4>
<div class="well">
    <form class="form-horizontal" action="{{ URL::to('users/updatememberships') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}

        <table class="table">
            <thead>
                <th>Group</th>
                <th>Membership Status</th>
            </thead>
            <tbody>
                @foreach ($user->getGroups() as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>
                            <div class="switch" data-on-label="In" data-on='info' data-off-label="Out">
                                <input name="permissions[{{ $group->id }}]" type="checkbox" {{ ( $user->inGroup($group)) ? 'checked' : '' }} >
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="form-actions">
            <input class="btn-primary btn" type="submit" value="Update Memberships">
        </div> 
    </form>
</div>
@endif    

@stop