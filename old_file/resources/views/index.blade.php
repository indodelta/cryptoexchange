@extends('layouts.app')
@section('content')	
<style>
.content-main a {
  color: #35acd1;
}
button.btn.btn-primary.btn-style {
    border: #003466 1px solid;
    background: transparent;
    color: #003466;
}
a.canvasjs-chart-credit {
    display: none;
}
.white-box-size {
    width: 80px;
    background: #fff;
    height: 20px;
    left: 0;
    position: absolute;
    bottom: 0px;
}
.chart-box{
	position:relative;
}
</style>
<script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/currency.js"></script>
<section class="banner">

		
		 <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="images/banner.jpg" alt="Los Angeles" style="width:100%;">
		<div class="carousel-caption">
		<div class="banner-list">
         	<ul>
						<li class="btc" style="color: #00f71d !important"></li>
						
					</ul>
		</div>	
		<div class="content-main">
			<h4>World's Leading<br>Cryptoasset & Blockchain Company !</h4>
			<p>Perfektpay makes setting up your bitcoin wallet fast and easy</p>
			
			<h5><a href="signup">Get Started&nbsp;<img src="images/arroww.png"></a></h5>
			<!--<div class="buttons">
				<a href="javascript:void(0)"><img src="images/google-play.png"></a>
				<a href="javascript:void(0)"><img src="images/app-store.png"></a>
			</div>-->
        </div> 
		</div>
      </div>



    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  
  
	<!--	<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<!--<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>-->

			<!-- Wrapper for slides -->
			<!--<div class="carousel-inner">
				<div class="item active">
					<img src="images/banner.jpg">
					
				</div>

				<!--<div class="item">
					<img src="images/banner.jpg">
				</div>
			
				<div class="item">
					<img src="images/banner.jpg">
				</div>-->
		<!--	</div>
		</div>-->
		<!--<div class="banner-form">
			<form>
				<h3>Open An Account</h3>
				<div class="col-sm-7">
					<div class="form-group">
						<input placeholder="Your Email" type="text" class="form-control">
					</div>
					<div class="form-group">
						<input placeholder="Your Password" type="text" class="form-control">
					</div>
					<p><a href="#">Have a coupon code?</a></p>
					<button class="btn btn-default rose-button">Sign In</button>
				</div>
				<div class="col-sm-5 block-center">
					<img src="images/banner-logo.png">
				</div>
				<p class="full-width">To open a free bitcoin wallet account, enter your email, a choose a password & then click <a href="signup" style="color:;">Sign Up</a></p>
			</form>
		</div>-->
	</section>
	<div class="clearfix"></div>
	<section class="buy-accept">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">

						<img src="images/bit.png">
						<h4>Buy</h4>
						<p>Start buying and selling bitcoin through your bank account.</p>
				</div>
				<div class="col-sm-4">
						<img src="images/usee.png">
						<h4>Sell</h4>
						<p>Store your bitcoin securely in your Perfektpay wallet or vault.</p>
				</div>
				<div class="col-sm-4">
						<img src="images/accept.png">
						<h4>Exchange</h4>
						<p>Accept bitcoin from your friends and customers around the world.</p>
				</div>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
	<section class="calculator">
		<div class="container">
			<div class="row">
			<div class="col-sm-6 calculator-left">
				<h4>Buy and Sell bitcoin</h4><br>
				<p>Where bitcoin has revolutionised the world of Cryptocurrency, it became mandatory for people to buy this fastest growth digital currency and give a boost to their investment. As it’s being proved over past few years that the scope of growth in bitcoin is impressive and future of the same is going to massive. Hence, Buying Bitcoin is an intelligent move. Similarly, You are in need of money, then you can sell your bitcoin at any point of time, from any part of the world and get the amount in your registered bank account instantly. Isn’t that great? </p>
				<p>Hence, let be a part of this revolutionised moment of Digital Currency and see our money grow fast. Invest Now! Grow Now!</p>
				<?php if(!Session::has('user_id')){ ?>
				<a href="signup"><button type="button" class="btn btn-default blue-button">Sign Up</button></a>
				<?php } ?>
			</div>
				<div class="col-sm-6 calculator-right">
				<div class="col-md-11 col-md-offset-1">
				<div class="buy-sell">
					<div class="col-sm-9 col-sm-offset-3">
					<h6>PerfektPay calculator for Buying & Selling Bitcoin </h6>
						<ul id="tabs">
							<li class="active"><a data-toggle="tab" class="tablinks" onclick="openCity(event, 'buy')">Buying</a></li>
							<li  style="width:2px; padding: 0 !important;"><a data-toggle="tab" class="tablinks">|</a></li>
							<li><a data-toggle="tab" class="tablinks" onclick="openCity(event, 'sell')">Selling</a></li>
						</ul>
					</div>
						<div class="tab-content">
						<div id="buy" class="boxes tabcontent" style="display: block;">
							
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">BTC</label></div>
									<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">USD</label></div>
								<div class="col-sm-9"><input type="text" class="form-control  btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">FEE</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">TAX</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">TOTAL</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
						</div>
						<div id="sell" class="boxes tabcontent" style="display: none;">
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">BTC Sell</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">USD Sell</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">FEE</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">TAX</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
								<div class="col-sm-3"><label style=" padding-top: 10px;">TOTAL</label></div>
								<div class="col-sm-9"><input type="text" class="form-control btc-input"></div>
							</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>


	<!--<section class="quotes">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="testimonial-homepage">
						<img src="images/quote.png"><h1 style="display: inline-block;"> Bitcoin Quotes ...</h1>
						<div class="slider" id="slider">
							
							<div class="slItems">
								<div class="slItem">
									<div class="testi-pic">
										<img src="images/testimonial.png">
									</div>
									<div class="testi-text">
										<h3>Nisith Desai </h3>
										<p>International Law and Accounting, Perfektpay Lawyer</p>
									</div>
									<div class="clearfix"></div>
									<div class="full-width-test">
										<p>"Bitcoins per se are not illegal in India. This is in consonance with international approach." </p>
									</div>
								</div>
								<div class="slItem">
									<div class="testi-pic">
										<img src="images/testimonial.png">
									</div>
									<div class="testi-text">
										<h3>Nisith Desai </h3>
										<p>International Law and Accounting, Perfektpay Lawyer</p>
									</div>
									<div class="clearfix"></div>
									<div class="full-width-test">
										<p>"Bitcoins per se are not illegal in India. This is in consonance with international approach." </p>
									</div>
								</div>
								<div class="slItem">
									<div class="testi-pic">
										<img src="images/testimonial.png">
									</div>
									<div class="testi-text">
										<h3>Nisith Desai </h3>
										<p>International Law and Accounting, Perfektpay Lawyer</p>
									</div>
									<div class="clearfix"></div>
									<div class="full-width-test">
										<p>"Bitcoins per se are not illegal in India. This is in consonance with international approach." </p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel-group accordion" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">As a currency</a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse in">
								<div class="panel panel-body">
									<div class="panel-content">
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>Nafa.in</p>
											<p>Buy e-commerce platform vouchers by paying in bitcoin.</p></div>
										</div>
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>Life on Bitcoin</p>
											<p> Stay and dine in hotels using bitcoin.</p></div>
										</div>
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p> Freelancers for bitcoin</p>
											<p>You may pay in bitcoin to get freelance work done or you may do work and get paid in bitcoin.</p></div>
										</div>
										<!--<div class="panel-row">
											<img src="images/small.png">
											<p>Nafa.in</p>
											<p>Buy e-commerce platform vouchers by paying in bitcoin.</p>
											<p>Life on Bitcoin</p>
										</div>
										<div class="panel-row">
											<img src="images/small.png">
											<p>Nafa.in</p>
											<p>Buy e-commerce platform vouchers by paying in bitcoin.</p>
											<p>Life on Bitcoin</p>
										</div>-->
									<!--</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">As a growing asset</a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse collapse">
								<div class="panel panel-body">
									<div class="panel-content">
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>Overpowering every currency:</p>
											<p> The value of bitcoin has seen a strong uptrend over the past few years.</p></div>

											
										</div>
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>Long-term growth</p>
											<p>As the number of bitcoins are limited, the value is expected to grow significantly over the long term.</p></div>
										</div>
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>Digital Gold is the Future</p>
											<p>Often referred to as Digital Gold or Gold 2.0, Bitcoin is a anti-inflationary currency by design and inherits many key properties of Gold.</p></div>
										</div>
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>India & Bitcoins</p>
											<p>India stands to gain a tremendous amount by leveraging bitcoins: Banking the unbanked, micro payments to freelancers, online tips, instantanous & low cost remittance, automated VAT and service-tax payment to government etc.</p></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">As a Gift</a>
								</h4>
							</div>
							<div id="collapse3" class="panel-collapse collapse">
								<div class="panel panel-body">
									<div class="panel-content">
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>Exchange, Convert, Secure</p>
											<p>Bitcoin is a wonderful gift for those you care about most. It may be exchanged for products, converted to local currency or even preserved for the future.</p></div>
										</div>
										<div class="panel-row row">
											<div class="col-sm-2"><img src="images/small.png"></div>
											<div class="col-sm-10"><p>“Surprise” in the E-mail</p>
											<p>Perfektpay enables you to send bitcoin to your loved ones through email. The introductory email also includes a brief description of bitcoin and highlights the unqiue properties of this powerful protocol. Register now to start gifting bitcoins to your loved ones and have them love you even more!</p><div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>-->
	
	<section class="quotes">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
				<div class="chart-box">
				<div id="chartContainer" style="height: 300px; width: 100%;">
				</div>
				<div class="white-box-size"></div>
			</div>

		<div class="col-sm-12" style="margin-top:40px;">
			<div class="btn-group">
			  <button type="button" class="btn btn-primary btn-style 30days">30 Days</button>
			  <button type="button" class="btn btn-primary btn-style 60days">60 Days</button>
			  <button type="button" class="btn btn-primary btn-style 180days">180 Days</button>
			  <button type="button" class="btn btn-primary btn-style 1year">1 Year</button>
			  <button type="button" class="btn btn-primary btn-style 2year">2 Year</button>
			  <button type="button" class="btn btn-primary btn-style allt">All Time</button>
			</div>
		</div>
				</div>
				<div class="col-md-3 analyze">
				<h3>Analyze Your Bitcoin Currency</h3>
				<p>Perfekt pay makes setting up your bitcoin wallet fast and easy. Our search engine algorithms rate and grade all websites found in the internet and prove you. </p>
				</div>
			</div>
		</div>
	</section>
	
	
	
	<section class="meeting">
		<div class="container">
			<div class="row">
			    <h3>What is Bitcoin?</h3>
				<p>Bitcoin is the world's first open-source decentralized digital currency<br>(a digital token that has a perceived value) and payment network (that can be used to send and receive the bitcoin itself). Due to its many unique properties,<br>Bitcoin allows exciting uses that could not be achieved<br>by any previous payment system.</p>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
