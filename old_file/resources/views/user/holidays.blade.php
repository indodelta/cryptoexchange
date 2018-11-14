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
					<a href="holidays">Perfektpay's Observed Holidays </a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="support-main">
						<div class="support-body">
							<div class="content article">
								<div class="title">
									<h3>Perfektpay's Observed Holidays</h3>
									<div class="meta">Last Updated: Feb 09, 2018 07:30PM UTC</div>
								</div>
								<div class="article-content">
									<div style="text-align: justify;">
									<span style="text-align: justify; color: rgb(67, 69, 70); font-family: Arial; font-size: 14px; line-height: 22.4px;">Please be advised that our office in New York will be closed during the public holidays listed in the table below. All deposit and withdrawal requests </span>
									<span style="text-align: justify; color: rgb(67, 69, 70); font-family: Arial; font-size: 14px;">will not be processed</span>
									<span style="text-align: justify; color: rgb(67, 69, 70); font-family: Arial; font-size: 14px; line-height: 22.4px; "> on these dates.</span>
									<br><br>
									<div style="text-align: justify;"> </div>
									<table cellspacing="1" cellpadding="1" border="0" style="width:500px;">
									<thead>
									<tr>
									<th bgcolor="#003466" scope="col">
									<span style="font-size: 14px; font-family: Arial; color:#fff; vertical-align: baseline; white-space: pre-wrap;">United States Holidays 2018</span>
									</th>
									<th bgcolor="#40BDE9" scope="col">
									<span style="font-size: 14px; font-family: Arial; color:#fff; vertical-align: baseline; white-space: pre-wrap;">Date</span>
									</th>
									</tr>
									</thead>
									<tbody>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">New Year's Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Jan 1</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Martin Luther King Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Jan 15</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Presidents' Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Feb 19</span>
									</td>
									</tr>
									<tr>
									<td>Good Friday</td>
									<td style="text-align: left;">March 30</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Memorial Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">May 28</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Independence Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">July 4</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Labor Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Sep 3</span>
									</td>
									</tr>
									<tr>
									<td>Columbus Day</td>
									<td style="text-align: left;">Oct 8</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Veterans Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Nov 11-12</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Thanksgiving Day</span>
									</td>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Nov 22</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Christmas Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Dec 25</span>
									</td>
									</tr>
									</tbody>
									</table>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;"> </span>
									<div style="text-align: justify;">
									<br>
									<span style="color: rgb(67, 69, 70); font-family: Arial; font-size: 14px; line-height: 22.4px; text-align: justify; white-space: pre-wrap;">Please be advised that our office in Singapore will be closed during the public holidays listed in the table below. All deposit and withdrawal requests </span>
									<span style="color: rgb(67, 69, 70); font-family: Arial; font-size: 14px; text-align: justify; white-space: pre-wrap;">will not be processed</span>
									<span style="color: rgb(67, 69, 70); font-family: Arial; font-size: 14px; line-height: 22.4px; text-align: justify; white-space: pre-wrap;"> on these dates.</span>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">
									<span style="font-family: arial, helvetica, sans-serif; font-size: 14px; line-height: 22.3999996185303px;">​</span>
									</span>
									<br>
									</div>
									<table cellspacing="1" cellpadding="1" border="0" style="width:500px;">
									<thead>
									<tr>
									<th bgcolor="#003466" scope="col">
									<span style="font-size: 14px; font-family: Arial; color: #fff; vertical-align: baseline; white-space: pre-wrap;">Singapore National Holidays 2018</span>
									</th>
									<th bgcolor="#40BDE9" scope="col">
									<span style="font-size: 14px; font-family: Arial; color:#fff; vertical-align: baseline; white-space: pre-wrap;">Date</span>
									</th>
									</tr>
									</thead>
									<tbody>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">New Year's Day </span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Jan 1</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Chinese New Year</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Feb 15-16</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Good Friday</span>
									</td>
									<td style="text-align: left;">March 30</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Labour Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">May 1</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Vesak Day</span>
									</td>
									<td style="text-align: left;">
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Hari Raya Puasa</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">June 15</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">National Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Aug 9</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Hari Raya Haji</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Aug 22</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Deepavali</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Nov 6</span>
									</td>
									</tr>
									<tr>
									<td>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Christmas Day</span>
									</td>
									<td style="text-align: left;">
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;">Dec 25</span>
									</td>
									</tr>
									</tbody>
									</table>
									<span style="font-size: 14px; font-family: Arial; color: rgb(67, 69, 70); vertical-align: baseline; white-space: pre-wrap;"> </span>
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