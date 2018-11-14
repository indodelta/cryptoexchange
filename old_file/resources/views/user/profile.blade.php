@extends('user.layouts.layout')
@section('content')
<style>
#support-header {
  display: none;
}
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
.panel {
  box-shadow: none !important;
}
.panel-collapse .panel-body {
    border-radius: 0 !important;
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
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
.panel-heading > a:before {
    float: right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 5px;
}
.panel-heading > a.collapsed:before {
    float: right !important;
    content:"\f067";
}
.panel-heading > a:hover, 
.panel-heading > a:active, 
.panel-heading > a:focus  {
    text-decoration:none;
}
input[type="file"] {
   width: 100%;
}

.kyc-button.btn {
 background: rgb(64, 189, 233) none repeat scroll 0 0;
 color: #fff;
 height: 40px;
 line-height: 40px;
 padding: 0 20px;
 text-decoration: none;
 text-transform: uppercase;
}
</style>



<div id="USDdollar-modal" class="modal-block modal-block-primary mfp-hide">
			<section class="panel modal-panel">
				<header class="panel-heading">
					<h3 style="margin:0;">USD Bank Detail</h3>
					<button class=" modal-dismiss close close_bank_pop">X</button>
				</header>
				<form action="" class="" method="post">
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
		
		
		
		
 <div id="content" class="app-content box-shadow-3" role="main">
    <div class="content-main container" id="content-main" style="margin-top:  50px;">
        <div class="padding">
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

          <!-- start: page -->
          <section class="panel"> 
					<!-- start: page -->
						<div class="row">
							<div class="col-lg-12">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
								    <div class="panel-heading"> 
									     <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><h4><strong>Security</strong></h4></a>
									     <hr>
									</div>
                                    <div  id="collapse1" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">Google Authenticator</label>
                                                    </div>
                                                    <div class="col-sm-12 switch-main">
                                                        <label class="switch">
                                                            <input id='g_auth' type="checkbox" {{($userData['userinfo'][0]->g_auth_flag)?'checked':''}}>
                                                           <span class="slider round"></span>
                                                        
                                                        <span class="inner-left">OFF</span>
                                                        <span class="inner-right">ON</span>
                                                        </label><br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="panel panel-default">
									<div class="panel-heading"> 
									     <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" ria-expanded="false" class="collapsed"><h4><strong>Personal Information</strong></h4></a>
									     <hr>
									</div>
									 <div  id="collapse2" class="panel-collapse collapse">
									     
								<form action="" method="post" >
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="enc_id" value="{{Crypt::encrypt($userData['userinfo'][0]->user_id)}}">
									<div class="panel-body">									
										<?php
										/*echo "<pre>";
										print_r($userData);
										echo "</pre>";*/
										?>
										
										
										<div class="row">
										    <div class="col-sm-12">
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
										</div>

										<div class="row">
										    <div class="col-sm-12">
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
										</div>
										<div class="col-sm-12">
    										<div class="row">
    											<div class="col-sm-12">
    											    <br>
    										        <input type="submit" class="btn btn-primary btn-sm" name="submit" value="Update information">						</div>	
    										        <br>
    										<!-- <button class="btn btn-primary btn-xs">Update information</button> -->
    									    </div>
									    </div>
									   </div>
								</form>	
							</div>
						</div>
								
								
								
							
						<div class="panel panel-default">
							<div class="panel-heading"> 
							    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" ria-expanded="false" class="collapsed"><h4><strong>KYC</strong></h4></a>
								<hr>
							</div>
							<div  id="collapse3" class="panel-collapse collapse">
								 <div class="panel-body">
										    <div class="row">

        									@if(isset($userData))
                                                    @foreach($userData['userinfo'] as $val)
                                                    	<div class="col-sm-6">
                                                    		<div class="form-group">					 
                                                    			
                                                    				@if(isset($val->kyc_name))
                                                    				@if(isset($val->kyc_name) && $val->kyc_name == 1)
                                                    				<div class="displaying-image-style">
                                                    					<h5>National Id</h5>
                                                    					<img id="output2" src="{{env('UPLOADED_USER_IMAGES')}}{{$val->image}}" alt="" />
                                                    					</div>
                                                    					<div class="col-sm-12 listing-class">
                                                    						@foreach($userData['kycinfo'] as $kycinfo)
                                                    							@if(isset($kycinfo->kyc_name) && $kycinfo->kyc_name == 1 && $kycinfo->user_id == $val->user_id)
                                                    								@if($kycinfo->status=='1')
                                                    									<button class="btn btn-success" type="button">Approved</button>
                                                    								@elseif($kycinfo->status=='0')
                                                    									<button class="btn btn-info" type="button">Pending</button>
                                                    								@else
                                                    									<small style='color:red;'>Your submitted document is rejected</small>
                                                    									<form id="uploadfile_profile" method="post" enctype="multipart/form-data">						 {{ csrf_field() }}	
                                                    										<input type="hidden" name="u__token" value='{{md5(Session::get("user_id"))}}'>
                                                    										<input type="hidden" name="sta__token" value="{{md5(1)}}">
                                                    										<div class="file-upload col-sm-offset-2 col-sm-6">
                                                    							              	<label for="upload" class="file-upload__label">Upload Document <img src="images/upload.png" style="float:right;"></label>
                                                    							              	<input id="upload" class="file-upload__input" type="file" name="image_file" accept="image/*" onchange="loadFile2(event)" required="">
                                                    							            </div>																	
                                                    										<i class="fa fa-spinner fa-spin loading" style="font-size:24px; display: none;"></i>&nbsp;<button class="btn btn-success" type="submit" style="float: left;">Submit</button>
                                                    									</form>
                                                    								@endif
                                                    							@endif			
                                                    						@endforeach
                                                    					</div>	
                                                    				@elseif(isset($val->kyc_name) && $val->kyc_name == 2)
                                                    				<div class="displaying-image-style">
                                                    					<h5>Address Proof</h5>
                                                    					<img id="output" src="{{env('UPLOADED_USER_IMAGES')}}{{$val->image}}" alt="" />
                                                    					</div>
                                                    					<div class="col-sm-12 listing-class">
                                                    						@foreach($userData['kycinfo'] as $kycinfo)
                                                    							@if(isset($kycinfo->kyc_name) && $kycinfo->kyc_name == 2 && $kycinfo->user_id == $val->user_id)
                                                    								@if($kycinfo->status=='1')
                                                    									<button class="btn btn-success" type="button">Approved</button>
                                                    								@elseif($kycinfo->status=='0')
                                                    									<button class="btn btn-info" type="button">Pending</button>
                                                    								@else
                                                    									<small style='color:red;'>Your submitted document is rejected</small>
                                                    									<form id="uploadfile_profile" method="post" enctype="multipart/form-data">						 {{ csrf_field() }}	
                                                    										<input type="hidden" name="u__token" value='{{md5(Session::get("user_id"))}}'>
                                                    										<input type="hidden" name="sta__token" value="{{md5(1)}}">
                                                    										<div class="file-upload col-sm-offset-2 col-sm-6">
                                                    							              	<label for="upload" class="file-upload__label">Upload Document <img src="images/upload.png" style="float:right;"></label>
                                                    							              	<input  class="file-upload__input" type="file" name="image_file" accept="image/*" onchange="loadFile(event)" required="">
                                                    							            </div>																	
                                                    										<i class="fa fa-spinner fa-spin loading" style="font-size:24px; display: none;"></i>&nbsp;<button class="btn btn-success" type="submit" style="float: left;">Submit</button>
                                                    									</form>
                                                    								@endif
                                                    							@endif			
                                                    						@endforeach
                                                    					</div>
                                                    				@endif	
                                                    				@else
                                                    				
                                                    					<a class="kyc-button btn" href="{{url('kyc')}}">click here to upload kyc</a>
                                                    						
                                                    				@endif	
                                                    	
                                                    		</div>
                                                    	</div>	
                                                    	@if(sizeof($userData['userinfo'])==1 && $val->kyc_name!=NULL)
                                                    	<div class="col-sm-6">
                                                    		<div class="form-group">					 
                                                    			<div class="displaying-image-style">
                                                    				@if($val->kyc_name == 1)
                                                    				<h5>Address Proof</h5>
                                                    					<img id="output" src="{{URL('/admin_assets/assets/images/id-card.png')}}" alt="" />
                                                    					</div>
                                                    					<div class="col-sm-12 listing-class">
                                                    						<form id="uploadfile_profile" method="post" enctype="multipart/form-data">						 {{ csrf_field() }}	
                                                    										<input type="hidden" name="u__token" value='{{md5(Session::get("user_id"))}}'>
                                                    										<input type="hidden" name="sta__token" value="{{md5(1)}}">
                                                    										<div class="file-upload col-sm-offset-2 col-sm-6">
                                                    							              	<label for="upload" class="file-upload__label">Upload Document <img src="images/upload.png" style="float:right;"></label>
                                                    							              	<input  class="file-upload__input" type="file" name="image_file" accept="image/*" onchange="loadFile(event)" required="">
                                                    							            </div>																	
                                                    										<i class="fa fa-spinner fa-spin loading" style="font-size:24px; display: none;"></i>&nbsp;<button class="btn btn-success" type="submit" style="float: left;">Submit</button>
                                                    									</form>
                                                    					</div>
                                                    				@else
                                                    					<h5>National Id</h5>
                                                    					<img id="output2" src="{{URL('/admin_assets/assets/images/id-card.png')}}" alt="" />
                                                    					</div>
                                                    					<div class="col-sm-12 listing-class">
                                                    							<form id="uploadfile_profile" method="post" enctype="multipart/form-data">						 {{ csrf_field() }}	
                                                    										<input type="hidden" name="u__token" value='{{md5(Session::get("user_id"))}}'>
                                                    										<input type="hidden" name="sta__token" value="{{md5(1)}}">
                                                    										<div class="file-upload col-sm-offset-2 col-sm-6">
                                                    							              	<label for="upload" class="file-upload__label">Upload Document <img src="images/upload.png" style="float:right;"></label>
                                                    							              	<input  class="file-upload__input" type="file" name="image_file" accept="image/*" onchange="loadFile2(event)" required="">
                                                    							            </div>																	
                                                    										<i class="fa fa-spinner fa-spin loading" style="font-size:24px; display: none;"></i>&nbsp;<button class="btn btn-success" type="submit" style="float: left;">Submit</button>
                                                    									</form>
                                                    					</div>
                                                    					@endif	
                                                    		</div>		
                                                    	</div>			
                                                    	
                                                    	@endif
                                                    @endforeach
                                                @endif			
										    </div>
								        </div>
							        </div>
							    </div>
								    
								
                                
                                <div class="panel panel-default">
								    <div class="panel-heading"> 
									     <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" ria-expanded="false" class="collapsed"><h4><strong>Bank Details</strong></h4></a>
									     <hr>
									</div>
                                <div id="collapse4" class="panel-collapse collapse">
                                    <div class="panel-body " style="max-hieght:400px;overflow:auto;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <a class="kyc-button btn modal-with-form" href="#USDdollar-modal">Add New +</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">

                                        	<?php if(isset($banks) && !empty($banks)){
                                    		foreach ($banks as $bank_det) { ?>
                                    		<form action="{{url('ubank')}}" method="post">
                                    		{{ csrf_field() }}
                                    		<input type="hidden" name="encbnk" value="{{Crypt::encrypt($bank_det['id'])}}">
                                            <div class="col-sm-12 main-bank-inner">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <h4>{{$bank_det['bank_name']}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                             <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <label class="control-label">Bank Name</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input id="bank_name" class="form-control" type="text" name="bank_name" value="{{$bank_det['bank_name']}}" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                             <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <label class="control-label">BENEFICIARY NAME</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input id="beneficiary_name" class="form-control" type="text" name="beneficiary_name" value="{{$bank_det['beneficiary_name']}}" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                             <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <label class="control-label">BENEFICIARY ACCOUNT NO.</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input id="beneficiary_account_no" class="form-control int_field" type="text" name="beneficiary_account_no" required="" value="{{$bank_det['beneficiary_account_no']}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                             <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <label class="control-label">SWIFT CODE</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <input id="swift_code" class="form-control" type="text" name="swift_code" required="" value="{{$bank_det['swift_code']}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
												        <div class="col-sm-12">
												            <div class="col-sm-12">
												                <br>
        												    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                            <a type="submit" class="btn btn-danger btn-sm" href="dbank/{{Crypt::encrypt($bank_det['id'])}}" onclick="return confirm('Are you sure you want to delete this bank?');">Delete</a>        
                                                        </div>
                                                </div>
                                                </div>
                                                <hr>
                                            </div>	
                                            </form>
                                            <?php } } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div> 
					</div>
				</div>
          </section>  
        </div>
    </div> 
     <script>
    function loadFile2(event) {
	    var output2 = document.getElementById('output2');
	    console.log("loadFile2");
	    output2.src = URL.createObjectURL(event.target.files[0]);
	  }
    function loadFile(event) {
	    var output = document.getElementById('output');
	    console.log("loadFile");
	    output.src = URL.createObjectURL(event.target.files[0]);
	  }

    $('input:checkbox').change(
    function(e){
        if ($(this).is(':checked')) {
        	var order = {['_token']:'{{csrf_token()}}'};
      $.ajax({
        type:'post', 
        url:'{{route("check_checked")}}',
        data:order,
        dataType:'json',
        success:function(newdata){
           
             //alert(newdata);
    if(newdata.success==1)
     { 
     window.location = "{{route('g_security')}}";
       window.open("{{route('g_security')}}","_self");      
}
else
{
	swal("Cancelled", "Your Google Authenticator has not been disabled", "error");
}   
    },
    error:function(newdata){
        console.log(newdata);
    }
}); 
            
        }
        else{

    swal({
        title: "Are you sure?",
        text: "Your account will loose 2-FA !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes disabled it!",
        closeOnConfirm: false
    }, function (isConfirm) {
    	  if (isConfirm) {
    	  	var order = {['_token']:'{{csrf_token()}}'};
    	  	 $.ajax({
        type:'post', 
        url:'{{route("check_unchecked")}}',
        data:order,
        dataType:'json',
        success:function(newdata){
           
             //alert(newdata);
    if(newdata.success==1)
     { 
      swal("Done!", "Your Google Authenticator has been disabled.", "success"); 
      $('#g_auth').prop('checked', false);   
}
else
{
	swal("Cancelled", "Your Google Authenticator has not been disabled", "error");
	  $('#g_auth').click();
}   
    },
    error:function(newdata){
        console.log(newdata);
    }
}); 
    
  } else {
   
     $('#g_auth').click();
    
  }
    });

        	
        }
    });

</script> 
@stop