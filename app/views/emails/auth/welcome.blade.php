<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Welcome</h2>

		<div>
			To activate your account, click here: {{ URL::to('user/activate', array($token)) }}.
		</div>
	</body>
</html>