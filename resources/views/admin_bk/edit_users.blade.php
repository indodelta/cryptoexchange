@extends('admin.layout.layout')
@section('content')
<style>
.displaying-image-style {
	border: 1px solid #bbb !important;
    border-radius: 10px;
    display: block;
    margin: auto auto 10px;
    padding: 15px;
    text-align: left;
    height:280px;
    max-width:100%;
    width:360px;
}

.displaying-image-style img {
    max-width: 100%;
    max-height: 200px;
    margin: auto;
    display: block;
    overflow: hidden;
}
.listing-class {
    text-align: center;
}
</style>

 <div id="content" class="app-content box-shadow-3" role="main">
    <div class="content-main " id="content-main">
        <div class="padding">
          @if(Session::has('message'))
                  <div id="modalFullColorSuccess" class="modal fade modal-block-success modal-full-color data-show role="dialog"">
                  <div class="modal-dialog">
                      <section class="panel">
                        <header class="panel-heading" style="border-bottom:
                        0px;">
                          <h2 class="panel-title">Success!</h2>
                        </header>
                        <div class="panel-body" style="background:#5CB85C; color:#fff">
                          <div class="modal-wrapper">
                            <div class="modal-icon" style="color:#fff">
                              <i class="fa fa-check"></i>
                            </div>
                            <div class="modal-text">
                              <h4>Success!</h4>
                              <p>{{ Session::get('message') }}.</p>
                            </div>
                          </div>
                        </div>
                        <footer class="panel-footer" style=" border-top: 0 none;">
                          <div class="row">
                            <div class="col-md-12 text-right">
                              <button class="btn btn-default modal-dismiss" data-dismiss="modal" aria-hidden="true">Ok</button>
                            </div>
                          </div>
                        </footer>
                      </section>
                      </div>
                    </div> 
                    @endif

                    
                    @if(Session::has('error'))                    
                      <div id="modalFullColorSuccess" class="modal fade  modal-full-color modal-block-danger">
                                        <div class="modal-dialog">
                                            <section class="panel">
                                                <header class="panel-heading" style="border-bottom:
                                                0px;">
                                                    <h2 class="panel-title" style="color:#fff">Error!</h2>
                                                </header>
                                                <div class="panel-body" style="color:#fff; background:#D9534F ;">
                                                    <div class="modal-wrapper">
                                                        <div class="modal-icon">
                                                            <i class="fa fa-times-circle" style="color:#fff"></i>
                                                        </div>
                                                        <div class="modal-text" >
                                                            <h4>Sorry</h4>
                                                            <p>{{ Session::get('error') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <footer class="panel-footer" style=" border-top: 0 none;">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                                <button class="btn btn-default modal-dismiss" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </section>
                                            </div>
                                      </div>
                    @endif

          <!-- start: page -->
          <section class="panel panel-featured"> 
					<!-- start: page -->
						<div class="row">
							<div class="col-lg-12">
								<section class="panel panel-featured">
									<header class="panel-heading">
										<div class="panel-actions">
										</div>
						
										<h2 class="panel-title">
										@if(isset($userData['userinfo'][0]->name))
										 {{$userData['userinfo'][0]->name}}
										@endif 
										 </h2>
									</header>
								<form action="{{env('APP_URL_ADMIN_ACTION')}}/update-userinfo" method="post" >
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="id" value="{{Crypt::encrypt($userData['userinfo'][0]->id)}}">
									<div class="panel-body">
									<!--	<div class="row vertical-align-btn">
											<div class="col-sm-6">
												<h4><strong>Account Information</strong></h4>
											</div>
											<div class="col-sm-6">
												<button class="btn btn-primary btn-xs pull-right">Update information</button>
											</div>
										</div>-->
                
										@if(Session::has('message'))
											<!--	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
										@endif
										<hr>
										<!--<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Registration Date & Time</label>
													<p><strong>
														@if(isset($userData->register_date))
														 {{$userData->register_date}}
														@endif 
													</strong></p>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Investment History</label>
													<p><strong>Click here</strong></p>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Total Investment</label>
													<p><strong>
													$ 	@if(isset($userData->total_invested))
														 {{$userData->total_invested}}
														@endif 
													</strong></p>
												</div>
											</div>
										</div>-->
									<!--	<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Total ROI Taken</label>
													<p><strong>
													$ 	@if(isset($userData->name))
														 {{$userData->name}}
														@endif 
													</strong></p>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Total Earning</label>
													<p><strong>
													$ 	@if(isset($userData->name))
														 {{$userData->name}}
														@endif 
													</strong></p>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Total Team</label>
													<p><strong>5</strong></p>
												</div>
											</div>
										</div>-->
										<?php
										/*echo "<pre>";
										print_r($userData);
										echo "</pre>";*/
										?>
										<h4><strong>Personal Information</strong></h4>
										<hr>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">User Name</label>
													<input type="text" name="username" value="@if(isset($userData['userinfo'][0]->username)){{$userData['userinfo'][0]->username}}@endif" class="form-control" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">First Name</label>
													<input type="text" name="first_name" value="@if(isset($userData['userinfo'][0]->first_name)){{$userData['userinfo'][0]->first_name}}@endif" class="form-control" >
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Last Name</label>
													<input type="text" name="last_name" value="@if(isset($userData['userinfo'][0]->last_name)){{$userData['userinfo'][0]->last_name}}@endif" class="form-control" >
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Email ID</label>
													<input type="email" name="email" value="@if(isset($userData['userinfo'][0]->email)){{$userData['userinfo'][0]->email}}@endif" class="form-control" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Phone Number</label>
													<input type="text" name="mobile_no" value="@if(isset($userData['userinfo'][0]->mobile_no)){{$userData['userinfo'][0]->mobile_no}}@endif" class="form-control" maxlength="10">
												</div>												
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Address</label>
													<input type="text" name="address" value="@if(isset($userData['userinfo'][0]->address)){{$userData['userinfo'][0]->address}}@endif" class="form-control" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">City</label>
													<input type="text" name="city" value="@if(isset($userData['userinfo'][0]->city)){{$userData['userinfo'][0]->city}}@endif" class="form-control" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">State</label>
													<input type="text" name="state" value="@if(isset($userData['userinfo'][0]->state)){{$userData['userinfo'][0]->state}}@endif" class="form-control" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Zip code</label>
													<input type="text" name="zip_code" value="@if(isset($userData['userinfo'][0]->zip_code)){{$userData['userinfo'][0]->zip_code}}@endif" class="form-control" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
<!-- 													<label class="control-label">Country</label>
													<input type="text" name="country" value="@if(isset($userData[0]->country)){{$userData[0]->country}}@endif" class="form-control" > -->
													<label class="control-label">Country</label>
													 <select id="country" class="form-control" name="country">
                                                          @foreach ($userData['country'] as $val)
                                                              @if(($userData['userinfo'][0]->country) == $val->id)
                                                                  <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                                              @else
                                                              <option value="{{$val->id}}">{{$val->name}}</option>
                                                              @endif
                                                          @endforeach
                                                      </select>
												</div>
											</div>
										</div>
									<footer class="panel-footer">
										<input type="submit" class="btn btn-primary btn-xs" name="submit" value="Update information">									
										<!-- <button class="btn btn-primary btn-xs">Update information</button> -->
									</footer>
								</form>		
<!-- 										<hr>
										<h4><strong>Referral Information</strong></h4>
										<hr>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Referral ID</label>
													<input type="text" name="refid" value="@if(isset($userData->parent_username)){{$userData->parent_username}}@endif" class="form-control" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Ref. First Name</label>
													<input type="text" name="rfirstname" value="@if(isset($userData->parent_name)){{$userData->parent_name}}@endif" class="form-control" disabled>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Ref. Last Name</label>
													<input type="text" name="rlastname" value="@if(isset($userData->parent_lastname)){{$userData->parent_lastname}}@endif" class="form-control" disabled>
												</div>
											</div>
										</div>
										<hr>
										<h4><strong>Banking Information</strong></h4>
										<hr>
									<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Beneficiary Name</label>
													<input type="text" name="beneficiary_name" value="@if(isset($userData->beneficiary_name)){{$userData->beneficiary_name}}@endif" class="form-control">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Bank Name</label>
													<input type="text" name="bank_name" value="@if(isset($userData->bank_name)){{$userData->bank_name}}@endif" class="form-control">
												</div>
											</div>											
											
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Bank Account Number</label>
													<input type="text" name="account_number" value="@if(isset($userData->account_number)){{$userData->account_number}}@endif" class="form-control">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">IFSC Code/Swift Code</label>
													<input type="text" name="ifsc" value="@if(isset($userData->ifsc)){{$userData->ifsc}}@endif" class="form-control">
												</div>
											</div>
										</div>
										<hr>
										<h4><strong>Bitcoin Profile</strong></h4>
										<hr>
										<div class="row">											
											<div class="col-sm-12">
												<div class="form-group">
													<label class="control-label">Bitcoin Address</label>
													<input type="text" name="bitcoin_address" value="@if(isset($userData->bitcoin_address)){{$userData->bitcoin_address}}@endif" class="form-control">
												</div>
											</div>
										</div>-->
								<form action="{{env('APP_URL_ADMIN_ACTION')}}/update-userkycinfo" method="post" >	
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="id" value="{{Crypt::encrypt($userData['userinfo'][0]->id)}}">
										<hr> 										
										<h4><strong>KYC</strong></h4>
										<hr>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">					 
													<div class="displaying-image-style">
														<h5>National Id</h5>

														@if(isset($userData['userinfo'][0]->kyc_name) || isset($userData['userinfo'][1]->kyc_name))
															@if(isset($userData['userinfo'][0]->kyc_name) && $userData['userinfo'][0]->kyc_name == 1)
																<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][0]->image}}" alt="" />	
																<input type="hidden" name="nation_kyc_id" value="{{Crypt::encrypt($userData['userinfo'][0]->kyc_id)}}">
															@elseif(isset($userData['userinfo'][1]->kyc_name) && $userData['userinfo'][1]->kyc_name == 1)
																<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][1]->image}}" alt="" />
																<input type="hidden" name="nation_kyc_id" value="{{Crypt::encrypt($userData['userinfo'][1]->kyc_id)}}">
															@endif 
														@else
															<img id="blah" src="{{URL('/admin_assets/assets/images/id-card.png')}}" alt="" />											
														@endif
													</div>
														<div class="col-sm-12 listing-class">
														@if(isset($userData['kycinfo'][0]->kyc_name) && $userData['kycinfo'][0]->kyc_name == 1 && $userData['kycinfo'][0]->user_id == $userData['userinfo'][0]->id)
															@if($userData['kycinfo'][0]->status==1)
															<label class="radio-inline"><input type="radio" name="nationradio" value="1" checked="checked">Approve</label>&nbsp;&nbsp;&nbsp;
															@else
															<label class="radio-inline"><input type="radio" name="nationradio" value="1">Approve</label>&nbsp;&nbsp;&nbsp;
															@endif
															@if($userData['kycinfo'][0]->status==2)
															<label class="radio-inline"><input type="radio" name="nationradio" value="2" checked="checked">Reject</label>
															@else
															<label class="radio-inline"><input type="radio" name="nationradio" value="2">Reject</label>
															@endif
														@elseif(isset($userData['kycinfo'][1]->kyc_name) && $userData['kycinfo'][1]->kyc_name == 1 && $userData['kycinfo'][1]->user_id == $userData['userinfo'][1]->id)			
															@if($userData['kycinfo'][1]->status==1)
															<label class="radio-inline"><input type="radio" name="nationradio" value="1" checked="checked">Approve</label>&nbsp;&nbsp;&nbsp;
															@else
															<label class="radio-inline"><input type="radio" name="nationradio" value="1">Approve</label>&nbsp;&nbsp;&nbsp;
															@endif
															@if($userData['kycinfo'][1]->status==2)
															<label class="radio-inline"><input type="radio" name="nationradio" value="2" checked="checked">Reject</label>
															@else
															<label class="radio-inline"><input type="radio" name="nationradio" value="2">Reject</label>
															@endif
														@endif	
														</div>													
													</div>	
												</div>	 
											<div class="col-sm-6">
												<div class="form-group">					 
													<div class="displaying-image-style">
														<h5>Address Proof</h5>
														@if(isset($userData['userinfo'][0]->kyc_name) || isset($userData['userinfo'][1]->kyc_name))
															@if(isset($userData['userinfo'][0]->kyc_name) && $userData['userinfo'][0]->kyc_name == 2)
																<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][0]->image}}" alt="" />	
																<input type="hidden" name="address_kyc_id" value="{{Crypt::encrypt($userData['userinfo'][0]->kyc_id)}}">
															@elseif(isset($userData['userinfo'][1]->kyc_name) && $userData['userinfo'][1]->kyc_name == 2)
																<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][1]->image}}" alt="" />
																<input type="hidden" name="address_kyc_id" value="{{Crypt::encrypt($userData['userinfo'][1]->kyc_id)}}">
															@endif	
														@else
															<img id="blah" src="{{URL('/admin_assets/assets/images/id-card.png')}}" alt="" />											
														@endif		
													</div>
													<div class="col-sm-12 listing-class">
													@if(isset($userData['kycinfo'][0]->kyc_name) && $userData['kycinfo'][0]->kyc_name == 2 && $userData['kycinfo'][0]->user_id == $userData['userinfo'][0]->id)
														@if($userData['kycinfo'][0]->status==1)
														<label class="radio-inline"><input type="radio" name="addradio" value="1" checked="checked">Approve</label>&nbsp;&nbsp;&nbsp;
														@else
														<label class="radio-inline"><input type="radio" name="addradio" value="1">Approve</label>&nbsp;&nbsp;&nbsp;
														@endif

														@if($userData['kycinfo'][0]->status==2)
														<label class="radio-inline"><input type="radio" name="addradio" value="2" checked="checked">Reject</label>
														@else
														<label class="radio-inline"><input type="radio" name="addradio" value="2">Reject</label>
														@endif

													@elseif(isset($userData['kycinfo'][1]->kyc_name) && $userData['kycinfo'][1]->kyc_name == 2 && $userData['kycinfo'][1]->user_id == $userData['userinfo'][1]->id)
														@if($userData['kycinfo'][1]->status==1)
														<label class="radio-inline"><input type="radio" name="addradio" value="1" checked="checked">Approve</label>&nbsp;&nbsp;&nbsp;
														@else
														<label class="radio-inline"><input type="radio" name="addradio" value="1">Approve</label>&nbsp;&nbsp;&nbsp;
														@endif

														@if($userData['kycinfo'][1]->status==2)
														<label class="radio-inline"><input type="radio" name="addradio" value="2" checked="checked">Reject</label>
														@else
														<label class="radio-inline"><input type="radio" name="addradio" value="2">Reject</label>
														@endif	
													@endif	
													</div>	


												</div>
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<input type="submit" class="btn btn-primary btn-xs" name="submit" value="Submit">
										<!-- <button class="btn btn-primary btn-xs">Update information</button> -->
									</footer>
								</form>	
								</section>
							</div>
						</div>
          </section>  
        </div>
    </div> 
@stop