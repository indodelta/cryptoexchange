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
Your PerfektPay account was accessed from a computer with the following details:
<br><br>
Time: <strong>{{date("l, d M Y h:m:i e")}}</strong>
<br>
IP Address: <strong>{{ $_SERVER['REMOTE_ADDR']}}</strong>
<br><br>
If this login attempt was made by you this email can be safely ignored.
<br>
If this login does not coincide with your records, you should change your password immediately. If you are having trouble with your account or have reason to believe it has been compromised, contact <strong>support@perfektpay.com</strong> for assistance.

<br>
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