@extends($header)
@section('content')
<style>
#support-header {
  display: none;
}
.form-control {
  min-height: 40px;
}

header {
  background: #24507a none repeat scroll 0 0;
  padding: 15px 0;
  position: relative;
  width: 100%;
  z-index: 99;
}
legend {
  background: #fff none repeat scroll 0 0 !important;
  border-bottom: 0 none !important;
  font-size: 17px;
  margin-left: 20px;
  margin-top: 19px;
  position: relative;
  text-align: center;
  width: 180px;
}
fieldset {
  border: 1px solid #ccc !important;
}
@media screen and (max-width: 767px){
.navbar-fixed-bottom, .navbar-fixed-top {
  left: 0;
  right: 0;
  z-index: 1030;
  margin-bottom:0 !important;
}
#wrapper {
  margin: 122px auto auto !important;
}
}
.inner-circle {
  background: transparent none repeat scroll 0 0;
  border: 1px solid #234f79;
  border-radius: 50%;
  height: 25px;
  width: 25px;
}
.inner-circle.active {
  background: #41c9f0 none repeat scroll 0 0;
  border: 3px double #fff;
  border-radius: 50%;
  height: 25px;
  width: 25px;
}
.inner-listing {
  display: block;
  list-style: outside none none;
  margin:30px auto 0;
  text-align: center;
}
.inner-listing > li {
  display: inline-block;
}
.main-heading {
  color: #234f79;
  margin-bottom: 0;
  text-align: center;
}
.err{color:red;}
</style>
<div id="wrapper">
  <div class="main-form-back">
    <div class="container">  
            <fieldset class="form-inner-padding">    
              <?php if(!isset($g_auth) && empty($g_auth)){ ?>
                <legend>Enable 2FA Security</legend>
                  
                  
                  <div class="row">
                    <div class="col-md-3">
                      <div class="qr-image">
                        <img src="{{$image}}">
                      </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="text" class="control-label">Authenticator Secret Code</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control blue-form" id="text" value="{{$secret}}">
                      </div>
                    </div>
                  </div>
                      <ol class="listing-qr">
                        <li>  Install an authenticator app on mobile device if you don't already have one. We support these options .</li>
                        <li>  Scan QR code with the authenticator(or tap it mobile browser).</li> 
                        <li>  Please write down or print a copy of the 16-digit secret code and put it in a safe place.</li>
                        <li>  If your phone gets lost , stolen or erased, you will need this code to link Coinbase to a new authenticator app install once again.</li>
                        <li>  Do not share it with anyone. Be aware of phishing scams. We will never ask you for this key.</li>
                      </ol>
                    
              <?php } ?>
              <div class="row" style="background:#;margin-top:10px;padding:15px;">
                <div class="" style="">
                  <p>Once an authenticator app is enabled, all other 2FA methods will not be accepted.</p>
                </div>
                <br>
                <div class="row">
                <div class="col-md-2" style="">
                  <img src="images/icon-sec.jpg" style="max-width:100%;margin:auto;display:block;">
                </div>
                <div class="col-md-10">
                  <div class="row">
                    <div class="col-sm-11">
                      <P>Enter the 2-step verification code provided by your authentication app</P>
                    </div>
                  </div>
                  </div>
                  <div class="row">                    
					<form class="form-horizontal formtoken" role="form" method="POST" action="{{url('/validate2fa')}}"> 
                    {{ csrf_field() }}                    
                    <input type="hidden" name="id" value="{{$value['id']}}">
                    <div class="form-group">
                      <div class="col-sm-3">
                        <input type="number" class="form-control totp" name="totp" required="">
                        <small class="err"></small>
                      </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <button type="button" class="btn btn-submit validate_gcode" style="margin: 0;height: 100%;font-weight: 100;">
                            <i class="fa fa-btn fa-mobile"></i>&nbsp;Validate
                        </button>
                      </div> 
                    </div>
                    </div>
                    </div> 
                  </form>
                </div>
              </div>
              </div>
            </div>
            </fieldset>
          <?php if(!isset($g_auth) && empty($g_auth) && $header !="user.layouts.layout"){ ?>
          <div class="row" style="margin-top:20px;">
                <div class="col-sm-12">
                  <div class="form-group last-linking">
                    <!-- <a href="user_kyc" class="back">< < Back</a> -->
                    <a href="user_authent_skip" class="skip">Skip > ></a>
                  </div>
                </div>
              </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
