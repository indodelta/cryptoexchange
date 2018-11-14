@extends('user.layouts.layout')
@section('content')
<link rel="stylesheet" href="assets/stylesheets/support.css">

<style>
    .row.top-bar-inner {
  display: none;
}
.content-body{
    MARGIN-TOP:60PX;
}
</style>

<div class="row top-bar">
	<div id="support-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="outer">
                        <div class="inner text-center" style="height: 30px; ">
                            <h3>How to Add 2FA to My Account</h3>                       
                        </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<div class="inner-wrapper">
	<section role="main" class="content-body">	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div id="breadcrumbs">
                    <a href="{{url('/')}}">Home</a>
                    › How to Add 2FA to My Account 
                </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
									<div class="title">
									<h3>How to Add 2FA to My Account</h3>
									<div class="meta">Last Updated: Feb 27, 2018 07:00PM UTC</div>
									</div>
									<div class="article-content">
										<span style="font-size:14px;"><span style="font-family:arial,helvetica,sans-serif;"><strong>Please follow the below steps to obtain your 2FA authentication code:</strong></span></span><br>
								&nbsp;
								<ol>
									<li><span style="font-size:14px;"><span style="font-family:arial,helvetica,sans-serif;">Install either Google Authenticator, Authy or Duo Mobile on your smartphone or tablet</span></span></li>
									<li><span style="font-size:14px;"><span style="font-family:arial,helvetica,sans-serif;">Logon to your Perfektpay account</span></span></li>
									<li><span style="font-size:14px;"><span style="font-family:arial,helvetica,sans-serif;">Use the authenticator app on your phone to scan the QR code on your screen OR Input the verification code generated below the QR code and click OK</span></span></li>
								</ol>
								<br>
								<span style="font-size:14px;"><span style="font-family:arial,helvetica,sans-serif;">We strongly encourage to have 2FA on your mobile device (i.e. cellphone, tablet) for security reason. However, you can also install a desktop version of Authy. To do so, <a href="#"><span style="color:#0000FF;">click here</span></a>.</span></span>
									  </div>
									
									
									<div id="rate_article_container" style="">
    									<div id="rate_article">
        									<div>
            									<a class="rate_link" rel="nofollow" data-remote="true" data-method="post" href=""> Yes </a>
            									<span> I found this article helpful </span>
        									</div>
        									<div class="rate-link-down">
            									<a class="rate_link" rel="nofollow" data-remote="true" data-method="post" href=""> No</a>
            									<span> I did not find this article helpful </span>
        									</div>
    									</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-4">
    					<div id="support-side">
    						<div class="content">
    							<h3>Contact Us</h3>
    							<ul>
    								<li> </li>
    								<li>
    									<a href="">Email Us</a>
    								</li>
    								<li> Questions? Please contact us at help@Perfektpay.com. </li>
    							</ul>
    						</div>
    						<br>
    						<a class="why_perfektpay" href="trading"> Back to Perfektpay Trading Services </a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</section>
    </div>
@stop	

			