<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
			<p>Dear admin,</p>
			<p>NAME : {{ $data['name'] }} </p>
			<p>EMAIL : {{ $data['email']}}</p>
			<p>PHONE NUMBER : {{ $data['ph_num']}}</p>
			<p>NATURE OF INQUIRY : {{$data['nature_inq']}}</p>
			<p>SUBJECT : {{ $data['subject']}}</p>
			<p>MESSAGE : {{$data['message']}}</p>
			
		</div>
	</body>
</html>