<table width="100%" align="center" style="border: solid 1px #ccc ; border-radius: 10px ; background-repeat: repeat-x ; background-color: #fff">
   <tbody><tr>
        <td align="left">
            <div style="color: #666666 ; font-size: 14px ; padding-left: 0px ; padding-bottom: 10px ; padding-right: 10px ; text-shadow: 0 1px 0 #ffffff ;">
         <div style="padding-top: 10px">
         <img src="{{URL('/resources/views/admin/email/images/logo.png')}}" alt="PerfektPay">
         </div>
      </div></td>
   </tr>
  
   <tr>
   <td align="left">
        <div style="position: relative ; color: #666666 ; font-size: 14px ; padding: 10px ; padding-bottom: 25px ; text-shadow: 0 1px 0 #ffffff">
        <br>
Hello {{ucfirst($data->first_name)}} {{ucfirst($data->last_name)}},         
<br><br>        
We have recevied a request to withdrawal <strong>{{$data->amount}} {{$currency}}</strong> from your perfektpay account to <strong>{{$data->address}}</strong>.
<br><br>
This withdrawal request was recived by our server at <strong>{{date("l, d M Y h:m:i e", strtotime($data->created_at))}}</strong>.
<br>
<br>
The holding period will end at <strong>{{date("l, d M Y h:m:i e", strtotime($data->created_at))}}</strong>, after which you will not be able to cancel this withdrawal request. The withdrawal will be sent to the blockchain within the next bussiness day.
<br>
<br>
<strong>Important:</strong> If you did not request this withdrawal, please log in to your perfektpay account, change your password, cancel the withdrawal and notify <strong>support@perfektpay.com</strong>
<br>
<br>

            <br>
            Kind Regards,
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
The information shared in this mail is may be confidential and/or privileged. If you are not the intended recipient, you are hereby notified that you have received this message in error; any review, dissemination, distribution, sharing or copying of this transmittal is strictly prohibited. If you have received this transmittal and/or attachment(s) in error, please notify the sender immediately by email and immediately delete this message and all of its attachments, without retaining any copies. Thank you.
         </div>
      </td>
   </tr>
</tbody></table>