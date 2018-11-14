<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>BUY SELL Bitcoin across the world | Perfekt Technologies HK Limited</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Bootstrap -->
    <link href="css/style.css" rel="stylesheet">
	<!-- Banner Slider CSS -->
	<link rel="stylesheet" href="css/slider.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrapValidator.css">
	<link rel="stylesheet" href="css/toastr.min.css" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>

@font-face {
    font-family: 'futura_md_btbold';
    src: url('fonts/futubd.woff2') format('woff2'),
         url('fonts/futubd.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'futura_md_btmedium';
    src: url('fonts/futuramediumbt.woff2') format('woff2'),
         url('fonts/futuramediumbt.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}


  .navbar-nav {
  display: table !important;
  float: none !important;
  margin: auto !important;
}
.navigation nav ul li a {
  color: hsl(0, 0%, 100%) !important;
  text-align: center !important;
}
@media only screen and (max-width:991px){
.navbar-inverse .navbar-nav > li > a {
  font-size: 13px !important;
}
.navbar-nav {
  float: left;
}
.navbar-nav .open .dropdown-menu .dropdown-header, .navbar-nav .open .dropdown-menu > li > a {
  color: hsl(0, 0%, 100%) !important;
  font-size: 12px;
  padding: 5px 15px 5px 25px;
}
}
</style>
  <body>
  	
    <header>
		<!--<div class="container">
			<div class="row">
				<div class="col-sm-4 left-bar">
					<ul>
						<li>BUY BTC: <i class="fa fa-inr" aria-hidden="true"></i> 175,667</li>
						<li>SELL BTC: <i class="fa fa-inr" aria-hidden="true"></i> 170,837</li>
					</ul>
				</div>
				<div class="col-sm-4 logo">
					<a href="index.php"><img src="images/logo.png"></a>
				</div>
				<div class="col-sm-4 left-bar right-bar">
					<ul>
						<li><a href="sign-up.php">Sign Up</a></li>
						<li><i class="fa fa-sign-out" aria-hidden="true"></i></li>
					</ul>
				</div>
			</div>
		</div>

	<div class="clearfix"></div>-->
	<section class="navigation">
		<div class="container">
			<div class="row">
			<div class="col-md-3 col-sm-12 col-xs-9 logo">
					<a href="{{URL::to('/')}}"><img src="images/logo.png"></a>
				</div>
				
				<div class="col-md-9 col-sm-12 col-xs-12">
				<nav class="navbar navbar-inverse fixed-navbar">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
						
						<div class="col-md-9 col-sm-9" style="padding:0;">
							<ul class="nav navbar-nav">
								<li><a href="{{URL::to('/')}}">Home</a></li>
								<li><a href="about-bitcoin">About Bitcoin</a></li>
								<li><a href="how-it-works">How it Works</a></li>
								<li><a href="about">About Us</a></li>
								<!--<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Resources <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="about">About Us</a></li>
										<!--<li><a href="#">FAQs</a></li>
										<li><a href="security">Security</a></li>
										<!--<li><a href="#">News</a></li>
										<li><a href="#">Offers</a></li>
										<li><a href="#">Use</a></li>-->
									<!--</ul>
								</li>-->
								<li><a href="exchange">Exchange</a></li>
								<li><a href="contact_us">Contact Us</a></li>
							</ul>
							</div>
							
							<div class="col-md-3 col-sm-3 left-bar right-bar" style="padding:0;">
					<ul>
					<?php if(!empty($user_id)){ ?>
						<li><a href="funding" style="color:#41c9f0 !important;">Log In</a></li>
						<li><a href="funding">Sign Up</a></li>
					<?php }else{ ?>
						<li><a href="login" style="color:#41c9f0 !important;">Log In</a></li>
						<li><a href="signup">Sign Up</a></li>
					<?php } ?>
					</ul>
				</div>
			
						</div> 
					</div>
				</nav>
				</div>
				
				
		</div>
	</section>
		</header>
	<div class="clearfix"></div>

	@yield('content')

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-3">
					<h6 style="text-align:left;">Addresss</h6>
					<p style="text-align:left;">Perfekt Capital Limited,<br>Unit 804 8F Boss Commercial Centre<br>28 Ferry Street, Yau Ma Tei,<br>Kowloon, Hong Kong
					</p>
				</div>
				<div class="col-sm-3 col-md-3">
					<h6>About Us</h6>
					<ul>
					    <li><a href="legal">Legals</a></li>
						<li><a href="about">About Us</a></li>
						<li><a href="exchange">Exchange</a></li>
						<li><a href="legal">Terms of Use</a></li>
						<li><a href="legal#tab2">Privacy Policy</a></li>
					</ul>
				</div>
				
				
					<div class="col-sm-3 col-md-3 social">
					<h6>Contact</h6>
						<p>Phone : +852 6024 5489<br>
						(10:00 am - 7:00 PM Mon-Sat)</p>
						<br>
					<a href="" style="text-align:left; color:#003466">support@perfektpay.com</a>
				</div>
				
				<div class="col-sm-3 col-md-3 social">
					<h6>Meet us @</h6>
					<ul>
						<li><a href="#"><img src="images/fb.png"></a></li>
						<li><a href="#"><img src="images/twitterr.png"></a></li>
						<li><a href="#"><img src="images/google-plus.png"></a></li>
						<li><a href="#"><img src="images/linkedin.png"></a></li>
					</ul>
					<p>Follow @perfektpay for all future updates! twitter.com/perfektpay</p>
				</div>
			</div>
		</div>
		<div class="copyright">
		    <div class="container">
		    <p style="text-align:left;">High Risk Warning: Trading cryptocurrencies such as bitcoin and blockchain tokens such as ether carries a high level of risk, and may not be suitable for all investors. The high degree of price volatility can result in incredible losses as well as gains. Before deciding to trade cryptocurrencies or blockchain tokens you should carefully consider your investment objectives, level of experience, and risk appetite. The possibility exists that you could sustain a loss of some or all of your initial investment and therefore you should not invest using funds that you cannot afford to lose. You should be aware of all the risks associated with the trading of digital assets, and seek advice from an independent financial advisor if you have any specific concerns. Please read our full risk warning.</p>
		    <hr style="border-color:rgba(215,215,215,0.3)">
			<p style="text-align:left;">© 2017 perfektpay, All Right Reserved.</p>
		</div>
		</div>
	</footer>

	@if(Session::has('csrf_error')) 
 <script type="text/javascript">
   $(window).on('load',function(){	 	  
   Command:toastr['error']("{{ Session::get('csrf_error') }}")
   
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


@endif

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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrapValidator.js"></script>
	<!-- Banner Slider JS -->
	<script src="js/slider.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/toastr.min.js"></script>
	<script>
	$(function(){
		$('#slider').rbtSlider({
			height: '100vh', 
			'dots': true,
			'arrows': true,
			'auto': 3
		});
	});
	</script>
	<script>
	function openCity(evt, cityName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}
		
		</script><script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  }
}
</script>
	
		<script src="https://use.fontawesome.com/1f6554cbc4.js"></script>
		
  </body>
</html>