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
                            <h3>Bitcoin & Fiat Withdrawal Processing Schedule</h3>                       
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
                    › Bitcoin & Fiat Withdrawal ...
                </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
									<div class="title">
									<h3>Bitcoin & Fiat Withdrawal Processing Schedule</h3>
									<!--<div class="meta">Last Updated: Mar 21, 2018 04:03PM UTC</div>-->
									</div>
									
									
									<div class="article-content">
									<p dir="ltr">
									<span style="font-size:16px;">
									<span style="font-family:arial,helvetica,sans-serif;">
									<span id="docs-internal-guid-c93b378e-7794-36f1-eb14-88da46aa58cc">
									<span style="vertical-align: baseline; background-color: transparent;">
									<strong>
									<span id="docs-internal-guid-c93b378e-7797-7943-42c5-87eda1483437">
									<span style="vertical-align: baseline;  background-color: transparent;">Bitcoin Withdrawal Requests</span><br>
									</span>
									</strong>
									</span>
									</span>
									</span>
									</span>
									<br>
									<span style="font-family:arial,helvetica,sans-serif;">
									<span style="font-size:14px;">
									<span style="vertical-align: baseline;background-color: transparent;">We process withdrawal requests a combined 6 times daily </span>
									</span>
									</span>
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">at our Hong Kong office </span>
									<span style="font-family: arial, helvetica, sans-serif;">
									<span style="font-size: 14px;">
									<span style="vertical-align: baseline; background-color: transparent;">on business days </span>
									</span>
									</span>
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">(excluding</span>
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap; line-height: 23.1111px;"> local public holidays)</span>
									<span style="font-family:arial,helvetica,sans-serif;">
									<span style="font-size:14px;">
									<span style="vertical-align: baseline; background-color: transparent;">
									<span style="line-height: 23.1111106872559px;">. </span>
									</span>
									</span>
									</span>
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; text-align: justify; white-space: pre-wrap;">Withdrawal requests will be broadcast to the blockchain according to the initiation period they were submitted by. </span>
									<span style="font-family:arial,helvetica,sans-serif;">
									<span style="font-size:14px;">
									<span style="vertical-align: baseline; background-color: transparent;">
									<span style="line-height: 23.1111106872559px;">For your convenience, the following schedule indicates these 6 processing periods.</span>
									</span>
									</span>
									</span>
									<br>
									</p>
									<table cellspacing="1" cellpadding="1" border="0">
									<thead>
									<tr><br>
									<th bgcolor="#BDBDBD" scope="col">
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; ">Withdrawal Requests Initiated by:</span>
									</th>
									<th bgcolor="#BDBDBD" scope="col">
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; ">Will be Broadcast to Blockchain by:</span>
									</th>
									</tr>
									</thead>
									<tbody>
									<tr>
									<td><br>
									<span style="font-size:14px;">
									<span style="font-family: arial, helvetica, sans-serif;">10:00 AM HKT</span>
									</span>
									</td>
									<td><br>
									<span style="font-size:14px;">
									<span style="font-family: arial, helvetica, sans-serif;">12:00 PM HKT</span>
									</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size:14px;">01:00 PM HKT</span>
									</td>
									<td>
									<span style="font-size:14px;">
									<span style="font-family: arial, helvetica, sans-serif;">03:00 PM HKT</span>
									</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size:14px;">04:00 PM HKT</span>
									</td>
									<td>
									<span style="font-size:14px;">06:00 PM HKT</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size:14px;">11:00 PM HKT</span>
									</td>
									<td>
									<span style="font-size:14px;">01:00 AM HKT</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size:14px;">02:00 AM HKT</span>
									</td>
									<td>
									<span style="font-size:14px;">04:00 AM HKT</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size:14px;">05:00 AM HKT</span>
									</td>
									<td>
									<span style="font-size:14px;">07:00 AM HKT</span>
									</td>
									</tr>
									</tbody>
									</table>
									<br>
									
									<div>
    									<span style="font-size:16px;">
        									<span style="font-family:arial,helvetica,sans-serif;">
            									<span id="docs-internal-guid-c93b378e-7797-7943-42c5-87eda1483437">
                									<span style="vertical-align: baseline; background-color: transparent;">
                								    	<b>Fiat Withdrawal Requests</b><br>
                									</span>
            									</span>
        									</span>
    									</span>
    									<br>
    									<span style="font-family:arial,helvetica,sans-serif;">
        									<span style="font-size:14px;">
            									<span id="docs-internal-guid-c93b378e-7797-7943-42c5-87eda1483437">
            								    	<span style="vertical-align: baseline; background-color: transparent;">Fiat withdrawal requests are processed twice daily </span>
            									</span>
        									</span>
    									</span>
    									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">on business days</span>
    									<span style="font-family:arial,helvetica,sans-serif;">
        									<span style="font-size:14px;">
        								    	<span style="vertical-align: baseline; white-space: pre-wrap; background-color: transparent;"> </span>
        								    	<span style="line-height: 25.6px;">(</span>
        									</span>
    									</span>
    									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">excluding</span>
    									<span style="font-family:arial,helvetica,sans-serif;">
        									<span style="font-size:14px;">
        									    <span style="line-height: 25.6px;"> </span>
        								    	<span style="white-space: pre-wrap; line-height: 23.1111px;">local public holidays). </span>
        									</span>
    									</span><br>
    									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; text-align: justify; white-space: pre-wrap;">Withdrawal requests will be bank instructed according to the initiation period they were submitted by.</span>
    									<br>
    									<br>
    									

        									<table cellspacing="1" cellpadding="1" border="0">
            									<thead>
                									<tr>
                    									<th bgcolor="#BDBDBD" scope="col">
                    								    	<span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">Withdrawal Requests Initiated by:</span>
                    									</th>
                    									<th bgcolor="#BDBDBD" scope="col">
                    								    	<span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">Bank Will be Instructed by:</span>
                    									</th>
                									</tr>
            									</thead>
            									<tbody>
                									<tr>
                    									<td>
                        									<span style="font-size:14px;">
                        									<span style="font-family: arial, helvetica, sans-serif;">10:00 AM HKT</span>
                        									</span>
                    									</td>
                    									<td>
                        									<span style="font-size:14px;">
                        									<span style="font-family: arial, helvetica, sans-serif;">12:00 PM HKT</span>
                        									</span>
                    									</td>
                									</tr>
                									<tr>
                    									<td>
                    									    <span style="font-size:14px;">04:00 PM HKT</span>
                    									</td>
                    									<td>
                    									    <span style="font-size:14px;">
                    									    <span style="font-family: arial, helvetica, sans-serif;">06:00 PM HKT</span>
                    									    </span>
                    									</td>
                									</tr>
            									</tbody>
        									</table>
        									<br>
        									<!--<u>
            									<span style="font-size: 14px;">
                									<span id="docs-internal-guid-c93b378e-7797-7943-42c5-87eda1483437">
                    									<span style="vertical-align: baseline; background-color: transparent;">
                    								    	<span style="line-height: 23.1111px;">U.S. hours:</span>
                    									</span>
                									</span>
        									    </span>
        									</u>-->
    									</div>
    									
    									<!--<span style="font-family:arial,helvetica,sans-serif;">  </span>
    									<table cellspacing="1" cellpadding="1" border="0">
    									<thead>
    									<tr>
    									<th bgcolor="#BDBDBD" scope="col">
    									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">Withdrawal Requests Initiated by:</span>
    									</th>
    									<th bgcolor="#BDBDBD" scope="col">
    									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; white-space: pre-wrap;">Bank Will be Instructed by:</span>
    									</th>
    									</tr>
    									</thead>
    									<tbody>
    									<tr>
    									<td>
    									<span style="font-size:14px;">
    									<span style="font-family: arial, helvetica, sans-serif; white-space: pre-wrap;">11:00am ET</span>
    									</span>
    									</td>
    									<td>
    									<span style="font-size:14px;">
    									<span style="font-family: arial, helvetica, sans-serif; white-space: pre-wrap;">12:00pm ET</span>
    									</span>
    									</td>
    									</tr>
    									<tr>
    									<td>
    									<span style="font-size:14px;">3:00pm ET</span>
    									</td>
    									<td>
    									<span style="font-size:14px;">
    									<span style="font-family: arial, helvetica, sans-serif; white-space: pre-wrap;">4:00pm ET</span>
    									</span>
    									</td>
    									</tr>
    									</tbody>
    									</table>-->
									</div>
									
									
									<!--<div id="rate_article_container" style="">
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
									</div>-->
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
    								<li> Questions? Please contact us at support@perfektpay.com. </li>
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

			