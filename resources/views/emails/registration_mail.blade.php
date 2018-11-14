<table width="100%" align="center" style="border: solid 1px #ccc ; border-radius: 10px ; background-repeat: repeat-x ; background-color: #fff">
   <tbody>
      <tr>
         <td align="left">
            <div style="color: #666666 ; font-size: 14px ; padding-left: 0px ; padding-bottom: 10px ; padding-right: 10px ; text-shadow: 0 1px 0 #ffffff;">
               <div style="padding-top: 10px;">
                  <img src="{{URL('/resources/views/emails/images/logo.png')}}" alt="Perfektpay">
               </div>
            </div>
         </td>
      </tr>
      <tr>
         <td align="left">
            <div style="position: relative ; color: #666666 ; font-size: 14px ; padding: 10px ; padding-bottom: 25px ; text-shadow: 0 1px 0 #ffffff">
            	Hello <strong> {{ucfirst($name) }}</strong>,
               <br>
               Greetings
               <br>
               <br>
               Click the link below to Verify your Email Address and Complete Verification:
               <br>       
               <br>         
               <p><a href="{{$link}}" target="_other" rel="nofollow">click here</a></p>
               <br>
               Thanks for signing up and happy trading!
               <br>
               <br>
               Regards,
               <br>
               Perfektpay Team
               <br>
               <a href="https://www.perfektpay.com">https://www.perfektpay.com</a></p>
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
   </tbody>
</table>