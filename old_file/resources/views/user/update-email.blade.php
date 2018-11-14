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
					› 
					<a href="update-email">How Do I Update My Email Address...  </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
								<div class="title">
								<h3>How Do I Update My Email Address?</h3>
								<div class="meta">Last Updated: Feb 12, 2018 02:51PM UTC</div>
								</div>
								<div class="article-content">
								<span style="font-size:14px;">
								<span style="font-family:arial,helvetica,sans-serif;">
								Log on to your Perfektpay account and on the top right hand corner of the screen, click on "Account" -> "Settings". On the left of the screen, enter the new email address and click on the "Update" button. You will then be prompted to input two sets of verification codes within 20 minutes and click on the "Submit" button for the change to take effect.
								<br>
								<br>
								If you are experiencing an issue with your email address, you can write to us with more details at 
								<span style="vertical-align: baseline;">
								<a href="">
								<span style="color:#0000FF;">help@Perfektpay.com</span>
								</a>
								</span>
								<span style="color: rgb(17, 85, 204); vertical-align: baseline;"> </span>
								and put "Update My Email" in the subject box
								<span style="line-height: 20.8px;">. Our Perfektpay support team will respond to you within 24 hours.</span>
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