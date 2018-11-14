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
					<a href="trade-with">Trading with Perfektpay</a>
					>
					<a href="fee-trade-history">How Do I View My Trading Histo... </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
								<div class="title">
								<h3>How Do I View My Trading History?</h3>
								<div class="meta">Last Updated: Feb 12, 2018 04:01PM UTC</div>
								</div>
								<div class="article-content">
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<strong>To view your trading history:</strong>
								</span>
								</span>
								<br>
								<ol>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">Log in to your Perfektpay account</span>
								</span>
								</span>
								</li>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">Hover over “Accounts” at the top right of the page</span>
								</span>
								</span>
								</li>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">Select "Trading History"</span>
								</span>
								</span>
								</li>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">In the top left corner, select the account that you wish to view (e.g., "Wallet")</span>
								</span>
								</span>
								</li>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">To download, click on the "Export selected to.csv" button in the upper right hand corner</span>
								</span>
								</span>
								<ul>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">​</span>
								</span>
								</span>
								<span style="font-size:14px;">
								<span style="font-family: arial, helvetica, sans-serif; white-space: pre-wrap;">Customers can view their trading history in a daily, weekly, monthly and yearly filtered format. If you wish to view the trade history on a specific date or range, click on dates highlighted in green.</span>
								</span>
								</li>
								</ul>
								</li>
								</ol>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">​​</span>
								</span>
								</span>
								<br>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">​</span>
								</span>
								</span>
								<div>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">
								<strong>Below is an explanation of each of the parameters located in the trade history field:</strong>
								</span>
								<br>
								</div>
								<ol>
								<li>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">
								<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;">​</span>
								</span>
								</span>
								<em>Date</em>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">: The time and date that the trade is executed (UTC / GMT)</span>
								</li>
								<li>
								<em>Instrument</em>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">: The currency pair that you are trading </span>
								</li>
								<li>
								<em>Direction</em>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">:  Buy or Sell order</span>
								</li>
								<li>
								<em>Currency 1</em>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">: The amount of XBT you wish to trade</span>
								</li>
								<li>
								<em>Currency 2</em>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">: The amount of fiat currency you spent or received for the trade </span>
								</li>
								<li>
								<em>Rate</em>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">: The price per XBT at which the trade was executed</span>
								</li>
								<li>
								<span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">
								<span style="vertical-align: baseline; background-color: transparent;">
								<em>Fee</em>
								: Values in brackets refer to trading rebates received for the trade.
								</span>
								</span>
								</li>
								</ol>
								<div>
								<br>
								<span style="font-family:arial,helvetica,sans-serif;">
								<span style="font-size:14px;">  </span>
								</span>
								</div>
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