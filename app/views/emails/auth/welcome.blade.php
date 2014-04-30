<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{trans('pages.welcome')}}</h2>

		<p><b>{{trans('pages.user')}}:</b> {{{ $email }}}</p>
		<p>To activate your account, <a href="{{ URL::to('users') }}/{{ $userId }}/activate/{{ urlencode($activationCode) }}">click here.</a></p>
		<p>Or point your browser to this address: <br /> {{ URL::to('users') }}/{{ $userId }}/activate/{{ urlencode($activationCode) }}</p>
		<p>Thank you, <br />
			~The Admin Team</p>
	</body>
</html>