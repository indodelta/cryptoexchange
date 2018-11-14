<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>perfektPay Admin</title>
  <meta name="description" content="Responsive, Bootstrap, BS4" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <!-- style -->
  <link rel="stylesheet" href="{{URL('/admin_assets/libs/font-awesome/css/font-awesome.min.css')}}" type="text/css" />
  <!-- build:css ../assets/css/app.min.css -->
  <link rel="stylesheet" href="{{URL('admin_assets/libs/bootstrap/dist/css/bootstrap.min.css')}} " type="text/css" />
  <link rel="stylesheet" href="{{URL('admin_assets/assets/css/app.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{URL('admin_assets/assets/css/style.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{URL('admin_assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" type="text/css" />
  <!-- endbuild -->
</head>
<body>
<header class="app-header indigo box-shadow-6">
  <div class="navbar navbar-expand-lg">
      <a href="" class="navbar-brand">
        <span class="hidden-folded d-inline">PerfektPay</span>
      </a>
    <ul class="nav flex-row order-lg-2">
      <!-- User dropdown menu -->
      <li class="dropdown d-flex align-items-center">
        <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
          <span class="avatar w-32">
            <span class=""><a href="{!! route('logout') !!}">Logout</a></span>
          </span>
        </a>
      </li>
    </ul>
    <!-- Navbar collapse -->
    <div class="collapse navbar-collapse  order-lg-1" id="navbarToggler">
    </div>  
  </div>
</header>
<div class="app" id="app">
<!-- ############ LAYOUT START-->
  <!-- ############ Aside START-->
  <div id="aside" class="app-aside fade box-shadow-x white nav-expand white" aria-hidden="true">
    <div class="sidenav modal-dialog dk">
      <!-- sidenav top -->
      <div class="navbar d-lg-none">
        <!-- brand -->
        <a href="../index.html" class="navbar-brand">
          <img src="../admin_assets/assets/images/logo.png" alt="." class="hide">
         <!--  <span class="hidden-folded d-inline">Apply</span> -->
        </a>
        <!-- / brand -->
      </div>    
      <!-- Flex nav content -->
      <div class="flex hide-scroll">
          <div class="scroll">
            <div class="nav-active-theme" data-nav>
              <ul class="nav" style="color: rgba(255, 255, 255, 0.85) !important;background-color: #53a6fa !important;">                
                  <li class="nav-header">
                  <li class="active" >
                    <a href="{!! route('dashboard') !!}">
                      <span class="nav-icon">
                        <i class="fa fa-dashboard"></i>
                      </span>
                      <span class="nav-text">Dashboard</span>
                    </a>
                  </li>
                  <li class="pb-2 hidden-folded"></li>
              </ul>
              <ul class="nav ">   
                    <li>
                      <a href="{!! route('manage_user') !!}">
                        <span class="nav-caret">
                          <i class=""></i>
                        </span>
                        <span class="nav-icon no-fade">
                          <i class="badge badge-xs badge-o md b-primary"></i>
                        </span>
                        <span class="nav-text">Manage Users</span>
                      </a>
                    </li> 
              </ul>
              <ul class="nav ">    
                    <li>
                      <a href="{!! route('bank-transactions') !!}">
                        <span class="nav-caret">
                          <i class=""></i>
                        </span>
                        <span class="nav-icon no-fade">
                          <i class="badge badge-xs badge-o md b-primary"></i>
                        </span>
                        <span class="nav-text">Bank Transactions</span>
                      </a>
                    </li> 
              </ul>
              <ul class="nav ">    
                    <li>
                      <a href="{!! route('manage-deposits') !!}">
                        <span class="nav-caret">
                          <i class=""></i>
                        </span>
                        <span class="nav-icon no-fade">
                          <i class="badge badge-xs badge-o md b-primary"></i>
                        </span>
                        <span class="nav-text">Manage Deposits</span>
                      </a>
                    </li> 
              </ul>
              <!-- <ul class="nav ">    
                    <li>
                      <a href="">
                        <span class="nav-caret">
                          <i class=""></i>
                        </span>
                        <span class="nav-icon no-fade">
                          <i class="badge badge-xs badge-o md b-primary"></i>
                        </span>
                        <span class="nav-text">Manage USD wallet</span>
                      </a>
                    </li> 
              </ul> -->
            </div>
          </div>
      </div>
    </div>
  </div>

  @yield('content')
<!-- Footer -->
      <div class="content-footer white " id="content-footer">
          <div class="d-flex p-3">
            <span class="text-sm text-muted flex">&copy; Copyright 2018 perfektPay. All Rights Reserved.</span>         
      </div>
    </div>
</div>
</div>
<script src="{{URL('admin_assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/pace-progress/pace.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/pjax/pjax.js')}}"></script>
<script src="{{URL('admin_assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{URL('admin_assets/assets/js/custome.js')}}"></script>

</body>
</html> 