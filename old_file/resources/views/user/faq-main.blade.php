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
    			<div class="col-sm-8">
    				<div id="support-main">
    						<div class="support-body">
    							<div class="content dashboard">
    								<h3>Browse by Topic</h3>
    								<table width="100%" cellspacing="0">
    									<tbody>
    										<tr class="row1">
    										<td class="col1">
    										<div class="topic topic525554">
    										<h4>About Perfektpay</h4>
    										<ul>
    										<li>
    										<a href="faq-overview">Perfektpay Overview</a>
    										</li>
    										<li>
    										<a href="faq-why">Why should I use Perfektpay?</a>
    										</li>
    										<li>
    										<a href="faq-bitcoin">What is Bitcoin?</a>
    										</li>
    										<li>
    										<a href="compliance">Perfektpay's AML Compliance Program</a>
    										</li>
    										<li>
    										<a href="holidays">Perfektpay's Observed Holidays</a>
    										</li>
    										</ul>
    										</div>
    										<a class="view_all" href="aboutperfekt">View All</a>
    										</td>
    										<td class="col2">
    										<div class="topic topic736976">
    										<h4>Creating an Perfektpay Account</h4>
    										<ul>
    										<li>
    										<a href="faq-open">How Do I Open an Perfektpay Account?</a>
    										</li>
    										<li>
    										<a href="verification">What is Perfektpay's Verification Proces...</a>
    										</li>
    										<li>
    										<a href="accepted-documents">Accepted Documents for Non-US Individual...</a>
    										</li>
    										<li>
    										<a href="required-documents">Required Documents for Institutional Acc...</a>
    										</li>
    										<li>
    										<a href="how-long-verify">How Long Does the Verification Process T...</a>
    										</li>
    										</ul>
    										</div>
    										<a class="view_all" href="how-to-create-account">View All</a>
    										</td>
    										</tr>
    										<tr class="row2">
    										<td class="col1">
    										<div class="topic topic581542">
    										<h4>Managing Your Perfektpay Account</h4>
    										<ul>
    										<li>
    										<a href="deposit-id">Where Do I Find My Wallet Deposit ID?</a>
    										</li>
    										<li>
    										<a href="#">How Do I Reset My Password?</a>
    										</li>
    										<li>
    										<a href="recover-username">How Do I Recover My Username?</a>
    										</li>
    										<li>
    										<a href="update-email">How Do I Update My Email Address?</a>
    										</li>
    										<li>
    										<a href="how-to-close-account">How Do I Close My Account?</a>
    										</li>
    										</ul>
    										</div>
    										<a class="view_all" href="manage-account">View All</a>
    										</td>
    										<td class="col2">
    										<div class="topic topic736980">
    										<h4>Trading with Perfektpay</h4>
    										<ul>
    										<li>
    										<a href="start-Trading">How do I Start Trading?</a>
    										</li>
    										<li>
    										<a href="order-support">Which Order Types does Perfektpay Support?</a>
    										</li>
    										<li>
    										<a href="fee-structure">Perfektpay's Fee Structure</a>
    										</li>
    										<li>
    										<a href="trading-desk">How to Start Trading on the Perfektpay OTC Ag...</a>
    										</li>
    										<li>
    										<a href="faq-trade-history">How Do I View My Trading History?</a>
    										</li>
    										</ul>
    										</div>
    										<a class="view_all" href="trade-with">View All</a>
    										</td>
    										</tr>
    										<tr class="row3">
    											<td class="col1">
    												<div class="topic topic736975">
    													<h4>Depositing & Withdrawing Funds</h4>
    													<ul>
    														<li>
    															<a href="fund-my-account">How Do I Fund My Account?</a>
    														</li>
    														<li>
    															<a href="withdraw-my-funds">How Do I Withdraw My Funds?</a>
    														</li>
    														<li>
    															<a href="fiat-withdrawal-processing">Bitcoin & Fiat Withdrawal Processing...</a>
    														</li>
    														<li>
    															<a href="deposit-schedule-us">Fiat Deposit Schedule (US & Non-US C...</a>
    														</li>
    														<li>
    															<a href="#">US Customer Deposit & Withdrawal Ban...</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    											<td class="col2">
    												<div class="topic topic736978">
    													<h4>General Questions</h4>
    													<ul>
    														<li>
    															<a href="#">Are Customer Bitcoins Held in Multi-Sign...</a>
    														</li>
    														<li>
    															<a href="#">Does Perfektpay Support Bitcoin Forks?</a>
    														</li>
    														<li>
    															<a href="#">Can I Fund My Account with Perfektpay Using M...</a>
    														</li>
    														<li>
    															<a href="#">Why are Bitcoin Prices Different on Each...</a>
    														</li>
    														<li>
    														<a href="#">Does Perfektpay have a Bug Bounty Program?</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    										</tr>
    										<tr class="row4">
    											<td class="col1">
    												<div class="topic topic736984">
    													<h4>Common Issues</h4>
    													<ul>
    														<li>
    															<a href="#">Why Can't My Onboarding be Complete...</a>
    														</li>
    														<li>
    															<a href="#">I Didn't Receive My Verification Em...</a>
    														</li>
    														<li>
    															<a href="#">My 2FA is Not Syncing</a>
    														</li>
    														<li>
    															<a href="#">I Haven't Received My Bitcoin Withd...</a>
    														</li>
    														<li>
    															<a href="#">My Deposit Hasn't Been Applied to M...</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    											<td class="col2">
    											<div class="topic topic1112537">
    											<h4>Technical Issues</h4>
    											<ul>
    											<li>
    											<a href="#">Steps to Take if the Perfektpay Website Isn&#...</a>
    											</li>
    											<li>
    											<a href="#">How to Report an Perfektpay Website Issue to ...</a>
    											</li>
    											<li>
    											<a href="#">What to Do When ReCaptcha Isn't App...</a>
    											</li>
    											</ul>
    											</div>
    											<a class="view_all" href="#">View All</a>
    											</td>
    										</tr>
    										<tr class="row5">
    											<td class="col1">
    												<div class="topic topic1112133">
    													<h4>Security at Perfektpay</h4>
    													<ul>
    														<li>
    															<a href="#">How is Perfektpay's Security Unique?</a>
    														</li>
    														<li>
    															<a href="#">Will My Information Be Kept 	Private and ...</a>
    														</li>
    														<li>
    															<a href="#">What is 2FA and Why Do I Need it?</a>
    														</li>
    														<li>
    															<a href="#">How to Add 2FA to My Account</a>
    														</li>
    														<li>
    															<a href="#">How To Reset 2FA on My Account</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    											<td class="col2">
    												<div class="topic topic771272">
    													<h4>Perfektpay Trust</h4>
    													<ul>
    														<li>
    															<a href="#">What is a Trust Company and What Can it ...</a>
    														</li>
    														<li>
    															<a href="#">What is Perfektpay Trust?</a>
    														</li>
    														<li>
    															<a href="#">How are My Assets Protected in Case of a...</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    										</tr>
    										<tr class="row6">
    											<td class="col1">
    												<div class="topic topic736973">
    													<h4>Perfektpay's API</h4>
    													<ul>
    														<li>
    															<a href="#">What APIs Does Perfektpay Support?</a>
    														</li>
    														<li>
    															<a href="#">How Can I Get Access to the Perfektpay API?</a>
    														</li>
    														<li>
    															<a href="#">What is FIX API?</a>
    														</li>
    														<li>
    															<a href="#">What is REST API?</a>
    														</li>
    														<li>
    															<a href="#">Does Perfektpay Have a Market Data API?</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    											<td class="col2">
    												<div class="topic topic771140">
    													<h4>Tax Reporting FAQ</h4>
    													<ul>
    														<li>
    															<a href="#">What is Cost Basis, and Why is it Import...</a>
    														</li>
    														<li>
    															<a href="#">I Didn't Move Any Funds Out of the ...</a>
    														</li>
    														<li>
    															<a href="#">When Do I Need to File or Pay Taxes on B...</a>
    														</li>
    														<li>
    															<a href="#">How Do I File Bitcoin Income on My Tax R...</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    										</tr>
    										<tr class="row7">
    											<td class="col1">
    												<div class="topic topic736977">
    												<h4>Perfektpay Updates & Notices</h4>
    													<ul>
    														<li>
    															<a href="#">Weekly Client Website and API Maintenanc...</a>
    														</li>
    														<li>
    															<a href="#">Industry Alert</a>
    														</li>
    													</ul>
    												</div>
    												<a class="view_all" href="#">View All</a>
    											</td>
    										</tr>
    									</tbody>
    								</table>
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