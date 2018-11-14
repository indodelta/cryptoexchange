<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>perfektPay Admin</title>
    {{-- <meta name="description" content="Responsive, Bootstrap, BS4" /> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="../assets/images/logo.svg">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="{{URL('/admin_assets/assets/images/logo.svg')}}">
    <!-- style -->
    <link rel="stylesheet" href="{{URL('/admin_assets/libs/font-awesome/css/font-awesome.min.css')}}" type="text/css" />
    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{URL('admin_assets/libs/bootstrap/dist/css/bootstrap.min.css')}} " type="text/css" />
    <link rel="stylesheet" href="{{URL('admin_assets/assets/css/app.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{URL('admin_assets/assets/css/style.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{URL('admin_assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{URL('admin_assets/assets/css/sweetalert.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{URL('admin_assets/assets/css/bootstrap-select.min.css')}}" type="text/css" /> 
    <link rel="stylesheet" href="{{URL('admin_assets/assets/css/theme/primary.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{URL('admin_assets/assets/css/bootstrap-toggle.min.css')}}" type="text/css" />
    <style>
        .input-group-addon.to-class {
          padding-top: 5px;
      }
      .toast{
        OPACITY:1 !IMPORTANT;
    }
    .sidenav .nav li li a .nav-text {
      padding: 0.4375rem 2.5rem;
  }
  .sidenav .nav li li a {
      padding-left: 1.3rem;
  }
  .active > .nav-sub {
      background: rgb(40, 49, 69) none repeat scroll 0 0;
  }
  .nav-active-theme .nav-link.active, .nav-active-theme .nav > li.active > a, .btn.theme, .btn.b-theme:hover, .btn.b-theme:focus, .pace .pace-progress, .theme {
      background-color: rgb(65, 201, 240) !important;
  }
  .pagination {
      float: right;
  }
  .sidenav .nav li > a {
      padding: 0 0.6rem;
  }
</style>
</head>

<body>
    <header class="app-header indigo box-shadow-6">
        <div class="navbar navbar-expand-lg">
            <a class="d-lg-none mx-2" data-toggle="modal" data-target="#aside">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                    <path d="M80 304h352v16H80zM80 248h352v16H80zM80 192h352v16H80z" />
                </svg>
            </a>
            <a href="{!! route('dashboard') !!}" class="navbar-brand">
                <!-- <img src="../assets/images/logo.png" alt="." class="hide"> -->
                <span class="hidden-folded d-inline"><img src="{{URL('images/logo.png')}}"></span>
            </a>
            <ul class="nav flex-row order-lg-2">

                <!-- dropdown -->
<!--                 <div class="dropdown-menu dropdown-menu-right w-md animate fadeIn mt-2 p-0">
                    <div class="scrollable hover" style="max-height: 250px">
                        <div class="list">
                            <div class="list-item " data-id="item-4">
                                <span class="w-24 avatar circle pink">
                  <span class="fa fa-male"></span>
                                </span>
                                <div class="list-body">
                                    <a href="" class="item-title _500">Judith Garcia</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        Eddel upload a media
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                    <span class="item-date text-xs text-muted">12:05</span>
                                </div>
                            </div>
                            <div class="list-item " data-id="item-12">
                                <span class="w-24 avatar circle green">
                  <span class="fa fa-dot-circle-o"></span>
                                </span>
                                <div class="list-body">
                                    <a href="" class="item-title _500">Ashton Cox</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        Looking for some client-work
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                    <span class="item-date text-xs text-muted">11:30</span>
                                </div>
                            </div>
                            <div class="list-item " data-id="item-10">
                                <span class="w-24 avatar circle blue">
                  <span class="fa fa-google"></span>
                                </span>
                                <div class="list-body">
                                    <a href="" class="item-title _500">Postiljonen</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        Looking for some client-work
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                    <span class="item-date text-xs text-muted">08:00</span>
                                </div>
                            </div>
                            <div class="list-item " data-id="item-9">
                                <span class="w-24 avatar circle cyan">
                  <span class="fa fa-puzzle-piece"></span>
                                </span>
                                <div class="list-body">
                                    <a href="" class="item-title _500">Pablo Nouvelle</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        It&#x27;s been a Javascript kind of day
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                    <span class="item-date text-xs text-muted">15:00</span>
                                </div>
                            </div>
                            <div class="list-item " data-id="item-8">
                                <span class="w-24 avatar circle teal">
                  <span class="fa fa-bolt"></span>
                                </span>
                                <div class="list-body">
                                    <a href="" class="item-title _500">RYD</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        Added you to repo
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                    <span class="item-date text-xs text-muted">14:00</span>
                                </div>
                            </div>
                            <div class="list-item " data-id="item-3">
                                <span class="w-24 avatar circle green">
                  <span class="fa fa-html5"></span>
                                </span>
                                <div class="list-body">
                                    <a href="" class="item-title _500">Jeremy Scott</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        Submit a support ticket
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                    <span class="item-date text-xs text-muted">09:05</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex px-3 py-2 b-t">
                        <div class="flex">
                            <span>6 Notifications</span>
                        </div>
                        <a href="setting.html">See all <i class="fa fa-angle-right text-muted"></i></a>
                    </div>
                </div> -->
                <!-- User dropdown menu -->
                <li class="dropdown d-flex align-items-center">
                    <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                        <span class="avatar w-32">
                          <img src="{{URL('admin_assets/assets/images/a0.png')}}" alt="...">
                      </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn">
                    <a class="dropdown-item" href="{!! route('logout') !!}">Sign out</a>
                </div>
            </li>
        </ul>
        <!-- Navbar collapse -->
        <div class="collapse navbar-collapse  order-lg-1" id="navbarToggler">
        </div>
    </div>
</header>
<div class="app" id="app">
    <!-- ############ Aside START-->
    <div id="aside" class="app-aside fade box-shadow-x white nav-expand white" aria-hidden="true">
        <div class="sidenav modal-dialog dk">
            <div class="navbar d-lg-none">
                <a href="{!! route('dashboard') !!}" class="navbar-brand">
                    <!-- <img src="../assets/images/logo.png" alt="." class="hide"> -->
                    <span class="hidden-folded d-inline">PerfektPay</span>
                </a>
            </div>
            <div class="flex hide-scroll">
                <div class="scroll">
                    <div class="nav-active-theme" data-nav>
                        <ul class="nav ">
                            <li class="nav-header">
                                <span class="text-xs hidden-folded"></span>
                            </li>
                            <li>
                                <a href="{!! route('dashboard') !!}">
                                    <span class="nav-icon">
                                      <i class="fa fa-dashboard"></i>
                                  </span>
                                  <span class="nav-text">Dashboard</span>
                              </a>
                          </li>
                          <li>
                            <a href="{!! route('manage_user') !!}">
                                <span class="nav-icon" >
                                  <i class="fa fa-users"></i>
                              </span>
                              <span class="nav-text">Manage Users</span>
                          </a>
                      </li>
                      

                      
                      <li>
                          <a>
                            <span class="nav-caret">
                              <i class="fa fa-caret-down"></i>
                          </span>
                          <span class="nav-icon">
                              <i class="fa fa-align-left"></i>
                          </span>
                          <span class="nav-text">Manage Deposits</span>
                      </a>
                      <ul class="nav-sub">
                        <li>
                            <a href="{!! route('manage-deposits') !!}">
                                <span class="nav-icon" style="position:absolute;"
                                >
                                <i class="fa  fa-calculator"></i>
                            </span>
                            <span class="nav-text">All Deposits</span>
                        </a>
                    </li>
                                <li>
                                    <a href="{!! route('bank-transactions') !!}">
                                        <span class="nav-icon" style="position:absolute;"
                                        >
                                        <i class="fa fa-bank"></i>
                                    </span>
                                    <span class="nav-text">Manage Wire Transfers</span>
                                </a>
                            </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{!! route('manage-wallet') !!}">
                                    <span class="nav-icon">
                                      <i class="fa fa-credit-card"></i>
                                  </span>
                                  <span class="nav-text">Manage USD wallet</span>
                              </a>
                          </li>
      
 {{--                              <li>
        		                <a>
        		                  <span class="nav-caret">
        		                    <i class="fa fa-caret-down"></i>
        		                  </span>
        		                  <span class="nav-icon">
        		                    <i class="fa fa-align-left"></i>
        		                  </span>
        		                  <span class="nav-text">Manage Users</span>
        		                </a>
        		                <ul class="nav-sub">
        		                  <li>
        		                    <a href="">
        		                      <span class="nav-text">All Info</span>
        		                    </a>
        		                  </li>
        		                  <li>
        		                    <a href="">
        		                      <span class="nav-text">KYC</span>
        		                    </a>
        		                  </li>
        		                </ul>
                            </li> --}}
                            
                            <li>
                              <a>
                                <span class="nav-caret">
                                  <i class="fa fa-caret-down"></i>
                              </span>
                              <span class="nav-icon">
                                  <i class="fa fa-align-left"></i>
                              </span>
                              <span class="nav-text">Manage Orders</span>
                          </a>
                          <ul class="nav-sub">
                            <li>
                              <a href="">
                                <span class="nav-text">Buy</span>
                            </a>
                        </li>
                        <li>
                          <a href="">
                            <span class="nav-text">Sell</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
              <a>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
              </span>
              <span class="nav-icon">
                  <i class="fa fa-align-left"></i>
              </span>
              <span class="nav-text">Manage Withdrawals</span>
          </a>
          <ul class="nav-sub">
            <li>
              <a href="">
                <span class="nav-text">Pending</span>
            </a>
        </li>
        <li>
          <a href="">
            <span class="nav-text">Approved</span>
        </a>
    </li>
    <li>
      <a href="">
        <span class="nav-text">Cancelled</span>
    </a>
</li>
</ul>
</li>

<li>
  <a>
    <span class="nav-caret">
      <i class="fa fa-caret-down"></i>
  </span>
  <span class="nav-icon">
      <i class="fa fa-align-left"></i>
  </span>
  <span class="nav-text">Support Tickets</span>
</a>
<ul class="nav-sub">
    <li>
      <a href="">
        <span class="nav-text">Pending</span>
    </a>
</li>
<li>
  <a href="">
    <span class="nav-text">Resolved</span>
</a>
</li>
</ul>
</li>



<li>
  <a>
    <span class="nav-caret">
      <i class="fa fa-caret-down"></i>
  </span>
  <span class="nav-icon">
      <i class="fa fa-align-left"></i>
  </span>
  <span class="nav-text">Settings</span>
</a>
<ul class="nav-sub">
    <li>
      <a href="{!! route('settings') !!}">
        <span class="nav-text">Manage Settings</span>
    </a>
</li>
{{-- <li>
  <a href="">
    <span class="nav-text">Manage 2FA Security</span>
</a>
</li> --}}
</ul>
</li>

<li class="pb-2 hidden-folded"></li> 
</ul>
</div>
</div>
</div>
<div class="no-shrink hide">
</div>
</div>
</div>
<!-- ############ Aside END-->

<!-- ############ Content START-->
<div id="content" class="app-content box-shadow-3" role="main">

    @yield('content')
    <!-- Footer -->
    <div class="content-footer white " id="content-footer">
        <div class="d-flex p-3">
            <span class="text-sm text-muted flex">&copy; Copyright 2018 perfektPay. All Rights Reserved.</span>
            <div class="text-sm text-muted"></div>
        </div>
    </div>
</div>
<!-- ############ Content END-->
<!-- ############ LAYOUT END-->
</div>
<!-- jQuery -->

<script src="{{URL('admin_assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{URL('admin_assets/libs/pace-progress/pace.min.js')}}"></script>
<!--<script src="{{URL('admin_assets/libs/pjax/pjax.js')}}"></script>-->
<script src="{{URL('admin_assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{URL('admin_assets/assets/js/sweetalert.min.js')}}"></script>
<script src="{{URL('admin_assets/assets/js/bootstrap-select.min.js')}}"></script>  


<script src="{{URL('admin_assets/scripts/lazyload.config.js')}}"></script>
<script src="{{URL('admin_assets/scripts/lazyload.js')}}"></script>
<script src="{{URL('admin_assets/scripts/plugin.js')}}"></script>
<script src="{{URL('admin_assets/scripts/nav.js')}}"></script>
<script src="{{URL('admin_assets/scripts/scrollto.js')}}"></script>
<script src="{{URL('admin_assets/scripts/toggleclass.js')}}"></script>
<script src="{{URL('admin_assets/scripts/theme.js')}}"></script>
<script src="{{URL('admin_assets/scripts/ajax.js')}}"></script>
<script src="{{URL('admin_assets/scripts/app.js')}}"></script>
<script src="{{URL('admin_assets/assets/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{URL('admin_assets/assets/js/custome.js')}}"></script> 
<!-- endbuild -->
</body>

</html>