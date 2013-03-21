@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')

  @if (Sentry::check())
  	
    @if($user->hasAccess('admin'))
		<div class="span10 well">
			<h2>Current Users:</h2>
			<table class="table">
				<thead>
					<th>User</th>
				</thead>
				<tbody>
					@foreach ($allUsers as $user)
						<tr>
							<td>{{ $user->email }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
    @else 
		<div class="span10 well">
			<h1>You are not an Administrator</h1>
		</div>
    @endif
  @else
    <div class="span6 well">
    	<h2>You are not logged in</h2>
    </div>
  @endif


@stop