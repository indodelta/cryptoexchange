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
<!--popup model start-->
<div id="m-a-a" class="modal fade" data-backdrop="true">
  <div class="modal-dialog animate" id="animate">
    <div class="modal-content">
      <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">X</button> 
      <div class="modal-body text-center p-lg">
        <img src="" id="zoomkyc" style="width:100%; max-height: 600px;">
      </div>
    </div>
  </div>
</div>
<!-- Main -->
<div class="content-main " id="content-main">
	<!-- ############ Main START-->
  @if(Session::has('message')) 
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        successAlert('{{Session::get('message')}}');
    }, false);
    </script>
  @endif 	
	<!-- start: page -->
	<div class="padding">
		<div class="box">
			<div class="box-header">
				<h3>Personal Information</h3>
			</div>
			<div class="box-divider m-0"></div>
			<div class="p-2">

				<form action="{{env('APP_URL_ADMIN_ACTION')}}/update-userinfo" method="post" >
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{Crypt::encrypt($userData['userinfo'][0]->id)}}">
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
						<div class="col-sm-4"> 
							<div class="form-group">
								<label class="control-label">Email ID</label>
								<input type="email" name="email" value="@if(isset($userData['userinfo'][0]->email)){{$userData['userinfo'][0]->email}}@endif" class="form-control" disabled>
							</div>
						</div>						
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Date of Birth</label>
								<input type="text" name="mobile_no" value="@if(isset($userData['userinfo'][0]->dob)){{date("d-m-Y", strtotime($userData['userinfo'][0]->dob))}}@endif" class="form-control" maxlength="10" disabled>
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
					<div class="row">
						<div class="col-sm-4"></div>
						<div class="col-sm-6"></div>
						<div class="col-sm-2">
							<div class="form-group">
								<input type="submit" class="btn btn-info" name="submit" value="Update information">
							</div>
						</div>		
					</div>
				</form>  
			</div>
		</div>

<div class="box">
			<div class="box-header">
				<h3>KYC</h3>
			</div>
			<div class="box-divider m-0"></div>
			<div class="p-2">
				<form action="{{env('APP_URL_ADMIN_ACTION')}}/update-userkycinfo" method="post" >	
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{Crypt::encrypt($userData['userinfo'][0]->id)}}">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">					 
								<div class="displaying-image-style">
									<h5>National Id</h5>

									@if(isset($userData['userinfo'][0]->kyc_name) || isset($userData['userinfo'][1]->kyc_name))
									@if(isset($userData['userinfo'][0]->kyc_name) && $userData['userinfo'][0]->kyc_name == 1)

									<a data-toggle="modal" data-target="#m-a-a" class='zoomexx'>
									 <img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][0]->image}}" alt="" />	
									</a>

									<input type="hidden" name="nation_kyc_id" value="{{Crypt::encrypt($userData['userinfo'][0]->kyc_id)}}">
									@elseif(isset($userData['userinfo'][1]->kyc_name) && $userData['userinfo'][1]->kyc_name == 1)

									<a data-toggle="modal" data-target="#m-a-a" class='zoomexx'>
									<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][1]->image}}" alt="" />
									</a>

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

										<a data-toggle="modal" data-target="#m-a-a" class='zoomexx'>
											<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][0]->image}}" alt="" />	
										</a>

										<input type="hidden" name="address_kyc_id" value="{{Crypt::encrypt($userData['userinfo'][0]->kyc_id)}}">
										@elseif(isset($userData['userinfo'][1]->kyc_name) && $userData['userinfo'][1]->kyc_name == 2)

										<a data-toggle="modal" data-target="#m-a-a" class='zoomexx'>
											<img id="blah" src="{{env('UPLOADED_USER_IMAGES')}}{{$userData['userinfo'][1]->image}}" alt="" />
										</a>

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
					<div class="row">
						<div class="col-sm-4"></div>
						<div class="col-sm-6"></div>
						<div class="col-sm-2">
							<div class="form-group">
								<input type="submit" class="btn btn-info" name="submit" value="Update information">
							</div>
						</div>		
					</div>
				</form>  
			</div>
		</div>
	</div>
</div> 
<!-- Main END-->
@endsection