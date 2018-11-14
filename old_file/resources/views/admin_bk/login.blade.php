<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>perfektPay Signin</title>
  <meta name="description" content="Responsive, Bootstrap, BS4" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <!-- style -->
  <link rel="stylesheet" href="{{env('APP_URL_ADMIN')}}/admin_assets/libs/font-awesome/css/font-awesome.min.css" type="text/css" />
  <!-- build:css ../assets/css/app.min.css -->
  <link rel="stylesheet" href="{{env('APP_URL_ADMIN')}}/admin_assets/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="{{env('APP_URL_ADMIN')}}/admin_assets/assets/css/app.css" type="text/css" />
  <link rel="stylesheet" href="{{env('APP_URL_ADMIN')}}/admin_assets/assets/css/style.css" type="text/css" />
  <!-- endbuild -->
</head>
<body>
<div class="d-flex flex-column flex">
  <div class="navbar light bg pos-rlt box-shadow">
    <div class="mx-auto">
      <!-- brand -->
      <a href="" class="navbar-brand">
      	<img src="{{env('APP_URL_ADMIN')}}/admin_assets/assets/images/logo.png" alt="." >      	
      </a>    
    </div>
  </div>
  <div id="content-body" class="body-sign">
  <div class="alert alert-danger fade in close-alert" id="error-alert"></div>
    <div class="panel-body body-panal-custome">    
      <div class="py-5 text-center w-100">
        <div class="mx-auto w-xxl w-auto-xs">
            <form name="login" id="login_form" method="post" action="{{env('APP_URL_ADMIN_ACTION')}}/loginprocess" >   
            {{ csrf_field() }}            
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
              </div>  
              <button type="submit" id="loginsubmit" class="btn primary">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- build:js scripts/app.min.js -->
<!-- jQuery -->
  <script src="{{env('APP_URL_ADMIN')}}/admin_assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
  <script src="{{env('APP_URL_ADMIN')}}/admin_assets/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="{{env('APP_URL_ADMIN')}}/admin_assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- core -->
  <script src="{{env('APP_URL_ADMIN')}}/admin_assets/libs/pace-progress/pace.min.js"></script>
  <script src="{{env('APP_URL_ADMIN')}}/admin_assets/libs/pjax/pjax.js"></script>
  <script src="{{env('APP_URL_ADMIN')}}/admin_assets/assets/js/custome.js"></script>
<!-- endbuild -->
</body>
</html>
