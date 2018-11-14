<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
			<p>Hello {{ $name }},</p>
			<!--<p>This is welcome mail from {{config('app.name')}}.</p>-->
			<p>Welcome and thank you for Signing up. You can now trade on the most advanced Bitcoin Trading Platform.</p>
			<p>Please start off by securing your account with two-factor authentication and Complete your KYC Documents. This will help keep all your funds safe.</p>
			<p>Please follow the link below for login:</p>

			<p><a href='{{$link}}'>click here</a></p>

			<p>After that, you're ready to make your first deposit (USD or BTC) and start trading. Or, earn interest by providing liquidity to the traders on our platform. If you would like to send us USD or BTC, please verify your account first.</p>
			
			<p>If you have any questions, please be sure to check out our FAQ Support Center. If you still have questions, don't hesitate to contact us at <a href="mailto:support@perfektpay.com">support@perfektpay.com</a></p>
			
			<p>Thanks for signing up and happy trading!</p>
			
			<p>Regards,<br>
			{{config('app.name')}} Team<br>
			<a href="https://www.perfektpay.com">https://www.perfektpay.com</a></p>
		</div>
	</body>
</html>