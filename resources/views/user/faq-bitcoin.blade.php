@extends('user.layouts.layout')
@section('content')
<link rel="stylesheet" href="assets/stylesheets/support.css">

<style>
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
                            <h3>What is Bitcoin?</h3>                       
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
						<a href="faq-bitcoin">What is Bitcoin?</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div id="support-main">
						<div class="support-body">
							<div class="content article">
								<div class="title">
									<h3>What is Bitcoin?</h3>
									<!--<div class="meta">Last Updated: Feb 15, 2018 04:21PM UTC</div>-->
								</div>
								<div class="article-content" style="text-align:justify;">
									<p>
										<span style="font-size:14px;">Bitcoin is a type of digital currency based on cryptographic protocol that has gained widespread recognition and adoption, and is currently the largest digital currency as of 2018.
									<br>
									<br>
									The idea of digital monetary systems dates back to the early 1990s when several companies and programmers tried their hand at creating money meant to be exchanged virtually. Many of these early currencies struggled to find their footing due to insufficient technology, poor security features, lack of adoption and a slew of other issues. The cryptocurrency segment of the digital currency universe was created in 2009 with the invention of bitcoin by founder Satoshi Nakamoto.
									<br>
									<br>
									Bitcoin is a cryptocurrency and worldwide payment system.It is the first decentralized digital currency, as the system works without a central bank or single administrator.The network is peer-to-peer and transactions take place between users directly, without an intermediary.These transactions are verified by network nodes through the use of cryptography and recorded in a public distributed ledger called a blockchain. Bitcoin was invented by an unknown person or group of people under the name Satoshi Nakamoto and released as open-source software in 2009.

									<br><br>
									Bitcoins are created as a reward for a process known as mining. They can be exchanged for other currencies, products, and services. As of February 2015, over 100,000 merchants and vendors accepted bitcoin as payment.
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