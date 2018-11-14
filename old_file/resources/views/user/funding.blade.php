@extends('user.layouts.layout')
@section('content')
<style type="text/css">
	small.usdsmall {
    position: absolute;
    left: 0;
    top: 35px;
}
.mfp-close, .mfp-close-btn-in .mfp-close {
    display: none;
}
#support-header {
  display: none;
}
</style>
<div class="inner-wrapper">
	<section role="main" class="content-body">
        							<div id="USDdollar-modal1" class="modal-block modal-block-primary mfp-hide">
										<section class="panel modal-panel">
											<header class="panel-heading">
												<h3 style="margin:0;">Withdraw USD Dollar</h3>
												<button class=" modal-dismiss close">X</button>
											</header>
											<div class="panel-body">
											    <div class="row inner-paragraph">
						                            <div class="col-sm-12">
						                                <p>
						                                    <span class="left-text-list lbl_bank_name">BANK NAME</span>
						                                    <span class="val_bank_name"></span>	
					                                    </p>
					                                    <p>
					                                    	<span class="left-text-list lbl_beneficiary_name">BENEFICIARY NAME</span>
					                                    	<span class="val_beneficiary_name"></span>
					                                    </p>
					                                    <p>
					                                    	<span class="left-text-list lbl_beneficiary_account">BENEFICIARY ACCOUNT NO.</span>
					                                    	<span class="val_beneficiary_account"></span>
					                                    </p>
					                                    <p>
					                                    	<span class="left-text-list lbl_swift_code">SWIFT CODE</span>
						                                    <span class="val_swift_code"></span>
						                                </p>
						                                <p>
					                                    	<span class="left-text-list lbl_swift_code">AMOUNT</span>
						                                    <span class="val_usdamount"></span>
						                                </p><br>
						                                <?php if(isset($g_auth->G_AUTH) && !empty($g_auth->G_AUTH) && $g_auth->G_AUTH == 1){ ?>
						                                <div class="form-group">
						                                    <label class="col-md-2 control-label" for="inputDefault">2FA CODE</label>
						                                    <div class="col-md-10">
						                                        <input id="inputDefault" class="form-control" type="text">
						                                    </div>
						                                </div>
						                                <?php } ?>
						                                <br>
						                            </div>
												</div>
						                        <br>
						    					<div class="col-md-12 text-right">
						    						<i class="fa fa-spinner fa-spin usd_loading" style="font-size:24px"></i>&nbsp;<button class="btn btn-primary light-blue-btn" style="margin-top:0;margin-bottom:10px;">Submit</button>&nbsp;&nbsp;&nbsp;
						    						<button class="btn btn-default light-grey-btn  modal-dismiss" style="margin-top:0;margin-bottom:10px;">Cancel</button>
						    					</div>
				        					</div>
				        				</section>
				        			</div>
									
									
									
									
		    
	    <div id="USDdollar-modal" class="modal-block modal-block-primary mfp-hide">
			<section class="panel modal-panel">
				<header class="panel-heading">
					<h3 style="margin:0;">USD Bank Detail</h3>
					<button class=" modal-dismiss close close_bank_pop">X</button>
				</header>
				<form action="{{url('bank')}}" class="new_bank" method="post">
					{{ csrf_field() }}
					<div class="panel-body">
						<div class="row">
					        <div class="form-group">
	                            <label class="col-md-12 control-label" for="inputDefault">BANK NAME</label>
	                            <div class="col-md-12">
	                               <input id="bank_name" class="form-control" type="text" name="bank_name" required="">
	                            </div>
	                        </div>	                        
					       	<div class="form-group">
	                            <label class="col-md-12 control-label" for="inputDefault">BENEFICIARY NAME</label>
	                            <div class="col-md-12">
	                               <input id="beneficiary_name" class="form-control" type="text" name="beneficiary_name" required="">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-md-12 control-label" for="inputDefault">BENEFICIARY ACCOUNT NO.</label>
	                            <div class="col-md-12">
	                               <input id="beneficiary_account_no" class="form-control int_field" type="text" name="beneficiary_account_no" required="">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-md-12 control-label" for="inputDefault">SWIFT CODE</label>
	                            <div class="col-md-12">
	                               <input id="swift_code" class="form-control" type="text" name="swift_code" required="">
	                            </div>
	                        </div>
	                        <br>
							<div class="col-md-12 text-right">
								<i class="fa fa-spinner fa-spin loading" style="display:none;font-size:24px"></i>
								<button class="btn btn-primary light-blue-btn" type="submit" style="margin-top:0;margin-bottom:10px;">Submit</button>&nbsp;&nbsp;&nbsp;
								<button class="btn btn-default light-grey-btn modal-dismiss" id="close_bank_pop" style="margin-top:0;margin-bottom:10px;">Cancel</button>
						    </div>
				        </div>
				    </div>
				</form>
			</section>
		</div> 
		    
		    
		    <div id="USDbitcoin-modal" class="modal-block modal-block-primary mfp-hide">
			<section class="panel modal-panel">
				<header class="panel-heading">
					<h3 style="margin:0;">Withdraw Bitcoin </h3>
					<button class=" modal-dismiss close">X</button>
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="row inner-paragraph">
                                <div class="col-sm-12">
                                    <p>
                                    <span class="left-text-list">AMOUNT</span>
                                    <span class="val_btc_amount"></span>
                                    </p>
                                    <p>
                                    <span class="left-text-list">ADDRESS</span>
                                    <span class="val_btc_address"></span>
                                    </p><br>
                                </div>
						    </div>
					    </div>
					    	<?php if(isset($g_auth->G_AUTH) && !empty($g_auth->G_AUTH) && $g_auth->G_AUTH == 1){ ?>
					    		<div class="form-group">
	                                <label class="col-md-2 control-label" for="inputDefault">2FA CODE</label>
	                                <div class="col-md-10">
	                                   <input id="inputDefault" class="form-control" type="text">
	                                </div>
	                            </div><br>
					    	<?php } ?>					       
    						<div class="col-md-12 text-right">
    							<i class="fa fa-spinner fa-spin btc_loading" style="font-size:24px"></i>&nbsp;<button class="btn btn-primary light-blue-btn" style="margin-top:0;margin-bottom:10px;">Submit</button>&nbsp;&nbsp;&nbsp;
    							<button class="btn btn-default light-grey-btn modal-dismiss" style="margin-top:0;margin-bottom:10px;">Cancel</button>
    					    </div>
				        </div>
				    </div>
			    </section>
		    </div>
		
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
	    
	    <div id="modaldeposit" class="modal-block modal-block-primary mfp-hide">
										<section class="panel modal-panel">
											<header class="panel-heading">
												<h3 style="margin:0;">USD Wire deposit instructions</h3>
												<button class=" modal-dismiss close">X</button>
											</header>
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<p>PerfektPay can only accept deposits where the bank account holder's name matches the name registered with perfektpay</p><br>
													</div>
												</div>
												<div class="row inner-paragraph" STYLE="TEXT-ALIGN:;">
													<div class="col-sm-12">
													    <p><span class="left-text-list">COMPANY NAME</span>: <b>DURVA GLOBAL RESOURCES (HK) LTD</b></p>
													    <p><span class="left-text-list">BANK NAME</span>: <b>THE HONGKONG AND SHANGHAI BANKING CORPORATION</b></p>
													    <p><span class="left-text-list">BANK ACCOUNT NO</span>: <b>817760465838</b></p>
	                                                    <p><span class="left-text-list">BANK CODE</span>: <b>004</b></p>
	                                                    <p><span class="left-text-list">BANK ADDRESS</span>: <b>1 QUEEN’S ROAD CENTRAL, HONGKONG</b></p> 
	                                                    <p><span class="left-text-list">BANK SWIFT CODE</span>: <b>HSBCHKHHHKH</b></p>
                                                    </div>
                                                    <br>
                                                </div>
												<div class="row">
													<div class="col-sm-12">
													    <p>To expedite your deposite, please email help@perfektpay.com with a screenshot of your wire transfer bank confirmation page with your full name , transfer amount, PERFEKTPAY Wallet Deposit Id & date of transfer.</p>
										 <br>
										<p>USD deposits incur a bank receiving fee of $10 from our bank in addition to the initiation fees and agent fees from your bank.</p>
										 <br>
										<p>We process transfers within 1 business day upon receiving deposits in our bank account.</p>
													</div>
												</div>
											
												<div class="row">
													<div class="col-md-12 text-center">
														<form action="bank_details" method="post" enctype="multipart/form-data">
															{{ csrf_field() }}
															<div class="file-upload" style="text-align: left;">
																Amount you transferred<span style="color:red;">*</span>: <div class='input-group'><span class="input-group-addon"><span class="fa fa-dollar"></span></span><input type="number" class="form-control" name="amount" required=""></div><br>
																<label for="upload" class="file-upload__label">Upload Receipt<span style="color:red;">*</span> <img src="images/upload.png" style="float:right;"></label>
												              	<input id="upload" class="file-upload__input" type="file" name="image_file" style="min-width: 100%;" accept="image/*" required="">
												            </div>
															<button type="submit" class="btn btn-primary light-blue-btn">Submit</button>
														</form>
													</div>
												</div>
											</div>
										</section>
									</div>
									
									
									
					<!-- Modal Form -->
									<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
										<section class="panel modal-panel">
											<header class="panel-heading">
												<h3 style="margin:0;">Your Bitcoin Deposit Address</h3>
												<button class=" modal-dismiss close">X</button>
											</header>
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-12">
														<p>Scan the following QR Code or copy the address into your clipboard. This address should only be used for this deposit. If you need to make another deposit use this same form to generate a new deposit address.</p><br>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-3 qr-image-popup">
														<img class="btc_qr" src="" style="max-width:100%;">
													</div>
													<div class="col-sm-9">
														<input type="text" name="name" class="form-control dark-blue-form btc_address" placeholder="" readonly="" style="color: #fff;background: #003466;"/><br>
														<p>Please note: You will receive an email notification when your deposit is credited to your account. This should occur within five minutes after the 6th blockchain confirmation of your transaction. </p>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 text-center">
														<a class="btn btn-primary" href="check_bitcoin">Check</a>
														<button class="btn"><i class="fa fa-spinner fa-spin"></i> Awaiting for transaction</button>
													</div>
												</div>

											</div>
										</section>
									</div>
									
									

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
						<div class="col-xl-3 col-lg-4">
							<section class="panel inner-panel">
								<header class="panel-heading">
									<h2 class="panel-title">Account: Wallet</h2>
								</header>
								<div class="panel-body no-padding">
									<div class="table-responsive">
										<table class="table table-striped mb-none">
											<thead>
												<tr>
													<th></th>
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
									<div class="panel-body">
									</div>
									<div class="panel-body">
									</div>
									<div class="panel-body no-padding grey-back text-center">
										<img src="assets/images/wallet.png">
										<br>
										<!--<a href="#" class="light-blue">+ New Account</a>-->
									</div>
									
									<div class="panel-body">
									</div>
								</div>
								
							</section>
						</div>
						<div class="col-xl-3 col-lg-4">
							<section class="panel inner-panel">
								<header class="panel-heading">
									<h2 class="panel-title">Deposit</h2>
								</header>
								<div class="panel-body no-padding" style="padding-top:15px;padding-bottom:15px;">
								    <div class="panel-body">
									<div class="form-group">
										<label class="col-md-12 control-label">Currency</label>
										<div class="col-md-12">
											<select class="form-control populate" id="transaction">
													<option value="">--Select--</option>
													<option value="1">Bitcoin</option>
													<!-- <option value="2">XBT Bitcoin</option>
													<option value="3">EUR Euros</option>
													<option value="4">SGD Sigapore Dollars</option> -->
													<option value="5">U.S. Dollars</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<a class="mb-xs mt-xs mr-xs btn btn-default light-grey-btn modal-with-form deposit_amt" type="button" href="#">Deposit</a>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<p class="light-blue" style="margin-bottom:px;"><a href="#" class="modal-with-form">Deposit and withdrawal process explained</a></p>
										</div>
									</div>
									</div>
									<div class="panel-body no-padding grey-back padding-less">
										<img src="assets/images/deposit.png">
										<br>
									</div>
									
									<div class="panel-body">
									</div>
								</div>
								
							</section>
						</div>
						<div class="col-xl-3 col-lg-4">
							<section class="panel inner-panel">
								<header class="panel-heading">
									<h2 class="panel-title">Withdrawal</h2>
								</header>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-md-12 control-label">Currency</label>
										<div class="col-md-12">
											<select class="form-control populate withdrawal_amt">
												
												<option value="1">Bitcoin</option>
												<!-- <option value="2">XBT Bitcoin</option>
												<option value="3">EUR Euros</option>
												<option value="4">SGD Sigapore Dollars</option> -->
												<option value="5">U.S. Dollars</option>
											</select>
										</div>
									</div>
									
									
									<div class="bitcoin-form">
									    <div class="form-group">
										<label class="col-md-12 control-label" for="inputDefault">Address</label>
										<div class="col-md-12">
											<input id="inputDefault" class="form-control btcaddress" type="text">
											<small class="btcaddresssmall" style="color: red"></small>
										</div>
									</div>
									<div class="form-group">
									<label class="col-md-12 control-label">Amount</label>
									<div class="col-sm-12">
										<div class="input-group mb-md">
											<span class="input-group-addon light-blue-back"><i class="fa fa-btc" aria-hidden="true"></i></span>
											<input class="form-control int_field withbtcamount" type="text" placeholder="0.0000">
											<small class="btcsmall" style="color: red"></small>
										</div>
									</div>
									</div>
									
									
									<div class="form-group">
										<div class="col-md-12">
											<button class="mb-xs mt-xs mr-xs btn btn-default light-grey-btn withdraw_bitcoin">Withdraw</button>											 
										</div>
									</div>
									</div>
									
									
									<div class="usd-form"  style="display:none;">
									<div class="form-group">
										<div class="col-sm-12">
											<div class="col-md-8 ">
												<label class="row control-label">Bank</label>
												<div class="row">
													<div class="col-sm-12 div-left">
														<select class="form-control populate bank_name_select">
															<option value="">--Select--</option>
															<?php if(isset($banks) && !empty($banks)){
																foreach ($banks as $bank_det) { ?>
																	<option value="{{$bank_det['id']}}">{{$bank_det['bank_name']}}</option>
																<?php }
															}?>
														</select>
														<small class="bank_name_small" style="color:red"></small>
													</div>
												</div>
											</div>
											<div class="col-md-4 div-right">
												<label class="row control-label"></label>
												<div class="row">
													<button class="btn btn-primary light-blue-btn modal-with-form" style=" height: 35px;min-width:100%;margin-top:5px" type="button" href="#USDdollar-modal">Add New +</button>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
									<label class="col-md-12 control-label">Amount</label>
									<div class="col-sm-12">
										<div class="input-group mb-md">
											<span class="input-group-addon light-blue-back"><i class="fa fa-usd" aria-hidden="true"></i></span>
											<input class="form-control int_field withusdamount" type="text" placeholder="0.00">
											<small class="usdsmall" style="color: red"></small>
										</div>
									</div>
									</div>
									
									
									
									
									<div class="form-group">
										<div class="col-md-12">
											<button class="mb-xs mt-xs mr-xs btn btn-default light-grey-btn withdraw_usdollar">Withdraw</button>
										</div>
									</div>
									</div>
									
									
									
									<div class="form-group">
										<div class="col-sm-12">
										    
											<p class="light-blue" style="margin-bottom:15px;"><a href="#" class="modal-with-form">Deposit and withdrawal process explained</a></p>
											<br>
										</div>
									</div>
								</div>
								
							</section>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<section class="panel inner-panel">
								<header class="panel-heading bottom-border" style="">
									<h2 class="panel-title">Funding History for Wallet</h2>
								</header>
								<div class="panel-body no-padding">
									<div class="table-responsive">
										<table class="table table-striped mb-none">
											<thead>
												<tr class="bottom-border">
													<th>S.No.</th>
													<th>Transaction ID</th>
													<th>Currency</th>
													<th class="text-right">Amount</th>
													<th class="text-center">Status</th>
													<th>Type</th>
													<th>DateTime</th>
												</tr>
											</thead>
											<tbody>
												<?php if(isset($funding_history) && !empty($funding_history)){ 
													foreach ($funding_history as $key => $value) { ?>
														<tr>
															<td class="light-blue">{{$key+1}}</td>
															<td>{{($value['currency']=="Bitcoin"?"BTC":"USD").sprintf("%04s", $value['id'])}}</td>
															<td>{{$value['currency']}}</td>
															<td class="text-right">{{$value['amount'].'.00'}}</td>
															<td class="text-center">{{$value['status'] == 0 ?  "Pending" : "Paid"}}</td>
															<td>{{$value['type'] == 0 ?  "Deposit" : ($value['created_by']==0?"Debit":"Withdrawal")}}</td>
															<td>{{date("d-m-Y h:m:i", strtotime($value['created_at']))}}</td>
														</tr>	
													<?php } 
												 }else{ ?>
													<tr>
														<td class="text-center" colspan="6" style="padding-top:50px;padding-bottom:50px;">
															<img src="assets/images/empty.png"><br>
															<p>There is no funding history to display.</p>
														</td>
													</tr>
												<?php } ?>																											
											</tbody>
										</table>
									</div>
									<div class="panel-body">
									</div>
								</div>
								
							</section>
						</div>
					</div>
					<!-- end: page -->
				</section>
			</div>

@stop