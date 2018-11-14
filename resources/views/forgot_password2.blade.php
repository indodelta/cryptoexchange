@extends('layouts.app')
@section('content')
	<style>
	.sign-back{
		background: hsla(0, 0%, 0%, 0) url("{{env("APP_URL_ADMIN")}}/images/back-img.jpg") repeat scroll 0 0;
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
  background: hsla(0, 0%, 0%, 0) url("{{env("APP_URL_ADMIN")}}/images/sign-button-back.jpg") repeat scroll 0 0;
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


	</style>
  </head>
  <body class="sign-back">

	<section class="sign-up-form">
	<div class="container">
	<div class="row">

	<div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 inner-area" style="margin-top:90px;padding:0;background:rgba(49, 155, 193, 0.5) url('images/logo-large.png') no-repeat scroll center center; text-align:center;">
	<h2>Forgot Password</h2>
	 <form style="padding-top:20px;" action=""  method="post">
  <div class="form-group" style="text-align:left;">
    @csrf
  <label for="pwd" class="welcome-label" >New password</label>
    <input type="password" class="form-control sign-up-fields" name="password" placeholder="password" id="password">
  </div>
  <div class="form-group" style="text-align:left;">
  <label for="pwd" class="welcome-label" >Confirm password</label>
    <input type="password" class="form-control sign-up-fields" name="password_confirmation" placeholder="confirm password " id="password">
     @if(isset($token))       
                    <input type="hidden" value="{{ $token }}" name="token" />
            
            @elseif(isset($res))
            <input type="hidden" value="{{ $res['token'] }}" name="token" />
            @endif 
  </div>
  <br>
  <div class="form-group">
  <button type="submit" class="btn btn-default log-in">SUBMIT</button>
  </div>
    <div class="form-group">
  <p><a href="signup" class="mobile-log-in">Sign Up</a></p>
  </div> 
  </form> 
     @if(isset($res))
                @if($res['success']==0)
 <script type="text/javascript">
   $(window).on('load',function(){      
   Command:toastr['error']("{{$res['msg']}}")
   
   toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "preventDuplicates": false,
  "positionClass": "toast-bottom-right",
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
@elseif($res['success']==1)
 <script type="text/javascript">
   $(window).on('load',function(){
Command: toastr['success']("{{$res['msg']}}")
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
@endif
  </div>
</div>
	</div>
	</div>
	</section>
	
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
		<div class="clearfix"></div>
@stop