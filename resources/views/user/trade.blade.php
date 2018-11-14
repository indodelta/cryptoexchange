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
#show, #show_orders {
    background: #40bde9 none repeat scroll 0 0;
    color: #fff;
    display: block;
    height: 35px;
    line-height: 35px;
    margin: auto auto 5px;
    min-width: 110px;
    padding: 0 10px;
    text-transform: uppercase;
}
.input-group small {
   left: 0;
   line-height: 14px !important;
   position: absolute;
   top: 35px;
}
#buy-modal .panel.modal-panel , #sell-modal .panel.modal-panel{
    padding: 0 !important;
}

 body .orderStatusButton.btn-danger:hover  body a .orderStatusButton.btn-danger:after{
  content: 'Cancel';
}

.table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td {
 border: 1px solid #ccc;
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


									
		    
	    <div id="buy-modal" class="modal-block modal-block-primary mfp-hide">
			<section class="panel modal-panel">
				<header class="panel-heading">
					<h3 style="margin:0;">BUY</h3>
					<button class=" modal-dismiss close close_bank_pop"></button>
				</header>
				<form action="" class="new_bank" method="post">
					<div class="panel-body">
							<p>Please confirm your Buy Order before submiting</p>
					       	<p>
						        <span class="left-text-list">Order Type</span>
						        <span>Limit Buy</span>	
					        </p>
							<p>
						        <span class="left-text-list">Qty</span>
						        <span class="buy_BTC_conversion_lbl">0.0000</span>	
					        </p>
							<p>
						        <span class="left-text-list">Estimated Price</span>
						        <span class="buy_order_price_lbl">$0.00</span>	
					        </p>	
							<p>
						        <span class="left-text-list">Estimated Commission (taker only)</span>
						        <span class="buy_fee_estimate_lbl">$0.00</span>	
					        </p>
							<br>
							<p>By Confirming this trade order, you have read  and agreed with our Terms & Conditions. Furthermore, you acknowledge and accept the risks associated with this trade order and you acknowledge and accept thet once the trade order has been filled, it cannot be reversed, undone or refunded
							<br>
							For any questions, please contact support@perfektpay.com or visit our Contact us page.</p>
							<div class="row">
							<div class="col-md-12 text-right">
								<i class="fa fa-spinner fa-spin loading" style="display:none;font-size:24px"></i>
								<button class="btn btn-default light-grey-btn  order_now" data-section="buy" type="button" style="margin-top:0;margin-bottom:10px;">CONFIRM BUY</button>
						    </div>
							</div>
				    </div>
				</form>
			</section>
		</div> 
		    	
		   <div id="sell-modal" class="modal-block modal-block-primary mfp-hide">
			<section class="panel modal-panel">
				<header class="panel-heading">
					<h3 style="margin:0;">SELL</h3>
					<button class=" modal-dismiss close close_bank_pop"></button>
				</header>
				<form action="" class="new_bank" method="post">
					<div class="panel-body">
							<p>Please confirm your Sell Order before submiting</p>
					        <p>
						        <span class="left-text-list">Order Type</span>
						        <span >Limit Sell</span>	
					        </p>
							<p>
						        <span class="left-text-list">Qty</span>
						        <span class="sell_BTC_conversion_lbl">0.0000</span>	
					        </p>
							<p>
						        <span class="left-text-list">Estimated Price</span>
						        <span class="sell_order_price_lbl">$0.00</span>	
					        </p>	
							<p>
						        <span class="left-text-list">Estimated Commission (taker only)</span>
						        <span class="sell_fee_estimate_lbl">$0.00</span>	
					        </p>	
							<br>
							<p>By Confirming this trade order, you have read  and agreed with our Terms & Conditions. Furthermore, you acknowledge and accept the risks associated with this trade order and you acknowledge and accept thet once the trade order has been filled, it cannot be reversed, undone or refunded
							<br>
							For any questions, please contact support@perfektpay.com or visit our Contact us page.</p>
							<div class="row">
							<div class="col-md-12 text-right">
								<i class="fa fa-spinner fa-spin loading" style="display:none;font-size:24px"></i>
								<button class="btn btn-default light-grey-btn order_now" data-section="sell" type="button" style="margin-top:0;margin-bottom:10px;">CONFIRM SELL</button>
						    </div>
							</div>
				    </div>
				</form>
			</section>
		</div> 
		
		
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
		<div class="col-xl-12 col-lg-12">
			<div class="tabs tabs-dark">
				<div class="tab-content row">
					<!--tab1-->					
					<div id="xbt1" class="tab-pane active">
						<div class="row">
									<div class="col-xl-3 col-lg-4">
										<section class="panel">
											<header class="panel-heading">
														<h2 class="panel-title">BUY</h2>
													</header>												
													<div class="panel-body no-padding no-shadow">
														<form id="buy_trade_form" method="post">
															{{ csrf_field() }}
															<input type="hidden" name="fee_estimate" class="buyfee_estimate">
															<input type="hidden" name="buy_xbt" value="1">
														    <div class="row">		
														    <div class="col-sm-12">		
															<input type="hidden" name="total" class="buy_total_amount">
															<div class="panel-body no-padding no-shadow"> 
																<div class="col-sm-12">				
																
																
																<div class="row">
																    <div class="col-sm-6">
																        <div class="form-group row">
    																	<label class="col-md-12 control-label">Price</label>
    																	<div class="col-sm-12">
    																		<div class="input-group mb-md">
    																			<span class="input-group-addon light-blue-back">
    																			<i class="fa fa-dollar" aria-hidden="true"></i>
    																			</span>
    																			<input class="form-control order_price" id="buy_order_price" data-section="buy" required="required" type="text" step="any" value="{{number_format((float)$itbit['ask'], 2, '.', '')}}" name="order_price" placeholder="0.00">
    																			<small style="color:red" class="buy_small"></small>
    																		</div>
    																	</div>
																    </div>
																    </div>
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
																</div>
																<div class="row">
																    <div class="col-sm-6">
    																    <div class="form-group">
																	        <button class="green-btn trade_btn" type="button" id="buy_modal" data-section="buy">BUY BTC</button>
    															    	</div>
    															    </div>
																	<div class="col-sm-6">
																		<div class="form-group row">
																			<label class="col-md-12 control-label">USD</label>
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
													
													<div class="col-sm-12">
															<div class="green-card">
																<div class="green-card-upper">
																	<ul class="card-listing">
																		<li>
																			<h6>Order Price<br><p class="card-amount">$<spam class="buy_order_price">{{number_format((float)$itbit['ask'], 2, '.', '')}}</spam> USD</p></h6>
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
																        <div class="col-sm-12">
																			<ul  class="percentage-list buy">
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.1" data-section="buy">10%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.25" data-section="buy">25%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.5" data-section="buy">50%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="1" data-section="buy">100%</button></li>
																			</ul>
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
													<div class="col-xl-3 col-lg-4">
													    <section class="panel">
    											        <header class="panel-heading">
    														<h2 class="panel-title">SELL</h2>
    													</header>												
													        <div class="panel-body no-padding no-shadow">
													        <form id="sell_trade_form" method="post">
															{{ csrf_field() }}
															<input type="hidden" name="fee_estimate" class="sellfee_estimate">
															<input type="hidden" name="sell_xbt" value="2">
														     <div class="row">		
														    <div class="col-sm-12">		
															<input type="hidden" name="total" class="sell_total_amount">
															<div class="panel-body no-padding no-shadow"> 
																<div class="row">
																    <div class="col-sm-12">
																    
																    <div class="col-sm-6">
																        <div class="form-group row">
																			<label class="col-md-12 control-label">Price</label>
																			<div class="col-sm-12">
																				<div class="input-group mb-md">
																					<span class="input-group-addon light-blue-back">
																					<i class="fa fa-dollar" aria-hidden="true"></i>
																					</span>
																					<input class="form-control order_price" id="sell_order_price" required="required" type="text" step="any" value="{{number_format((float)$itbit['bid'], 2, '.', '')}}" name="order_price" data-section="sell" placeholder="0.00">
																					<small style="color:red" class="sell_small"></small>
																				</div>
																			</div>
																		</div>
																    </div>
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
																</div>
																</div>
																    
										                        <div class="row">
										                            <div class="col-sm-12">
																    <div class="col-sm-6">
    																    <div class="form-group">
																    	    <button type="button" class="blue-btn trade_btn" id="sell_modal" name="sell_xbt" value="2" data-section="sell">SELL BTC</button>
    															    	</div>
    															    </div>
																    <div class="col-sm-6">
																		<div class="form-group row">
																			<label class="col-md-12 control-label">USD</label>
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
															
													
													
													    <div class="col-sm-12">
															<div class="green-card">
																<div class="green-card-upper">
																	
																	<ul class="card-listing">
																		<li>
																			<h6>Order Price<br><p class="card-amount">$<spam class="sell_order_price">{{number_format((float)$itbit['bid'], 2, '.', '')}}</spam> USD</p></h6>
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
											
																    	    <div class="col-sm-12" >
																			<ul  class="percentage-list sell">
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.1" data-section="sell">10%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.25" data-section="sell">25%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="0.5" data-section="sell">50%</button></li>
																			    <li><button type="button" class="btn btn-default small-btn per-button addperc" data-perc="1" data-section="sell">100%</button></li>
																			</ul>
																			
																		</div>
																
																    	</div>
																</div>
															</div>
														</div>
												
												    </form>
										        </section>
									        </div>
											
												
										<div class="col-xl-3 col-lg-4">
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
											
												<section class="" id="trail_he">
													<header class="panel-heading ">
														<h2 class="panel-title" style="color:#fff;">Wallet</h2>
														<input type="hidden" id="xbt__token" value="{{base64_encode(number_format((float)$total_btc, 4, '.', ''))}}">
														<input type="hidden" id="usd__token" value="{{base64_encode(number_format((float)$total_usd, 2, '.', ''))}}">
														<!-- <div class="panel-right">
															<a href="">Fee structure</a>
														</div> -->
													</header>
													<div class="panel-body no-padding no-shadow no-radius">
														<div class="table-responsive">
															<table class="table table-bordered mb-none" id="tbl_wallet">
																<thead>
																	<tr>
																		<th>Currency</th>
																		<th class="text-right">Balance</th>
																		<th class="text-right">Available</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td class="light-blue table-content">BTC</td>
																		<td class="text-right">{{number_format((float)$balance_btc, 4, '.', '')!=-0.0000?number_format((float)$balance_btc, 4, '.', ''):number_format((float)0, 4, '.', '')}}</td>
																		<td class="text-right">{{number_format((float)$total_btc, 4, '.', '')!=-0.0000?number_format((float)$total_btc, 4, '.', ''):number_format((float)0, 4, '.', '')}}</td>
																	</tr>
																	<tr>
																		<td class="light-blue table-content">USD</td>
																		<td class="text-right">{{number_format((float)$balance_usd, 2, '.', '')!=-0.00?number_format((float)$balance_usd, 2, '.', ''):number_format((float)0, 2, '.', '')}}</td>
																		<td class="text-right">{{number_format((float)$total_usd, 2, '.', '')!=-0.00?number_format((float)$total_usd, 2, '.', ''):number_format((float)0, 2, '.', '')}}</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="panel-body">
                									</div>
                									
												</section>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
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
											<table class="table table-bordered mb-none orders" id="orders_table">
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
																	<td>{{date("d-m-Y h:i:s", strtotime($odd_value['created_at']))}}</td>
																	<td>{{$odd_value['side'] == 1?"Buy":"Sell"}}</td>
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value['quantity'], 4, '.', '')}}</td>
																	<td class="text-right"><b>$</b>{{number_format((float)$odd_value['limit_price_actual'], 2, '.', '')}}</td>
																	<td ><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value['filled'], 4, '.', '')}}</td>
																	
																	<td><i class="fa fa-bitcoin" aria-hidden="true"></i>
																	@if($odd_value['status']==0)
																 {{number_format((float)$odd_value['remaining'], 4, '.', '')}}
																 @else
																	0.00
																	@endif
																</td>
																<td class="text-right"><b>$</b>@if($odd_value['status']==1)
																	{{number_format((float)$odd_value['limit_price_actual'], 2, '.', '')}}
																	@else
																	0.00
																	@endif</td>



