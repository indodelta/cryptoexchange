<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
			<p>Dear {{ $name }},</p>
			<p>This is welcome mail from {{config('app.name')}}.</p>
			<p>Please follow the link below for login:</p>
			
			<p><a href='{{$link}}'>click here</a></p>
			<br>
			<p>Sincerely,</p>
			<p>{{config('app.name')}} Team</p>
		</div>
	</body>
</html>