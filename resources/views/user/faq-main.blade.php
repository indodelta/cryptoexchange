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
                            <h3>FAQ</h3>                       
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
    										<h4>About PerfektPay</h4>
    										<ul>
    										<li>
    										<a href="faq-overview">PerfektPay Overview</a>
    										</li>
    										<li>
    										<a href="faq-why">Why should I use PerfektPay?</a>
    										</li>
    										<li>
    										<a href="faq-bitcoin">What is Bitcoin?</a>
    										</li>
    										<li>
    										<a href="compliance">PerfektPay's AML Compliance Program</a>
    										</li>
    										<!--<li>
    										<a href="holidays">PerfektPay's Observed Holidays</a>
    										</li>-->
    										</ul>
    										</div><br>
    										<!--<a class="view_all" href="aboutperfekt">View All</a>-->
    										</td>
    										<td class="col2">
    										<div class="topic topic736976">
    										<h4>Creating a PerfektPay Account</h4>
    										<ul>
    										<li>
    										<a href="faq-open">How Do I Open an PerfektPay Account?</a>
    										</li>
    										<li>
    										<a href="verification">What is PerfektPay's Verification Process</a>
    										</li>
    										<li>
    										<a href="accepted-documents">Accepted Documents for verification</a>
    										</li>
    										<li>
    										<a href="required-documents">Required Documents for Institutional Accounts</a>
    										</li>
    										<li>
    										<a href="how-long-verify">How Long Does the Verification Process Takes</a>
    										</li>
    										</ul>
    										</div>
    										<!--<a class="view_all" href="how-to-create-account">View All</a>-->
    										</td>
    										</tr>
    										<tr class="row2">
    										<td class="col1">
    										<div class="topic topic581542">
    										<h4>Managing Your PerfektPay Account</h4>
    										<ul>
    										<!--<li>
    										<a href="deposit-id">Where Do I Find My Wallet Deposit ID?</a>
    										</li>-->
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
    										<!--<a class="view_all" href="manage-account">View All</a>-->
    										</td>
    										<td class="col2">
    										<div class="topic topic736980">
    										<h4>Trading with PerfektPay</h4>
    										<ul>
    										<li>
    										<a href="start-Trading">How do I Start Trading?</a>
    										</li>
    										<li>
    										<a href="order-support">Which Order Types does PerfektPay Support?</a>
    										</li>
    										<li>
    										<a href="fee-structure">PerfektPay's Fee Structure</a>
    										</li>
    										<!--<li>
    										<a href="trading-desk">How to Start Trading on the PerfektPay OTC Ag...</a>
    										</li>-->
    										<li>
    										<a href="faq-trade-history">How Do I View My Trading History?</a>
    										</li>
    										</ul>
    										</div>
    										<!--<a class="view_all" href="trade-with">View All</a>-->
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
    														<!--<li>
    															<a href="#">US Customer Deposit & Withdrawal Ban...</a>
    														</li>-->
    													</ul>
    												</div>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    											<td class="col2">
    												<div class="topic topic736978">
    													<h4>General Questions</h4>
    													<ul>
    														<!--<li>
    															<a href="#">Are Customer Bitcoins Held in Multi-Sign...</a>
    														</li>-->
    														<li>
    															<a href="support_bitcoin_forks">Does PerfektPay Support Bitcoin Forks?</a>
    														</li>
    														<!--<li>
    															<a href="#">Can I Fund My Account with PerfektPay Using M...</a>
    														</li>-->
    														<li>
    															<a href="why_are_bitcoin_prices_different">Why are Bitcoin Prices Different on Each...</a>
    														</li>
    														<!--<li>
    														<a href="#">Does PerfektPay have a Bug Bounty Program?</a>
    														</li>-->
    													</ul>
    												</div><br><br>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    										</tr>
    										<tr class="row4">
    											<td class="col1">
    												<div class="topic topic736984">
    													<h4>Common Issues</h4>
    													<ul>
    														<li>
    															<a href="why_can_t_my_onboarding_be_completed">Why Can't My Onboarding be Complete...</a>
    														</li>
    														<li>
    															<a href="i_didn_t_receive_my_verification_email">I Didn't Receive My Verification Em...</a>
    														</li>
    														<li>
    															<a href="my_2fa_is_not_syncing">My 2FA is Not Syncing</a>
    														</li>
    														<li>
    															<a href="i_haven_t_received_my_bitcoin_withdrawal">I Haven't Received My Bitcoin Withd...</a>
    														</li>
    														<li>
    															<a href="my_deposit_hasn_t_been_applied_to_my_account">My Deposit Hasn't Been Applied to M...</a>
    														</li>
    													</ul>
    												</div>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    											<td class="col2">
    											<div class="topic topic1112537">
    											<h4>Technical Issues</h4>
    											<ul>
    											<li>
    											<a href="website_isn_t_loading_correctly">Steps to Take if the PerfektPay Website Isn&#...</a>
    											</li>
    											<li>
    											<a href="how_to_report_an_perfekt">How to Report an PerfektPay Website Issue to ...</a>
    											</li>
    											<li>
    											<a href="recaptcha_isn_t_appearing">What to Do When ReCaptcha Isn't App...</a>
    											</li>
    											</ul>
    											</div><br><br>
    											<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    										</tr>
    										<tr class="row5">
    											<td class="col1">
    												<div class="topic topic1112133">
    													<h4>Security at PerfektPay</h4>
    													<ul>
    														<li>
    															<a href="s_security_unique">How is PerfektPay's Security Unique?</a>
    														</li>
    														<li>
    															<a href="file_bitcoin_income">Will My Information Be Kept Private and ...</a>
    														</li>
    														<li>
    															<a href="why_do_i_need_it">What is 2FA and Why Do I Need it?</a>
    														</li>
    														<li>
    															<a href="how_to_add_2fa">How to Add 2FA to My Account</a>
    														</li>
    														<li>
    															<a href="how_to_reset_2fa">How To Reset 2FA on My Account</a>
    														</li>
    													</ul>
    												</div>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    											<td class="col2">
    												<div class="topic topic736977">
    												<h4>PerfektPay Updates & Notices</h4>
    													<ul>
    														<li>
    															<a href="weekly_client">Weekly Client Website and API Maintenanc...</a>
    														</li>
    														<li>
    															<a href="industry_alert">Industry Alert</a>
    														</li>
    													</ul>
    												</div><br><br><br>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    										</tr>
    										<tr class="row6">
    											<td class="col1">
    												<div class="topic topic736973">
    													<h4>PerfektPay's API</h4>
    													<ul>
    														<li>
    															<a href="apis_perfektpay_support">What APIs Does PerfektPay Support?</a>
    														</li>
    														<li>
    															<a href="get_access_to_the_perfektpay_api">How Can I Get Access to the PerfektPay API?</a>
    														</li>
    														<li>
    															<a href="what_is_fix_api">What is FIX API?</a>
    														</li>
    														<li>
    															<a href="what_is_rest_api">What is REST API?</a>
    														</li>
    														<li>
    															<a href="have_a_market_data_api">Does PerfektPay Have a Market Data API?</a>
    														</li>
    													</ul>
    												</div>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    											<td class="col2">
    												<div class="topic topic771140">
    													<h4>Tax Reporting FAQ</h4>
    													<ul>
    														<li>
    															<a href="why_is_it_important">What is Cost Basis, and Why is it Import...</a>
    														</li>
    														<li>
    															<a href="move_any_funds">I Didn't Move Any Funds Out of the ...</a>
    														</li>
    														<li>
    															<a href="need_to_file">When Do I Need to File or Pay Taxes on B...</a>
    														</li>
    														<li>
    															<a href="file_bitcoin_income">How Do I File Bitcoin Income on My Tax R...</a>
    														</li>
    													</ul>
    												</div><br>
    												<!--<a class="view_all" href="#">View All</a>-->
    											</td>
    										</tr>
    										<!--<tr class="row7">
    											<td class="col1">
    												<div class="topic topic736977">
    												<h4>PerfektPay Updates & Notices</h4>
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
    										</tr>-->
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
    								<li> Questions? Please contact us at support@perfektpay.com. </li>
    							</ul>
    						</div>
    						<br>
    						<a class="why_itbit" href="trading"> Back to PerfektPay Trading Services </a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</section>
    </div>
@stop	