<!--	<section class="sponser">
		<div class="container">
			<div class="row">
				<img src="images/crunch1.jpg">
				<img src="images/coin-desk1.jpg">
				<img src="images/bitcoin.jpg">
				<img src="images/economic-times.jpg">
				<img src="images/jws.jpg">
				<img src="images/insider.jpg">
			</div>
		</div>
	</section>
	<div class="clearfix"></div>-->

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script>
window.onload = function () {
var data19  = <?php echo file_get_contents('https://api.blockchain.info/stats');?>

data19 = Math.round(data19.market_price_usd);;
 $(".btc").append("BUY BTC: <i class='fa fa-usd' aria-hidden='true'></i>"+data19);
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	zoomEnabled: true,
	title: {
		text: "Average USD market price across major bitcoin exchanges"
	},
	data: [{
		type: "area",
		dataPoints: []
	}]
});


var data12  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?format=json');?>

data12 = data12.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data12.length,data12);  
chart.render();
function addDataPoints(noOfDps,tata) {
	chart.options.data[0].dataPoints = [];
	var xVal = chart.options.data[0].dataPoints.length + 1, yVal = 100;
	for(var i = 0; i < noOfDps; i++) {
		yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
		chart.options.data[0].dataPoints.push({x: new Date(tata[i].x*1000),y: tata[i].y});	
		xVal++;
	}
}

$('.30days').click(function(){
	var data13  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=30days&format=json');?>

data13 = data13.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data13.length,data13);  
chart.render();
});
$('.60days').click(function(){
	var data14  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=60days&format=json');?>

data14 = data14.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data14.length,data14);  
chart.render();
});
$('.180days').click(function(){
	var data15  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=180days&format=json');?>

data15 = data15.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data15.length,data15);  
chart.render();
});
$('.1year').click(function(){
	var data16  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=1year&format=json');?>

data16 = data16.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data16.length,data16);  
chart.render();
});
$('.2year').click(function(){
	var data17  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=2years&format=json');?>

data17 = data17.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data17.length,data17);  
chart.render();
});
$('.allt').click(function(){
	var data18  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=all&format=json');?>

data18 = data18.values;
// console.log(new Date(data12[0].x*1000).toISOString());
addDataPoints(data18.length,data18);  
chart.render();
});


						
						
}

</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5abf6da5d7591465c7091495/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
@stop