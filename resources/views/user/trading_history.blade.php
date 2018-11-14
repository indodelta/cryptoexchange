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
.icon-cel, .icon-cel1 {
  color: #fff;
  position: absolute;
  right: 15px;
  top: 12px;
  z-index: 4;
}
.input1 , .input2{
  position: relative;
}
.form-control.light-blue-back {
  text-align: left;
}
.table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td {
 border: 1px solid #ccc;
}
</style>
<div class="inner-wrapper">
	<section role="main" class="content-body">
	    <div class="container">
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
															if($key == "kyc_skipped" && $skip_val == 1){ 
																?>
																@if(Session::has("noti")&&(Session::get("noti")==0))
																<div class="row notify-top-content kyc">
																	<a href="kyc"><span>Please verify your kyc.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<span class="cross pull-right" style="cursor: pointer;" title="Dismiss">X</span>
																</div>
																@endif
															<?php }else if($key == "auth_skipped" && $skip_val == 1){ 
															
																?>
																@if(Session::has("noti2")&&(Session::get("noti2")==0))
																<div class="row notify-top-content google">
																	<a href="g-security"><span>Secure your account with google authentication.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cross pull-right" style="cursor: pointer;" title="Dismiss">X</span>
																</div>
																@endif
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
															@if(Session::has("noti")&&(Session::get("noti")==0))
															<div class="row notify-top-content kyc">
																<a href="settings"><span>{{$kycmsg}}</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cross pull-right" style="cursor: pointer;" title="Dismiss">X</span>
															</div>
															@endif
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
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
													<div class="form-group" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    	<span class="input-group-addon input1">
                                    <input type="text" class=" light-blue-back input-sm form-control" id="start_d" placeholder="mm/dd/yyyy" name="start" value="">	<i class="fa fa-calendar calender-icon icon-cel1"></i>
                                    </span>
                                    <span class="input-group-addon"></span>
                                    	<span class="input-group-addon input1">
                                    		<!-- {{isset($_GET['end_d'])?$_GET['end_d']:''}} -->
                                    <input type="text" class=" light-blue-back input-sm form-control" id="end_d" placeholder="mm/dd/yyyy" name="end" value=""><i class="fa fa-calendar calender-icon icon-cel1"></i>
                                    </span>
                                </div>
                            </div>
											</div>
											
											<div class="col-md-4">
											<ul class="celender-date">
												<li>
													<a href="#" id="day">1D</a>
												</li>
												<li>
													<a href="#" id="week">1W</a>
												</li>
												<li>
													<a href="#" id="month">1M</a>
												</li>
												<li>
													<a href="#" id="year">1Y</a>
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
							<section class="panel">
								<header class="panel-heading bottom-border" style="">
										<h2 class="panel-title side-content">Transaction<!-- Transaction 2018-01-22 through 2018-01-22 --></h2>
										<div class="panel-right">
											<a href="{{route('down_csv').'?start_d='.(isset($_GET['start_d'])?urlencode($_GET['start_d']):'').'&end_d='.(isset($_GET['end_d'])?urlencode($_GET['end_d']):'')}}">
											<button class="btn light-blue-back">Export Selected To .CSV</button></a>
										</div>
								</header>
								<div class="panel-body no-padding">
									<div class="table-responsive">
										<table class="table table-bordered mb-none orders">
												<thead>
													<tr class="bottom-border">
														<th>Date</th>
														<th>Instrument</th>
														<th>Direction</th>
														<th class="text-right">Currency 1</th>
														<th class="text-right">Currency 2</th>
														<th class="text-right">Rate</th>
														<th class="text-right">Fee</th>
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
																	<td>{{date("Y-m-d h:i", strtotime($odd_value->created_at))}}</td>
																	<td>BTCUSD</td>
																	<td>{{$odd_value->side == 1?"Buy":"Sell"}}</td>
																	<td class="text-right"><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value->quantity, 4, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value->limit_price_actual*(float)$odd_value->quantity, 2, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value->limit_price_actual, 2, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value->pc_calculated_amount, 2, '.', '')}}</td>
																			
																		
																	
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
			<script type="text/javascript">
				
				$('#start_d').unbind().on('change',function(){
					if($('#end_d').val()!==""){
						submit(1);								
					}
					
				});
				$('#end_d').unbind().on('change',function(){
						if($('#start_d').val()!==""){
							submit(1);
						}
				});

				$('#day').on('click',function(e){
					var d = new Date();
					d = date_format_t(d);
					$('#end_d').datepicker("setDate", d );
					 d = new Date();
					 d.setDate(d.getDate() - 1);
					d = date_format_t(d);
					$('#start_d').datepicker("setDate", d );
					e.preventDefault();
				});

				$('#week').on('click',function(e){
					var d = new Date();
					d = date_format_t(d);
					$('#end_d').datepicker("setDate", d );
					 d = new Date();
					 d.setDate(d.getDate() - 7);
					d = date_format_t(d);
					$('#start_d').datepicker("setDate", d );
					e.preventDefault();
				});

				$('#month').on('click',function(e){
					var d = new Date();
					d = date_format_t(d);
					$('#end_d').datepicker("setDate", d );
					 d = new Date();
					 d.setMonth(d.getMonth() - 1);
					d = date_format_t(d);
					$('#start_d').datepicker("setDate", d );
					e.preventDefault();
				});

				$('#year').on('click',function(e){
					var d = new Date();
					d = date_format_t(d);
					$('#end_d').datepicker("setDate", d );
					 d = new Date();
					 d.setFullYear( d.getFullYear() - 1 );
					d = date_format_t(d);
					$('#start_d').datepicker("setDate", d );
					e.preventDefault();
				});

			

				function date_format_t(today){
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!

					var yyyy = today.getFullYear();
					if(dd<10){
					    dd='0'+dd;
					} 
					if(mm<10){
					    mm='0'+mm;
					} 
					var today = mm+'/'+dd+'/'+yyyy;
					return today;

				}

			
			</script>
			@stop