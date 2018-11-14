@extends('layouts.app')
@section('content')
	<style>
	.sign-back{
		background: hsla(0, 0%, 0%, 0) url("images/back-img.jpg") repeat scroll 0 0;
	}
#recaptcha > div {
  margin: auto;
}
.g-recaptcha {
  border: medium none !important;
}
.welcome-side > img {
  display: block;
  margin: auto;
  padding: 75px 0;
}
.welcome-label {
  font-size: 16px;
  font-weight: normal;
}
.form-control.sign-up-fields {
  border-radius: 7px;
  color: #000;
  font-size: 17px;
  height: 45px;
}
.log-in {
  background: transparent none repeat scroll 0 0;
  border: 2px solid #6dcff6;
  border-radius: 7px;
  color: #6dcff6;
  font-size: 18px;
  height: 45px;
  padding: 0 30px;
}
.btn.btn-default.log-in:hover{
  background:#6dcff6 !important;
  border: 2px solid #6dcff6 !important;
  color: #fff !important;
}
.mobile-log-in {
  color: #fff;
  font-size: 15px;
  text-align: center;
}
.mobile-log-in:hover {
  color: #fff;
}
.btn.btn-default.sign-button {
  background: hsla(0, 0%, 0%, 0) url("images/sign-button-back.jpg") repeat scroll 0 0;
  border: medium none hsla(0, 0%, 0%, 0);
  color: hsl(0, 0%, 0%);
  font-size: 21px;
  height: 50px;
  text-align: left;
  width: 100%;
}
.cross {
  color: hsl(0, 100%, 50%);
  float: right;
  font-size: 20px;
  padding-top: 5px;
}
.captch_err{color:red;}
	</style>
  </head>
  <body class="sign-back">

	<section class="sign-up-form">
	<div class="container">
	<div class="row">
	<section class="about-banner" style="background:none;padding:20px 0 0;">
		<div class="container">
		<p><div class="banner-list">
         	<ul style='visibility:hidden'>
						<li>BUY BTC: <i class="fa fa-inr" aria-hidden="true"></i> 175,667</li>
						<li>SELL BTC: <i class="fa fa-inr" aria-hidden="true"></i> 170,837</li>
					</ul>
		</div> </p>
	</section>
	<div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 inner-area" style="margin-top:30px;padding:0;background:rgba(49, 155, 193, 0.5) url('images/logo-large.png') no-repeat scroll center center; text-align:center;">
	<h2>Welcome Back!</h2>
	<p>Sign in to your wallet</p>

@foreach($errors->all() as $error)
    <div class="alert alert-dismissable alert-danger">{{ $error }}</div>
@endforeach  
<span id="error-alertl"></span>
@if(isset($CaptchaErr))
    <div class="alert alert-danger fade in close-alert" id="error-alert">{{$CaptchaErr}}</div>
@endif

<form method="post" style="padding-top:20px;" id="login_detail">
  {{ csrf_field() }}
  <div class="form-group" style="text-align:left;">
  <label for="id" class="welcome-label" >Email Id/Username</label>
    <input type="id" class="form-control sign-up-fields" required placeholder="" id="email" name="login" >
  </div>
  <div class="form-group" style="text-align:left;">
  <label for="pwd" class="welcome-label"  >Password</label>
    <input type="password" class="form-control sign-up-fields" required placeholder="" id="password" name="password">
  </div>

  <div class="form-group">
      <div class="">
       <!--<img src="{{url('/images/robot.png')}}" class="img-responsive" alt="Image">-->
      </div>
      <div class="col-sm-12" style="padding-bottom: 15px;margin-left: 0px;">
         <div id="recaptcha" class="g-recaptcha" data-callback="correctCaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}" style="margin:auto;display:block;"></div>
         <small class="captch_err"></small>
      </div>
  </div>

  <br>
  <div class="form-group">
  <button type="submit" class="btn btn-default log-in" id="login">LOG IN</button>
  </div>
  <div class="form-group">
  <p style="font-size:16px;">Having some trouble? <a href="forgot_password" style="color:#6dcff6; text-decoration:none;">Forgot Password</a></p>
  </div>
  
  <br>
  </form> 
  </div>
</div>
 
	</div>
	</div>
	</section>
	
@stop