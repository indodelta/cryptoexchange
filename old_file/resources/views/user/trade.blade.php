@extends('user.layouts.layout')
@section('content')
<style>
#support-header {
  display: none;
}
.tableBodyScroll tbody {
display:block;
max-height:300px;
overflow-y:scroll;
}
.tableBodyScroll thead,.tableBodyScroll tbody tr {
display:table;
width:100%;
table-layout:fixed;
}
#show,#show_orders {
  background: #40bde9 none repeat scroll 0 0;
  color: #fff;
  display: block;
  height: 40px;
  line-height: 40px;
  margin: auto auto 25px;
  min-width: 140px;
  padding: 0 10px;
  text-transform: uppercase;
}
.input-group small {
   left: 0;
   line-height: 14px !important;
   position: absolute;
   top: 35px;
}
</style>
<span class='pcrypted hidden'>{{base64_encode($perfektpay_commission->trading_buy)}}</span>
<span class='pcrypteds hidden'>{{base64_encode($perfektpay_commission->trading_sell)}}</span>
	@if(Session::has('message')) 
 <script type="text/javascript">
   $(window).on('load',function(){
Command: toastr['success']("{{ Session::get('message') }}")
toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": false,
  "preventDuplicates": false,
  "positionClass": "toast-top-center",
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "7000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

});
   	 </script>


@endif
		

		@if(Session::has('error')) 
 <script type="text/javascript">
   $(window).on('load',function(){	 	  
   Command:toastr['error']("{{ Session::get('error') }}")
   
   toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "preventDuplicates": false,
  "positionClass": "toast-top-center",
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "7000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
});
   	 </script>


