<!doctype html>
<html class="fixed sidebar-left-collapsed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>perfektPay</title> 
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.theme.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris.js/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />
		<link rel="stylesheet" href="css/sweetalert.css" />
		<link rel="stylesheet" href="css/toastr.min.css" />
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<link rel="stylesheet" type="text/css" href="css/bootstrapValidator.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  
		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="js/sweetalert.min.js"></script>
		<script src="js/toastr.min.js"></script>
		<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>
		
		<style>
.dropdown-submenu {
    position: relative;
}
.text-right{
text-align:right;
}
.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}
.dropdown-menu.menu2 {
  background: transparent none repeat scroll 0 0;
  border: 0 none;
  box-shadow: none;
  padding: 0;
  position: relative;
  background:#F3F3F3;
}
.red{
	color: red;
}
.green{
	color: green;
}
.white{
	color: white;
}
#support-search-submit:hover {
    background-color: #337ab7;
}
#support-search-submit {
  background-color: #003466;
  border: 0 none;
  color: #fff;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
  height: 38px;
  margin: 0;
  left: 40%;
  overflow: hidden;
  padding: 8px;
  position: absolute;
  text-overflow: ellipsis;
  top: 0;
  white-space: nowrap;
</style>

	</head>
	<body>
		<div class="formtoken">{{ csrf_field() }}</div>
		<section class="body">
			<!-- start: header -->
			<header class="header"> 
				<div class="logo-container">
					<a href="{{url('/')}}" class="logo">
						<img src="images/logo.png" height="35" alt="Porto Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<!--<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
			
					<span class="separator"></span>-->		
					

					<ul class="notifications">
					    
						<li>
							<a href="trading">
								Trade
							</a>
						</li>
						<li>
							<a href="{{url('funding')}}">
								Funding
							</a>
						</li>
						<li>
							<a href="{{url('faq')}}">
								FAQ
							</a>
						</li>
	
						<li>
                            <a class="dropdown-toggle" data-toggle="dropdown">Account <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!-- <li class="dropdown-submenu">
                                    <a class="test" tabindex="-1" href="#"  id="settings">Settings <span class="caret"></span></a>
                                    <ul class="dropdown-menu menu2">
                                    @if($skipped_notification['kyc_skipped']==1) 
										<li ><a href="kyc">Verify KYC</a></li>
										@endif
										@if($skipped_notification['auth_skipped']==1) 
		      							<li ><a href="g-security">Google Security</a></li>
		      							@endif
		      							<li><a href="profile">View Profile</a></li>
                                    </ul>
                                </li> -->
                                <li><a href="settings">Settings</a></li>
                                <li><a tabindex="-1" role="presentation" href="trading_history">Trading History</a></li>
                                <li role="presentation"><a href="{{url('logout')}}">Logout</a></li>
                            </ul>
      							
                        </li>
                    </ul>

				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->
			<div class="row top-bar">
					@if(Request::is('faq'))
						<div id="support-header">
                    		<div class="container">
                    			<div class="row">
                    				<div class="col-sm-10 col-sm-offset-1">
                    					
                    						<div class="outer">
                    							<div class="inner" style="height: 30px;">
                    								<button id="support-search-submit"  data-toggle="modal" data-target=".bs-example-modal-lr"> Submit your query</button>  
                    							</div>
                    						</div>
                    					
                    				</div>
                    			</div>
                    		</div>
                    	</div>

                    	<div class="modal fade bs-example-modal-lr" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lr">
    <div class="modal-content">
    <div class="divimg"><center style="margin-top: 10%;margin-bottom: 3%;">
     <h3 class="logo-name1">Submit Query</h3>  </center></div>
      <div class="divbut modal-body" >
          <form  id="form1" action="#" accept-charset="UTF-8" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div>
                   
            </div> 
            <div class="form-group">
                <div class="col-md-4 margintop8">
                    <label for="recipient-name1" class="control-label"><center>Subject:</center></label>
                </div>
            <div class="col-md-8 margintop8 marginbottom8">
            <input type="text" class="form-control" name="sub" required="" placeholder="write here" id="user_name" autofocus="on"/>
            </div></div>
            <div class="form-group">
            <div class="col-md-4">
            <label for="recipient-name2" class="control-label"><center>Describe:</center> </label>
            </div>
            <div class="col-md-8 marginbottom8">
            <textarea name="describe" id='textarea1' rows="10" cols="30" maxlength="200" required=""></textarea>
            </div></div>                                    
            @csrf
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" onclick="check()" form="form1" class="btn btn-primary m-b btn-group pull-right">Submit this form</button>
            </div>
            </form>
        
      </div>
    </div>
  </div>
        </div>
                    	@else
                    		 <div class="row top-bar-inner">
						<div class="col-sm-3">
							<div class="">
								<div class="col-md-12">
									<h2>	
										<div class="btn-group">
											<label class="mb-xs mt-xs mr-xs btn btn-default dropdown-toggle" data-toggle="dropdown" style="text-align:left;padding-top: 15px;padding-bottom: 15px;"><strong style="font-size:2.4rem;">BTCUSD</strong></label>
										</div>
									</h2>
								</div>
							</div>
						</div>
						
						<div class="col-sm-9">
							<div class="col-md-offset-4 col-md-2 col-sm-3">
								<div class="inner-box-bar">
									<p>Last Trade</p>
									<h3 class="white">$<span class="last_trade">{{number_format((float)$itbit['lastPrice'], 2, '.', '')}}</span></h3>
								</div>
							</div>
							
							<div class="col-md-2 col-sm-3">
								<div class="inner-box-bar">
									<p>BID</p>
									<h3 class="white">$<span class="bid">{{number_format((float)$itbit['bid'], 2, '.', '')}}</span></h3>
								</div>
							</div>
							
							<div class="col-md-2 col-sm-3">
								<div class="inner-box-bar">
									<p>Ask</p>
									<h3 class="white">$<span class="ask">{{number_format((float)$itbit['ask'], 2, '.', '')}}</span></h3>
								</div>
							</div>
							
							<div class="col-md-2 col-sm-3">
								<div class="inner-box-bar">
									<p>24 Hr Volume</p>
									<h3 class="blue-text">$<span class="volume24h">{{number_format((float)$itbit['volume24h'], 2, '.', '')}}</span></h3>
								</div>
							</div>
						</div>
					</div>
                    	@endif
                    </div>

			@yield('content')		

						<footer>
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ul class="footer-listing">
								<li>
									<a href="{{env('APP_URL_ADMIN')}}/about">About</a>
								</li>
								<li>
									<a href="{{url('/')}}">PerfektPay</a>
								</li>
								<li>
									<a href="{{env('APP_URL_ADMIN')}}/contact_us">Contact</a>
								</li>
								<li>
									<a href="{{env('APP_URL_ADMIN')}}/legal">Legal</a>
								</li>
							</ul>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<ul class="footer-listing1">
								<li>
									<a href=""><img src="assets/images/fb.png"></a>
								</li>
								<li>
									<a href=""><img src="assets/images/tw.png"></a>
								</li>
								<li>
									<a href=""><img src="assets/images/go.png"></a>
								</li>
								<li>
									<a href=""><img src="assets/images/ln.png"></a>
								</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p class="text-center">Copyright 2018 PerfektPay. All Rights Reserved.</p>
						</div>
					</div>
					
					
							
				</div>
			</footer>
		</section>
		<script >

			function check(){
				event.preventDefault();
				Command: toastr['warning']("this functionality not available now")
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
			}

		</script>
	</body>
	
	<!-- Vendor -->
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery-appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot.tooltip/flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery-sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>
		<script src="assets/vendor/morris.js/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap.svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/bootstrapValidator.js"></script>
		<script src="assets/javascripts/theme.custom.js"></script>

		
		<!-- Theme Initialization Files -->
		<!-- <script src="assets/javascripts/theme.init.js"></script> -->
		<!-- Examples -->		
		<script src="assets/javascripts/ui-elements/examples.modals.js"></script>
		<!-- Examples -->
		<!-- <script src="assets/javascripts/dashboard/examples.dashboard.js"></script> -->
		<!-- <script src="assets/javascripts/forms/examples.advanced.form.js"></script> -->

	</body>
</html>
