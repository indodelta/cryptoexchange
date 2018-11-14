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
					<a href="manageaccount">Managing Your Perfektpay Account</a>
					>
					<a href="deposit-id">How Long Does the Verification... </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
								<div class="title">
								<h3>Where Do I Find My Wallet Deposit ID?</h3>
								<div class="meta">Last Updated: Feb 12, 2018 02:48PM UTC</div>
								</div>
								<div class="article-content">
								<p dir="ltr">
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">To find your wallet deposit ID:</span>
								</span>
								<br>
								</p>
								<ol dir="ltr">
								<li>
								<span style="font-size:14px;">Log into your account</span>
								</li>
								<li>
								<span style="background-color: transparent; white-space: pre-wrap; font-family: arial, helvetica, sans-serif; font-size: 14px;">Click on "Funding" at the top of the screen (note, this is the default landing page upon log in)</span>
								</li>
								<li>
								<span style="background-color: transparent; white-space: pre-wrap; font-family: arial, helvetica, sans-serif; font-size: 14px;">Select the wallet you wish to credit your funds to</span>
								</li>
								<li>
								<span style="background-color: transparent; white-space: pre-wrap; font-family: arial, helvetica, sans-serif; font-size: 14px;">Click on the "Deposit" button and your unique wallet deposit ID can be found in the popup box</span>
								</li>
								</ol>
								​
								<p dir="ltr">
								<span style="background-color: transparent; white-space: pre-wrap; font-family: arial, helvetica, sans-serif; font-size: 14px;">(Please note: Each wallet has a unique account number)</span>
								</p>
								<br>
								<span style="font-size:14px;">
								<span style="font-family:arial,helvetica,sans-serif;">
								<img style="width: 421px; height: 300px;" src="assets/images/depositID.png" alt="">
								</span>
								</span>
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
    						<a class="why_itbit" href="trading"> Back to Perfektpay Trading Services </a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</section>
    </div>
@stop	