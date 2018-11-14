<table width="100%" align="center" style="border: solid 1px #ccc ; border-radius: 10px ; background-repeat: repeat-x ; background-color: #fff">
	<tbody><tr>
        <td align="left">
            <div style="color: #666666 ; font-size: 14px ; padding-left: 0px ; padding-bottom: 10px ; padding-right: 10px ; text-shadow: 0 1px 0 #ffffff ;">
			<div style="padding-top: 10px">
			<img src="{{URL('/resources/views/emails/images/logo.png')}}" alt="PerfektPay">
			</div>
		</div></td>
   </tr>
  
	<tr>
	<td align="left">
        <div style="position: relative ; color: #666666 ; font-size: 14px ; padding: 10px ; padding-bottom: 25px ; text-shadow: 0 1px 0 #ffffff">
        <br>

Hello [{{$name->first_name.'  '  .$name->last_name}}]
<br>
There has been a failed attempt to access your PerfektPay account. The attempt failed during the username and password entry step.
<br><br>
The login attempt had the following details:<br> 
Time: <strong>{{date("l, d M Y h:m:i e")}}</strong> <br>
IP Address: <strong>{{ $_SERVER['REMOTE_ADDR']}} <?php $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])); ?> ({{$data['geoplugin_city'].','.$data['geoplugin_countryCode']}})</strong> <br>
Browser: <strong><?$browser = explode(" ",$_SERVER['HTTP_USER_AGENT']);
				$date_d=0;
				// dd($browser);
				foreach ($browser as $key => $value) {
					// var_dump(strpos($value, 'Gecko'));
						if(strpos($value, 'Gecko')===0){
							$date_d=isset($browser[++$key])?$browser[++$key]:'IE';
						}
					}	$date_d =str_replace("/"," ",$date_d);?>{{$date_d}}</strong><br>
<br>
If this attempt was made by you this email can be safely ignored.<br>
<br>
If you are having trouble with your account or have reason to believe it has been compromised, contact <strong>support@perfektpay.com</strong> <br>for assistance.<br>
Login failure<br>

            <br>
            Regards,
            <br>
            Perfektpay Team
		</div>
		
	</td>
	</tr>
	<tr>
		<td align="left">
			<div style="position: relative ; color: #666666 ; font-size: 12px ; line-height: 20px ; padding: 10px ; text-shadow: 0 1px 0 #ffffff ; background-color: #f8f8f8 ; border-bottom-left-radius: 10px ; border-bottom-right-radius: 10px">
				© 2018 Perfekt Capital Limited. All Rights Reserved.
                <br>
                <br>
The information shared in this mail is may be confidential and/or privileged. If you are not the intended recipient, you are hereby notified that you have received this message in error; any review, dissemination, distribution, sharing or copying of this transmittal is strictly prohibited. If you have received this transmittal and/or attachment(s) in error, please notify the sender immediately by email and immediately delete this message and all of its attachments, without retaining any copies. Thank you.
			</div>
		</td>
	</tr>
</tbody></table>