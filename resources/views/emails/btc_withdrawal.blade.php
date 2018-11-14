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

Hello [{{$name->first_name.'  '.$name->last_name}}]
<br>
<br>
We have received a request to withdraw {{$name->amount}} XBT from your perfektpay account to <strong> {{$name->address}}</strong>. <br>
This withdrawal request was received by our servers at <strong>{{date("l, d M Y h:m:i e")}}</strong><br>
The withdrawal will be posted to the blockchain within the next business day per the perfektpay withdrawal processing schedule.<br>
Important: If you did not request this withdrawal, please log in to your perfektpay account, change your password, cancel the withdrawal and notify <strong>support@perfektpay.com </strong><br>
Kind Regards,<br>
PerfektPay Team<br>

		</div>
		
	</td>
	</tr>
	<tr>
		<td align="left">
			<div style="position: relative ; color: #666666 ; font-size: 12px ; line-height: 20px ; padding: 10px ; text-shadow: 0 1px 0 #ffffff ; background-color: #f8f8f8 ; border-bottom-left-radius: 10px ; border-bottom-right-radius: 10px">
				© 2018 Perfekt Capital Limited. All Rights Reserved.
                <br>
                <br>
This message contains information that may be confidential and/or privileged. If you are not the intended recipient, you are hereby notified that you have received this transmittal in error; any review, dissemination, distribution or copying of this transmittal is strictly prohibited. If you have received this transmittal and/or attachment(s) in error, please notify the sender immediately by email and immediately delete this message and all of its attachments, without retaining any copies. Thank you.
			</div>
		</td>
	</tr>
</tbody></table>