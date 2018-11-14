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
                            <h3>PerfektPay's AML Compliance Program</h3>                       
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
					›
					<a href="compliance">PerfektPay's AML Compliance Pr...    </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
					<div class="support-body">
						<div class="content article">
							<div class="title">
								<h3>PerfektPay's AML Compliance Program</h3>
								<!--<div class="meta">Last Updated: Feb 13, 2018 06:56PM UTC</div>-->
							</div>
							<div class="article-content">
								<p style="text-align: justify;" dir="ltr">
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; line-height: 22.3999996185303px; text-align: justify; white-space: pre-wrap;">PerfektPay has developed an Anti-Money Laundering ("AML") Compliance Program in order to comply with applicable laws and regulations relating to anti-money laundering in Hong Kong. PerfektPay has established Know Your Customer ("KYC") and Customer Identification Program ("CIP") procedures that comply with regulatory requirements and meet current industry standards regarding the verification of customers and beneficial owners.
									</span>
								</p>
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
    							<li>
    								<a href="">Email Us</a>
    							</li>
    								<li> Questions? Please contact us at support@perfektpay.com. </li>
    						</ul>
    					</div>
    					<br>
    					<a class="why_perfektpay" href="trading"> Back to PerfektPay Trading Services </a>
    				</div>
    			</div>
    		</div>
    	</div>
    	</section>
    </div>
@stop	