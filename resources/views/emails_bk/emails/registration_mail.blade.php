<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
			<p>Hello {{ $name }},<br>
			 Greetings</p>
			<!--<p>This is confirmation mail from {{config('app.name')}}.</p>-->
			<p>Click the link below to Verify your Email Address and Complete Verification:</p>
			<!--<p>Please follow the link below to complete the process:</p>-->
			
			<p><a href='{{$link}}'>click here</a></p>

			<p>Thanks for signing up and happy trading!</p>
			<p>Regards,<br>
			{{config('app.name')}} Team<br>
			<a href="https://www.perfektpay.com">https://www.perfektpay.com</a></p>
		</div>
	</body>
</html>