<style>
.btn.btn-danger{
	background:#d9534f;
	padding:5px 10px;
	border:0px;

}
a .new-label span{
  position: relative;
  content: 'Open'
}
a:hover .new-label span{
  display: none;
}
a:hover .new-label:after{
  content: 'Cancel';
}
</style>

																	<td class="text-center"><?php if($odd_value['status']==0){ ?><a href="cancel_order/{{Crypt::encrypt($odd_value['txn_id'])}}" class=" orderStatusButton btn-sm btn btn-danger"  title="Cancel Order"> <div class="new-label "><span class="align">{{$status}}</div></a><?php }else{ echo $status; } ?></td>
																</tr>
													<?php
															$i++;
														} ?>
													<?} else{ ?>
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
									
								</section>
							</div>
						    <div class="row">
								<section class="panel" style="max-height:350px;;">
									<header class="panel-heading bottom-border" style="">
										<h2 class="panel-title">Order Book</h2>
									</header>
									
									<div class="col-md-12 no-padding right-border-box">
										<div class="panel-body no-padding">
											<div class="table-responsive">
												<input type="hidden" class="order_book_visible" value="10">
												<table class="table table-bordered mb-none order_book">
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
					<!--tab1 end-->
				</div>
			</div>
		</div>
		</div>
			<!-- end: page -->
	</section>
</div>
@stop