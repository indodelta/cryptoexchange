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
					<a href="how-to-close-account">How Do I Close My Account?  </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
								<div class="title">
								<h3>How Do I Close My Account?</h3>
								<div class="meta">Last Updated: Feb 14, 2018 03:00PM UTC</div>
								</div>
								<div class="article-content">
								Should you want to close your account for whatever reason, please email
								<a href="">
								<span style="color:#0000FF;">help@Perfektpay.com</span>
								</a>
								 with "Account Closure Request" as the subject for assistance from the Perfektpay support team. We will withdraw all the funds in your account upon its closure.
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