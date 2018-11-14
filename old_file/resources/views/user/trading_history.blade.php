@extends('user.layouts.layout')
@section('content')
<style>
.input-group-addon {
  border: 0 none;
}
.input-group .form-control {
  border-color: #40bde9;
  border-radius: 7px !important;
}
#support-header {
  display: none;
}
.form-control::-moz-placeholder, input[type="text"]::-moz-placeholder {
  color: #fff;
}
</style>
<div class="inner-wrapper">
	<section role="main" class="content-body">
			<!-- start: page -->
					<?php
						if((is_array($skipped_notification) && in_array(1, $skipped_notification)) || isset($kyc_resp) && !empty($kyc_resp)){ ?>
							<div class="row">
								<div class="col-md-12">
									<section class="panel">
											<div class="col-sm-12 col-xs-12">
												<div class="right-wrapper">  
													<?php
													if(isset($skipped_notification) && !empty($skipped_notification)){
														foreach ($skipped_notification as $key => $skip_val){														
															if($key == "kyc_skipped" && $skip_val == 1){ ?>
																<div class="row notify-top-content">
																	<a href="kyc"><span>Please verify your kyc.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<span class="cross pull-right" style="cursor: pointer;" title="Dismiss">X</span>
																</div>
															<?php }else if($key == "auth_skipped" && $skip_val == 1){ ?>
																<div class="row notify-top-content">
																	<a href="g-security"><span>Secure your account with google authentication.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cross pull-right" style="cursor: pointer;" title="Dismiss">X</span>
																</div>
															<?php }
														}
													}
													if(isset($kyc_resp) && !empty($kyc_resp)){ 
														foreach ($kyc_resp as $kyc) { 
															 $kycmsg = "";
														        if($kyc_resp){
														           if($kyc['kyc_name'] == 1){
														            $doc = "'National Id'";
														           }else{
														            $doc = "'Address Proof'";
														           }
														           $kycmsg = "Your KYC ".$doc." document has been rejected.";
														        }
															?>
															<div class="row notify-top-content">
																<a href="settings"><span>{{$kycmsg}}</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cross pull-right" style="cursor: pointer;" title="Dismiss">X</span>
															</div>
															<?php
														}
													}	?>
												</div>
											</div>
										</header>
									</section>
								</div>
							</div>
					<?php } ?>
					
					
				
				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="col-xl-12 col-lg-12 ">
							<div class="row">
								<div class="no-padding no-shadow">
									<div class="col-sm-12">
										<div class="form-group">
										<br>
											<div class="col-md-3">
												<div class="input-daterange input-group" data-plugin-datepicker>
													<div class="date-celender">
													<input type="text" class="form-control light-blue-back " id="gata" name="start" placeholder="1/1/2017"   style="text-align: left !important;">
														<i class="fa fa-calendar calender-icon"></i>
													</div>
													<span class="input-group-addon">&nbsp;&nbsp;</span>
													<div class="date-celender">
														<input type="text" class="form-control light-blue-back " id="gata1" placeholder="1/1/2017" name="end" style="text-align: left !important;">
														<i class="fa fa-calendar calender-icon"></i>
													</div>
												</div>
											</div>
											
											<div class="col-md-4">
											<ul class="celender-date">
												<li>
													<a href="">1D</a>
												</li>
												<li>
													<a href="">1W</a>
												</li>
												<li>
													<a href="">1M</a>
												</li>
												<li>
													<a href="">1Y</a>
												</li>
											</ul><br>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="row">
						<div class="col-lg-12 col-md-12">
							<section class="panel inner-panel">
								<header class="panel-heading bottom-border" style="">
										<h2 class="panel-title side-content">Transaction<!-- Transaction 2018-01-22 through 2018-01-22 --></h2>
										<div class="panel-right">
											<button class="btn light-blue-back">Export Selected To .CSV</button>
										</div>
								</header>
								<div class="panel-body no-padding">
									<div class="table-responsive">
										<table class="table table-striped mb-none orders">
												<thead>
													<tr class="bottom-border">
														<th>Date</th>
														<th>Side</th>
														<th>Quantity</th>
														<th class="text-right">Limit Price</th>
														<th>Filled</th>
														<th>Remaining</th>
														<th class="text-right">Avg. Price</th>
														<th class="text-center">Status</th>
													</tr>
												</thead>
												<tbody class="orders_body">
													<?php  if(isset($orders_detail) && !empty($orders_detail)){
															$i=0; 

															foreach ($orders_detail as $key => $odd_value) { 

																if($odd_value->status==0){
																	$status = "Open";
																}else if($odd_value->status==1){
																	$status = "Filled";
																}else if($odd_value->status==2){
																	$status = "Cancelled";
																}
																?>
																<tr>
																	<td>{{date("d-m-Y h:m:i", strtotime($odd_value->created_at))}}</td>
																	<td>{{$odd_value->side == 1?"Buy":"Sell"}}</td>
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value->quantity, 4, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value->limit_price, 2, '.', '')}}</td>
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value->filled, 4, '.', '')}}</td>
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value->remaining, 4, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value->avg_price, 2, '.', '')}}</td>
																	<td class="text-center"><?php if($odd_value->status==0){ ?><a href="cancel_order/{{Crypt::encrypt($odd_value->txn_id)}}" class="btn btn-danger per-button" title="Cancel Order">{{$status}}</a><?php }else{ echo $status; } ?></td>
																			
																		
																	
																</tr>
													<?php
															$i++;
														} 
													} else{ ?>
														<tr>
															<td class="text-center" colspan="9" style="padding-top:50px;padding-bottom:50px;">
																<img src="assets/images/empty.png"><br>
																<p>There is no order history to display.</p>
															</td>
														</tr>													
													<?php } ?>												
												</tbody>
											</table>
									</div>
									<div class="panel-body">
										@if(isset($orders_detail) && !empty($orders_detail))
										{{$orders_detail->appends(array_filter($_GET))->links()}}
										@endif
									</div>
								</div>
								
							</section>
						</div>
					</div>
				
			</div>
			@stop