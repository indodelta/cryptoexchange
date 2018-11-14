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
                            <h3>What is 2FA and Why Do I Need it?</h3>                       
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
                    › What is 2FA and Why Do I Need ... 
                </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
									<div class="title">
									<h3>What is 2FA and Why Do I Need it?</h3>
									<div class="meta">Last Updated: Feb 27, 2018 07:02PM UTC</div>
									</div>
									<div class="article-content">
										<span style="font-size:14px;"><span style="text-align: justify; white-space: pre-wrap;">Two Factor Authentication - commonly referred to as "2FA" -&nbsp;is an auto-generated verification code used to enhance your account security and safety. In addition to your account username and password, you will be required to input the auto-generated verification code prior to a successful login.<br>
										Perfektpay requires all new accounts to use 2FA when signing up to ensure the highest security measures for users. Popular apps for 2FA include </span>Google Authenticator, Authy and Duo Mobile which can all be downloaded on your smartphone. For instructions on how to add 2FA when you're signing up for your account, click <a href="how_to_add_2fa"><span style="color:#0000FF;">here</span></a>.<br>
										<br>
										<span style="white-space: pre-wrap;">For more information on 2FA, please click<font color="#000000"><span style="white-space: pre-wrap;"> </span></font><a href="#"><span style="color:#0000FF;">here</span></a></span></span><span style="color: rgb(0, 0, 0); font-size: 14px; white-space: pre-wrap;">. </span><span style="font-size: 14px; white-space: pre-wrap;">Should you have any questions on 2FA, feel free to reach the Perfektpay support team at</span><span style="color: rgb(0, 0, 0); font-size: 14px; white-space: pre-wrap;"> </span><span style="font-size: 14px; white-space: pre-wrap;"><a href=""><span style="color:#0000FF;">support@perfektpay.com</span></a></span><span style="color: rgb(0, 0, 0); font-size: 14px; white-space: pre-wrap;"> </span><span style="font-size: 14px; white-space: pre-wrap;">with "2FA Question" as the subject.</span>
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

			