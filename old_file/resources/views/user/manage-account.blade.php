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
<div class="inner-wrapper">
	<section role="main" class="content-body">	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div id="breadcrumbs">
					<a href="{{url('/')}}">Home</a>
					›
					<a href="how-to-create-account">Creating an Perfektpay Account</a>
					>
					<a href="verification">What is Perfektpay's Verification </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content articles">
								<div id="toggle">
								<h3>Managing Your Perfektpay Account</h3>
								<div>
								<a class="active" href="">Articles</a>
								</div>
								</div>
								<ul>
								<li class="article">
								<h4>
								<a href="deposit-id">Where Do I Find My Wallet Deposit ID?</a>
								</h4>
								<p>To find your wallet deposit ID: Log into your account Click on "Funding" at the top of the screen (not...</p>
								<div class="meta"> Feb 12, 2018 02:48PM UTC </div>
								</li>
								<li class="article">
								<h4>
								<a href="reset-password.php">How Do I Reset My Password?</a>
								</h4>
								<p>In the event you forget your password, you can request a password reset. Here's how: Go to Perfektpay.com ...</p>
								<div class="meta"> Feb 12, 2018 05:32PM UTC </div>
								</li>
								<li class="article">
								<h4>
								<a href="recover-username.php">How Do I Recover My Username?</a>
								</h4>
								<p>In the event you forget your username, contact help@Perfektpay.com with the subject line: "Username Inquiry" and pr...</p>
								<div class="meta"> Feb 12, 2018 02:40PM UTC </div>
								</li>
								<li class="article">
								<h4>
								<a href="update-email.php">How Do I Update My Email Address?</a>
								</h4>
								<p>Log on to your Perfektpay account and on the top right hand corner of the screen, click on "Account" -> "Setting...</p>
								<div class="meta"> Feb 12, 2018 02:51PM UTC </div>
								</li>
								<li class="article">
								<h4>
								<a href="how-to-close-account.php">How Do I Close My Account?</a>
								</h4>
								<p>Should you want to close your account for whatever reason, please email help@Perfektpay.com with "Account Closure R...</p>
								<div class="meta"> Feb 14, 2018 03:00PM UTC </div>
								</li>
								</ul>
								<div id="pagination"> </div>
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
    						<a class="why_itbit" href="trading"> Back to Perfektpay Trading Services </a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</section>
    </div>
@stop	