@endif
<div class="formtoken">{{ csrf_field() }}</div>
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
													<div  class="row notify-top-content">
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
												<div  class="row notify-top-content">
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
		<div class="col-xl-12 col-lg-12">
			<div class="tabs tabs-dark">
				<div class="tab-content row">
					<!--tab1-->					
					<div id="xbt1" class="tab-pane active">
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="col-xl-12 col-lg-12">
									<div class="top-inner-trade row">
										<div class="col-md-8">
											<div class="row">
												<section class="panel no-shadow trading-box">
													<header class="panel-heading">
														<h2 class="panel-title">Limit Order</h2>
													</header>												
													<div class="panel-body no-padding no-shadow">
														<form id="trade_form" method="post">
															{{ csrf_field() }}
															<input type="hidden" name="fee_estimate" class="buyfee_estimate">
														<div class="col-sm-6">
														    <div class="row">		
														    <div class="col-sm-12">		
															<input type="hidden" name="total" class="buy_total_amount">
															<div class="panel-body no-padding no-shadow"> 
																<div class="col-sm-12">																	
																<div class="form-group row">
																	<label class="col-md-12 control-label">Price</label>
																	<div class="col-sm-12">
																		<div class="input-group mb-md">
																			<span class="input-group-addon light-blue-back">
																			<i class="fa fa-dollar" aria-hidden="true"></i>
																			</span>
																			<input class="form-control order_price" id="buy_order_price" data-section="buy" required="required" type="text" step="any" name="order_price" placeholder="0.00">
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-6">
																		<div class="form-group row">
																			<label class="col-md-12 control-label">Quantity</label>
																			<div class="col-sm-12">
																				<div class="input-group mb-md">
																					<span class="input-group-addon light-blue-back">
																					<i class="fa fa-bitcoin" aria-hidden="true"></i>
																					</span>
																					<input class="form-control trade_price" required="required" min="0.00000001" id="buy_BTC_conversion" type="text" data-section="buy" step="any" data-currency="BTC" name="quantity" placeholder="0.00">
																				</div>
																			</div>
																		</div>
																	</div>
																
																	<div class="col-sm-6">
																		<div class="form-group row">
																			<label class="col-md-12 control-label">USD Conversion</label>
																			<div class="col-sm-12">
																				<div class="input-group mb-md">
																					<span class="input-group-addon light-blue-back">
																					<i class="fa fa-usd" aria-hidden="true"></i>
																					</span>
																					<input class="form-control trade_price" required="required" id="buy_USD_conversion" type="text" step="any" data-section="buy" data-currency="USD" name="usd_conversion" placeholder="0.00">
																					<small style="color:red"></small>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
													<div class="col-sm-12">
															<div class="green-card">
																<div class="green-card-upper">
																	<ul class="card-listing">
																		<li>
																			<h6>Order Price<br><p class="card-amount">$<spam class="buy_order_price">0.00</spam> USD</p></h6>
																		</li>
																		<li>
																			<h6>Quantity<br><p class="card-amount"><i class="fa fa-bitcoin" aria-hidden="true"></i> <span class="buy_quantity">0.0000</span></p></h6>
																		</li>
																	</ul>
																	<ul class="card-listing">
																		<li>
																			<h6>Fee Estimate<br><p class="card-amount">$<span class="buy_fee_estimate">0.00</span> USD</p></h6>
																		</li>
																		<li>
																			<h6>Total<br><p class="card-amount">$<span class="buy_total_usd">0.00</span> USD</p></h6>
																		</li>
																	</ul>
																</div>
																<div class="green-button-back">
																    <div class="row">
																        <div class="col-sm-7">
																			<ul  class="percentage-list buy">
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.1" data-section="buy">10%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.25" data-section="buy">25%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.5" data-section="buy">50%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="1" data-section="buy">100%</button></li>
																			</ul>
																		</div>
																		<div class="col-sm-5">
																	<button class="green-card-button btn" type="submit" name="buy_xbt" value="1">BUY XBT</button>
																	</div>
																</div>
															</div>
															</div>
														</div>
													</div>
													</form>
													<form id="trade_form" method="post">
															{{ csrf_field() }}
															<input type="hidden" name="fee_estimate" class="sellfee_estimate">
														<div class="col-sm-6">
														     <div class="row">		
														    <div class="col-sm-12">		
															<input type="hidden" name="total" class="sell_total_amount">
															<div class="panel-body no-padding no-shadow"> 
																<div class="col-sm-12">
																	
																		<div class="form-group row">
																			<label class="col-md-12 control-label">Price</label>
																			<div class="col-sm-12">
																				<div class="input-group mb-md">
																					<span class="input-group-addon light-blue-back">
																					<i class="fa fa-dollar" aria-hidden="true"></i>
																					</span>
																					<input class="form-control order_price" id="sell_order_price" required="required" type="text" step="any" name="order_price" data-section="sell" placeholder="0.00">
																				</div>
																			</div>
																		</div>
										<div class="row">
										    <div class="col-sm-6">
																		<div class="form-group row">
																			<label class="col-md-12 control-label">Quantity</label>
																			<div class="col-sm-12">
																				<div class="input-group mb-md">
																					<span class="input-group-addon light-blue-back">
																					<i class="fa fa-bitcoin" aria-hidden="true"></i>
																					</span>
																					<input class="form-control trade_price" required="required" min="0.00000001" id="sell_BTC_conversion" type="text" data-section="sell" step="any" data-currency="BTC" name="quantity" placeholder="0.00">
																					<small style="color:red"></small>
																				</div>
																			</div>
																		</div>
																	</div>
																
																<div class="col-sm-6">
																		<div class="form-group row">
																			<label class="col-md-12 control-label">USD Conversion</label>
																			<div class="col-sm-12">
																				<div class="input-group mb-md">
																					<span class="input-group-addon light-blue-back">
																					<i class="fa fa-usd" aria-hidden="true"></i>
																					</span>
																					<input class="form-control trade_price" required="required" id="sell_USD_conversion" type="text" step="any" data-section="sell" data-currency="USD" name="usd_conversion" placeholder="0.00">
																					<small style="color:red"></small>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
													
													<div class="col-sm-12">
															<div class="green-card">
																<div class="green-card-upper">
																	
																	<ul class="card-listing">
																		<li>
																			<h6>Order Price<br><p class="card-amount">$<spam class="sell_order_price">0.00</spam> USD</p></h6>
																		</li>
																		<li>
																			<h6>Quantity<br><p class="card-amount"><i class="fa fa-bitcoin" aria-hidden="true"></i> <span class="sell_quantity">0.0000</span></p></h6>
																		</li>
																	</ul>
																	<ul class="card-listing">
																		<li>
																			<h6>Fee Estimate<br><p class="card-amount">$<span class="sell_fee_estimate">0.00</span> USD</p></h6>
																		</li>
																		<li>
																			<h6>Total<br><p class="card-amount">$<span class="sell_total_usd">0.00</span> USD</p></h6>
																		</li>
																	</ul>
																</div>
																<div class="blue-button-back">
																    	<div class="row">
											
																    	    <div class="col-sm-7" >
																			<ul  class="percentage-list sell">
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.1" data-section="sell">10%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.25" data-section="sell">25%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.5" data-section="sell">50%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="1" data-section="sell">100%</button></li>
																			</ul>
																			
																		</div>
																<div class="col-sm-5">
																    	<button type="submit" class="green-card-button btn" name="sell_xbt" value="2">SELL XBT</button>
																    	</div>
																    	</div>
																</div>
															</div>
														</div>
													</div>
												</form>
													</div>
												</section>
											</div>
										</div>
										<div class="col-sm-4">
											<!--<div class="row">
												<div class="form-group" style="background:#f2f2f2;padding-bottom:25px;">
													<label class="col-md-12 control-label" for="inputSuccess"><br>Amount</label>
													<div class="col-md-12">
														<select id="mounth" class="form-control populate">
															<optgroup>
																<option value="1">Wallet</option>
																<option value="2">Wallet1</option>
																<option value="3">Wallet2</option>
																<option value="4">Wallet3</option>
															</optgroup>
														</select>
													</div>
												</div>
											</div>-->
											<div class="row">
												<section class="">
													<header class="panel-heading  no-radius">
														<h2 class="panel-title" style="color:#fff;">Wallet</h2>
														<input type="hidden" id="xbt__token" value="{{base64_encode((float)$total_btc)}}">
														<input type="hidden" id="usd__token" value="{{base64_encode((float)$total_usd)}}">
														<!-- <div class="panel-right">
															<a href="">Fee structure</a>
														</div> -->
													</header>
													<div class="panel-body no-padding no-shadow no-radius">
														<div class="table-responsive">
															<table class="table table-striped mb-none">
																<thead>
																	<tr>
																		<th>Currency</th>
																		<th class="text-right">Balance</th>
																		<th class="text-right">Available</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td class="light-blue">Bitcoin</td>
																		<td class="text-right">{{number_format((float)$balance_btc, 4, '.', '')}}</td>
																		<td class="text-right">{{number_format((float)$total_btc, 4, '.', '')}}</td>
																	</tr>
																	<tr>
																		<td class="light-blue">USD</td>
																		<td class="text-right">{{number_format((float)$balance_usd, 2, '.', '')}}</td>
																		<td class="text-right">{{number_format((float)$total_usd, 2, '.', '')}}</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="panel-body">
                									</div>
                										<div class="panel-body">
                									</div>
													<div class="panel-body no-padding grey-back text-center">
                                                        <img src="assets/images/wallet.png">
                                                        <br>
                                                        </div>
                                                        <div class="panel-body">
									</div>
												</section>
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
										<h2 class="panel-title">Your Orders</h2>
									</header>
									<div class="panel-body no-padding">
										<div class="table-responsive">
											<?php 
												/*echo "<pre>";
												print_r($orders_detail);
												echo "</pre>";*/
											?>
											<input type="hidden" class="orders_visible" value="5">
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
													<?php if(isset($orders_detail) && !empty($orders_detail)){
															$i=0; 
															foreach ($orders_detail as $key => $odd_value) { 
																if($odd_value['status']==0){
																	$status = "Open";
																}else if($odd_value['status']==1){
																	$status = "Filled";
																}else if($odd_value['status']==2){
																	$status = "Cancelled";
																}
																?>
																<tr>
																	<td>{{date("d-m-Y h:m:i", strtotime($odd_value['created_at']))}}</td>
																	<td>{{$odd_value['side'] == 1?"Buy":"Sell"}}</td>
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value['quantity'], 4, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value['limit_price'], 2, '.', '')}}</td>
																	<td ><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value['filled'], 4, '.', '')}}</td>
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value['remaining'], 4, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value['avg_price'], 2, '.', '')}}</td>
																	<td class="text-center"><?php if($odd_value['status']==0){ ?><a href="cancel_order/{{Crypt::encrypt($odd_value['txn_id'])}}" class="btn btn-danger per-button" title="Cancel Order">{{$status}}</a><?php }else{ echo $status; } ?></td>
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
									<div class="panel-body"></div>
								</section>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<section class="panel" style="max-height:350px;;">
									<header class="panel-heading bottom-border" style="">
										<h2 class="panel-title">Order Book</h2>
									</header>
									
									<div class="col-md-12 no-padding right-border-box">
										<div class="panel-body no-padding">
											<div class="table-responsive">
												<input type="hidden" class="order_book_visible" value="10">
												<table class="table table-striped mb-none order_book">
													<thead>
														<tr>
															<th colspan="3" class="light-blue text-center bottom-border" style="font-size:15px;">Bid (USD)</th>
															<th class="light-blue text-center bottom-border" style="font-size:15px;" colspan="3">Ask (USD)</th>
														</tr>
														<tr class="bottom-border">
															<th><strong>Total</strong></th>
															<th><strong>QTY</strong></th>
															<th ><strong>Price</strong></th>
															
															<th class="text-right"><strong>Price</strong></th>
															<th class="text-right"><strong>QTY</strong></th>
															<th class="text-right"><strong>Total</strong></th>
														</tr>
													</thead>
													<tbody class="order_body">
													    <?php echo $order_html; ?>
													</tbody>
												</table>
												<button id="show" type="button" class="btn">Load More <i class="fa fa-circle-o-notch fa-spin"></i></button> 
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
					<!--tab1 end-->
					<!--tab2-->
					<!-- <div id="xbt2" class="tab-pane">
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="col-xl-12 col-lg-12">
									<div class="top-inner-trade row">
										<div class="col-md-8">
											<div class="row">
												<section class="panel no-shadow">
													<header class="panel-heading">
														<h2 class="panel-title">Limit Order</h2>
													</header>
													<div class="panel-body no-padding">
														<br>
														<div class="form-group">
															<label class="col-md-12 control-label">Price</label>
															<div class="col-sm-5">
																<div class="input-group mb-md">
																	<span class="input-group-addon light-blue-back">
																	<i class="fa fa-dollar" aria-hidden="true"></i>
																	</span>
																	<input class="form-control" type="text" value="0.0000000">
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body no-padding no-shadow">
														<div class="col-sm-6">
															<div class="green-card">
																<div class="green-card-upper">
																	<p>Order Price<br><a href="" class="card-amount">$ 15432.50 USD</a></p>
																	<ul class="card-listing">
																		<li>
																			<h6>Fee Estimate<br><a href=""  class="card-amount">$ 0 USD</a></h6>
																		</li>
																		<li>
																			<h6>Total<br><a href="" class="card-amount">$ 0 USD</a></h6>
																		</li>
																	</ul>
																</div>
																<div class="green-button-back">
																	<button class="green-card-button btn">BUT XBT</button>
																</div>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="green-card">
																<div class="green-card-upper">
																	<p>Order Price<br><a href="" class="card-amount">$ 25100.50 USD</a></p>
																	<ul class="card-listing">
																		<li>
																			<h6>Fee Estimate<br><a href=""  class="card-amount">$ 0 USD</a></h6>
																		</li>
																		<li>
																			<h6>Total<br><a href="" class="card-amount">$ 0 USD</a></h6>
																		</li>
																	</ul>
																</div>
																<div class="blue-button-back">
																	<button class="green-card-button btn">BUT XBT</button>
																</div>
															</div>
														</div>
													</div>
												</section>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="row">
												<div class="form-group" style="background:#f2f2f2;padding-bottom:25px;">
													<label class="col-md-12 control-label" for="inputSuccess"><br>Amount</label>
													<div class="col-md-12">
														<select id="mounth" class="form-control populate">
															<optgroup>
																<option value="1">Wallet</option>
																<option value="2">Wallet1</option>
																<option value="3">Wallet2</option>
																<option value="4">Wallet3</option>
															</optgroup>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<section class="">
													<header class="panel-heading  no-radius">
														<h2 class="panel-title">Wallet</h2>
														<div class="panel-right">
															<a href="">Fee structure</a>
														</div>
													</header>
													<div class="panel-body no-padding no-shadow no-radius">
														<div class="table-responsive">
															<table class="table table-striped mb-none">
																<thead>
																	<tr>
																		<th>Currency</th>
																		<th class="text-right">Balance</th>
																		<th class="text-right">Available</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>XBT</td>
																		<td class="text-right">0.0000001</td>
																		<td class="text-right">0.0000001</td>
																	</tr>
																	<tr>
																		<td>XBT</td>
																		<td class="text-right">0.001</td>
																		<td class="text-right">0.001</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</section>
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
										<h2 class="panel-title">Your Orders</h2>
									</header>
									<div class="panel-body no-padding">
										<div class="table-responsive">
											<table class="table table-striped mb-none">
												<thead>
													<tr class="bottom-border">
														<th>Date (UTC)</th>
														<th>Side</th>
														<th>Quantity</th>
														<th>Limit Price</th>
														<th>Filled</th>
														<th>Remaining</th>
														<th>Avg. Price</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Bitcoin1</td>
														<td>0.11111</td>
														<td>0.0111000001</td>
														<td>Bitcoin1</td>
														<td>0.1111</td>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>0.00001111</td>
													</tr>
													<tr>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>0.0000001</td>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>0.0000001</td>
													</tr>
													<tr>
														<td class="text-center" colspan="8" style="padding-top:50px;padding-bottom:50px;">
															<img src="assets/images/empty.png"><br>
															<p>There is no order history to display.</p>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="panel-body"></div>
								</section>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<section class="panel">
									<header class="panel-heading bottom-border" style="">
										<h2 class="panel-title">Order Book</h2>
									</header>
									<div class="col-md-6 col-lg-6 no-padding right-border-box">
										<div class="panel-body no-padding">
											<div class="table-responsive">
												<table class="table table-striped mb-none">
													<thead>
														<tr>
															<th colspan="3" class="light-blue text-center bottom-border" style="font-size:15px;">Bid (USD)</th>
														</tr>
														<tr class="bottom-border">
															<th><strong>Total</strong></th>
															<th><strong>QTY</strong></th>
															<th><strong>Price</strong></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td class="text-center" colspan="8" style="padding-top:50px;padding-bottom:50px;">
																<img src="assets/images/empty.png"><br>
																<p>There is no order history to display.</p>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-lg-6 no-padding">
										<div class="panel-body no-padding">
											<div class="table-responsive">
												<table class="table table-striped mb-none">
													<thead>
														<tr>
															<th colspan="3" class="light-blue text-center bottom-border" style="font-size:15px;">Ask (USD)</th>
														</tr>
														<tr class="bottom-border">
															<th><strong>Total</strong></th>
															<th><strong>QTY</strong></th>
															<th><strong>Price</strong></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td class="text-center" colspan="8" style="padding-top:50px;padding-bottom:50px;">
																<img src="assets/images/empty.png"><br>
																<p>There is no order history to display.</p>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div> -->
					<!--tab2 end-->
					<!--tab3-->
					<!-- <div id="xbt3" class="tab-pane">
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="col-xl-12 col-lg-12">
									<div class="top-inner-trade row">
										<div class="col-md-8">
											<div class="row">
												<section class="panel no-shadow">
													<header class="panel-heading">
														<h2 class="panel-title">Limit Order</h2>
													</header>
													<div class="panel-body no-padding">
														<br>
														<div class="form-group">
															<label class="col-md-12 control-label">Price</label>
															<div class="col-sm-5">
																<div class="input-group mb-md">
																	<span class="input-group-addon light-blue-back">
																	<i class="fa fa-dollar" aria-hidden="true"></i>
																	</span>
																	<input class="form-control" type="text" value="0.0000000">
																</div>
															</div>
														</div>
													</div>
													<div class="panel-body no-padding no-shadow">
														<div class="col-sm-6">
															<div class="green-card">
																<div class="green-card-upper">
																	<p>Order Price<br><a href="" class="card-amount">$ 23456.50 USD</a></p>
																	<ul class="card-listing">
																		<li>
																			<h6>Fee Estimate<br><a href=""  class="card-amount">$ 0 USD</a></h6>
																		</li>
																		<li>
																			<h6>Total<br><a href="" class="card-amount">$ 0 USD</a></h6>
																		</li>
																	</ul>
																</div>
																<div class="green-button-back">
																	<button class="green-card-button btn">BUT XBT</button>
																</div>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="green-card">
																<div class="green-card-upper">
																	<p>Order Price<br><a href="" class="card-amount">$ 43215.50 USD</a></p>
																	<ul class="card-listing">
																		<li>
																			<h6>Fee Estimate<br><a href=""  class="card-amount">$ 0 USD</a></h6>
																		</li>
																		<li>
																			<h6>Total<br><a href="" class="card-amount">$ 0 USD</a></h6>
																		</li>
																	</ul>
																</div>
																<div class="blue-button-back">
																	<button class="green-card-button btn">BUT XBT</button>
																</div>
															</div>
														</div>
													</div>
												</section>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="row">
												<div class="form-group" style="background:#f2f2f2;padding-bottom:25px;">
													<label class="col-md-12 control-label" for="inputSuccess"><br>Amount</label>
													<div class="col-md-12">
														<select id="mounth" class="form-control populate">
															<optgroup>
																<option value="1">Wallet</option>
																<option value="2">Wallet1</option>
																<option value="3">Wallet2</option>
																<option value="4">Wallet3</option>
															</optgroup>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<section class="">
													<header class="panel-heading  no-radius">
														<h2 class="panel-title">Wallet</h2>
														<div class="panel-right">
															<a href="">Fee structure</a>
														</div>
													</header>
													<div class="panel-body no-padding no-shadow no-radius">
														<div class="table-responsive">
															<table class="table table-striped mb-none">
																<thead>
																	<tr>
																		<th>Currency</th>
																		<th class="text-right">Balance</th>
																		<th class="text-right">Available</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>XBT</td>
																		<td class="text-right">0.0000001</td>
																		<td class="text-right">0.0000001</td>
																	</tr>
																	<tr>
																		<td>XBT</td>
																		<td class="text-right">0.001</td>
																		<td class="text-right">0.001</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</section>
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
										<h2 class="panel-title">Your Orders</h2>
									</header>
									<div class="panel-body no-padding">
										<div class="table-responsive">
											<table class="table table-striped mb-none">
												<thead>
													<tr class="bottom-border">
														<th>Date (UTC)</th>
														<th>Side</th>
														<th>Quantity</th>
														<th>Limit Price</th>
														<th>Filled</th>
														<th>Remaining</th>
														<th>Avg. Price</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Bitcoin1</td>
														<td>0.11111</td>
														<td>0.0111000001</td>
														<td>Bitcoin1</td>
														<td>0.1111</td>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>0.00001111</td>
													</tr>
													<tr>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>0.0000001</td>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>Bitcoin</td>
														<td>0.0000001</td>
														<td>0.0000001</td>
													</tr>
													
													<tr>
														<td class="text-center" colspan="8" style="padding-top:50px;padding-bottom:50px;">
															<img src="assets/images/empty.png"><br>
															<p>There is no order history to display.</p>
														</td>
													</tr>
													
												</tbody>
											</table>
										</div>
									</div>
									<div class="panel-body"></div>
								</section>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<section class="panel inner-panel">
									<header class="panel-heading bottom-border" style="">
										<h2 class="panel-title">Order Book</h2>
									</header>
									<div class="col-md-6 col-lg-6 no-padding right-border-box">
										<div class="panel-body no-padding">
											<div class="table-responsive">
												<table class="table table-striped mb-none">
													<thead>
														<tr>
															<th colspan="3" class="light-blue text-center bottom-border" style="font-size:15px;">Bid (USD)</th>
														</tr>
														<tr class="bottom-border">
															<th><strong>Total</strong></th>
															<th><strong>QTY</strong></th>
															<th><strong>Price</strong></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td class="text-center" colspan="8" style="padding-top:50px;padding-bottom:50px;">
																<img src="assets/images/empty.png"><br>
																<p>There is no order history to display.</p>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-lg-6 no-padding">
										<div class="panel-body no-padding">
											<div class="table-responsive">
												<table class="table table-striped mb-none">
													<thead>
														<tr>
															<th colspan="3" class="light-blue text-center bottom-border" style="font-size:15px;">Ask (USD)</th>
														</tr>
														<tr class="bottom-border">
															<th><strong>Total</strong></th>
															<th><strong>QTY</strong></th>
															<th><strong>Price</strong></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td>3.01452</td>
															<td>3.01452</td>
															<td>$10850.00</td>
														</tr>
														<tr>
															<td class="text-center" colspan="8" style="padding-top:50px;padding-bottom:50px;">
																<img src="assets/images/empty.png"><br>
																<p>There is no order history to display.</p>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div> -->
					<!--tab3 end-->
				</div>
			</div>
		</div>
			<!-- end: page -->
	</section>
</div>
@stop