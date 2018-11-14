@extends('layouts.app')
@section('content')

@section('title', 'Bitcoin sign up| How to Create Bitcoin Wallet | Create Wallet for Bitcoin')
@section('content12')
  <meta name="description" content="When you sign up with Perfekt Capital Limited, you automatically receive a Bitcoin address that serves as your Bitcoin wallet. You can find your BTC address in your wallet and on your Dashboard. This wallet is also called Perfektpay wallet. Sign up for more information and call… us @ +852 6024 5489.">
  <meta name=keywords content="Bitcoin sign up, How to Create Bitcoin Wallet, Create Wallet for Bitcoin">
@stop
  <style>
  #recaptcha > div {
  margin: auto;
}
    .sign-up-form {
      background: hsla(0, 0%, 0%, 0) url("../images/back-img.jpg") repeat scroll 0 0 / 100vh 100vh;
      padding: 60px 0;
    }
    /*.sign-back{*/
    /*  background: hsla(0, 0%, 0%, 0) url("images/back-img.jpg") repeat scroll 0 0;*/
    /*}*/
    .inner-area {
      color: #fff;
      padding: 10px 70px !important;
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
      border-radius: 0;
      height: 45px;
      color:#000;
      font-size:17px;
    }

    .mobile-log-in {
      color: hsl(0, 100%, 50%);
      float: right;
      font-size: 20px;
      padding-bottom: 18px;
      text-align: right;
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
    .bottom-row {
      background: hsla(0, 0%, 0%, 0) url("images/sign-button-back.jpg") repeat scroll 0 0;
      font-size: 17px;
      margin-top: 0;
      padding: 10px 15px;
    }

    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
      position: absolute;
      left: -9999px;
    }
    [type="checkbox"]:not(:checked) + label,
    [type="checkbox"]:checked + label {
      position: relative;
      padding-left: 1.95em;
      cursor: pointer;
    }
    [type="checkbox"]:not(:checked) + label::before, [type="checkbox"]:checked + label::before {
      background: hsl(0, 0%, 100%) none repeat scroll 0 0;
      border: 1px solid hsl(0, 0%, 0%);
      border-radius: 0;
      content: "";
      height: 1em;
      left: 0;
      position: absolute;
      top: 3px;
      width: 1em;

    }
    [type="checkbox"]:not(:checked) + label::after, [type="checkbox"]:checked + label::after {
      color: hsl(0, 0%, 0%);
      content: "✔";
      left: 0.1em;
      line-height: 0.8;
      position: absolute;
      top: 0.3em;
      transition: all 0.2s ease 0s;
    }
    /* checked mark aspect changes */
    [type="checkbox"]:not(:checked) + label:after {
      opacity: 0;
      transform: scale(0);
    }
    [type="checkbox"]:checked + label:after {
      opacity: 1;
      transform: scale(1);
    }
    /* disabled checkbox */
    [type="checkbox"]:disabled:not(:checked) + label:before,
    [type="checkbox"]:disabled:checked + label:before {
      box-shadow: none;
      border-color: #000;
      background-color: #000;
    }
    [type="checkbox"]:disabled:checked + label:after {
      color: #000;
    }
    [type="checkbox"]:disabled + label {
      color: #000;
    }
    /* accessibility */
    [type="checkbox"]:checked:focus + label:before,
    [type="checkbox"]:not(:checked):focus + label:before {
      border: 1px solid #000;
    }
    .sign-back{
      background: hsla(0, 0%, 0%, 0) url("images/back-img.jpg") repeat scroll 0 0;
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
      color: #fff;
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
    .g-recaptcha {
  border: medium none !important;
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
    .err,.captch_err{color:red;}
  </style>
</head>
<body class="sign-back">
  <section class="sign-up-form">
    <div class="container">
      <div class="row">
        <div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 inner-area" style="margin-top:30px;padding:0;background:rgba(49, 155, 193, 0.5) url('images/logo-large.png') no-repeat scroll center center; text-align:center;">
            <h1>Registration</h1>
            <!--<p>Sign up for a free wallet </p>-->

            @foreach($errors->all() as $error)
              <div class="alert alert-dismissable alert-danger">{{ $error }}</div>
            @endforeach  

            @if(isset($value))
              @if($value['success']==1)
                <div class="alert alert-success fade in close-alert" id="success-alert">{{$value['msg']}}</div>
              @endif
            @endif

            @if(isset($CaptchaErr))
              <div class="alert alert-danger fade in close-alert" id="error-alert">{{$CaptchaErr}}</div>
            @endif
            <span id="error-alertj"></span>
            <form style="padding-top:20px;" action="{{route('signuppost')}}" method="post" id="user_register">
              {{ csrf_field() }}
              <div class="form-group" style="text-align:left;">
                <label for="Text" class="welcome-label">Username</label>
                <input type="text" class="form-control sign-up-fields" id="username" name="username">
                <small class="err"></small>                
              </div>

              <div class="form-group" style="text-align:left;">
                <label for="email" class="welcome-label">Email</label>
                <input type="email" class="form-control sign-up-fields" placeholder="" id="email" name="email">
              </div>

              <div class="form-group" style="text-align:left;">
                <label for="pwd" class="welcome-label">New Password</label>
                <input type="password" class="form-control sign-up-fields" placeholder="" id="pwd" name="password">
              </div>

              <div class="form-group" style="text-align:left;">
                <label for="pwd" class="welcome-label">Confirm Password</label>
                <input type="password" class="form-control sign-up-fields" placeholder="" id="cpwd" name="password_confirmation">
              </div>


              <div class="form-group">
                <div class="">
                  <div id="recaptcha" class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}" style="text-align:center;"></div>
                  <small class="captch_err"></small>  
                </div>
              </div>

              <div class="form-group">
                <p style="display: inline-block;">
                  <input type="checkbox" id="test1" name="term_service"/>
                  <label for="test1" style="font-size:16px;font-weight:normal;">I have read and agree to the <a href="legal" style="color:#6dcff6; text-decoration:none;">Terms of Service</a></label></p>
                </div>
                <br>
                <div class="form-group">
                  <button type="submit" class="btn btn-default log-in" id="submitbtn">Continue</button>
                </div>
          </form> 
          <p style="text-align:center;">Already have account? <a href="login" style="color:#6dcff6;"> Sign In</a></p>
        </div>
      </div>
    </div>
  </section>
  @stop