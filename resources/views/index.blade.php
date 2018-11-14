@extends('layouts.app')
@section('title') 
    Buy and Sell Bitcoins Online | Sell Bitcoins Instantly | Best Site to Buy Bitcoins
@stop
@section('content12')
<meta name="description" content="Buy and Sell Bitcoins in the World Online easily and securely at Perfektpay. Perfektpay is the Best Site to Buy and Sell Bitcoins Instantly. Global Phone Support +85260245489!">
<meta name=keywords content="Sell Bitcoins Instantly, Best Site to Buy Bitcoins, Buy Cheap Bitcoins Online, Buy and Sell Bitcoins Online, How to Buy Bitcoins">
<meta name="p:domain_verify" content="d4453382645c29c60d2f89a0e73b7854"/>
<script type="application/ld+json">{"@context": "http://schema.org", "@type": "Organization", "url": "https://www.perfektpay.com/", "name": "Perfekt Capital Limited", "contactPoint":{"@type": "ContactPoint", "telephone": "+852 6024 5489", "contactType": "Customer service"}}
</script>
<link rel="alternate" href="https://www.perfektpay.com/" hreflang="en-us"/>
@stop
@section('content')
<style>.content-main a{color: #35acd1;}button.btn.btn-primary.btn-style{border: #003466 1px solid; background: transparent; color: #003466;}a.canvasjs-chart-credit{display: none;}.white-box-size{width: 80px; background: #fff; height: 20px; left: 0; position: absolute; bottom: 0px;}.chart-box{position:relative;}.chart-box-inner-load{position: absolute; top: 0; z-index: 9; font-size: 40px; background: rgba(225,225,225,0.7); width: 100%; height: 100%; bottom: 0; vertical-align: middle; left: 0; right: 0; text-align: center; padding: 10% 0; display:none;}</style><script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/currency.js"></script><section class="banner"> <div id="myCarousel" class="carousel slide" data-ride="carousel"> <ol class="carousel-indicators"> <li data-target="#myCarousel" data-slide-to="0" class="active"></li><li data-target="#myCarousel" data-slide-to="1"></li><li data-target="#myCarousel" data-slide-to="2"></li></ol> <div class="carousel-inner"> <div class="item active"> <img src="images/banner.jpg" alt="PerfektPay" style="width:100%;"><div class="carousel-caption"><div class="banner-list"> <ul><li class="btc" style="color: #00f71d !important"></li></ul></div><div class="content-main"><h4>Leading<br><strong>CRYPTOASSET & BLOCKCHAIN</strong><br>Company !</h4><p style="visibility:hidden;">Perfektpay makes setting up your bitcoin wallet fast and easy</p><h5><a href="signup">Get Started&nbsp;<img src="images/arroww.png" alt="Get Started"></a></h5> </div></div></div><a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span> </a> </div></section><div class="clearfix"></div><section class="buy-accept"><div class="container"><div class="row"><div class="col-sm-4"><img src="images/bit.png" alt="Buy Bitcoin"><h2>Buy</h2><p>Start buying Bitcoin through our deep liquidity.</p></div><div class="col-sm-4"><img src="images/usee.png" alt="Sell Bitcoin"><h2>Sell</h2><p>Encash your Bitcoin to your Bank account.</p></div><div class="col-sm-4"><img src="images/accept.png" alt="Exchange"><h2>Exchange</h2><p>Accept Bitcoin from your friends and customers around the world and encash in fiat currency.</p></div></div></div></section><div class="clearfix"></div><section class="calculator"><div class="container"><div class="row"><div class="col-sm-6 calculator-left"><h1>Buy and Sell bitcoin</h1><br><p>Where bitcoin has revolutionised the world of Cryptocurrency, it became mandatory for people to buy this fastest growth digital currency and give a boost to their investment. As it’s being proved over past few years that the scope of growth in bitcoin is impressive and future of the same is going to massive. Hence, Buying Bitcoin is an intelligent move. Similarly, You are in need of money, then you can sell your bitcoin at any point of time, from any part of the world and get the amount in your registered bank account instantly. Isn’t that great? </p><p>Hence, let be a part of this revolutionised moment of Digital Currency and see our money grow fast. Invest Now! Grow Now!</p><?php if(!Session::has('user_id')){ ?><a href="signup"><button type="button" class="btn btn-default blue-button">Sign Up</button></a><?php } ?></div><div class="col-sm-6 calculator-right"><div class="col-md-11 col-md-offset-1"><div class="buy-sell"><div class="col-sm-9 col-sm-offset-3"><h6>PerfektPay calculator for Buying & Selling Bitcoin </h6><br><ul id="tabs"><li class="active"><a data-toggle="tab" class="tablinks" onclick="openCity(event, 'buy')">Buying</a></li><li style="width:2px; padding: 0 !important;"><a data-toggle="tab" class="tablinks">|</a></li><li><a data-toggle="tab" class="tablinks" onclick="openCity(event, 'sell')">Selling</a></li></ul><br></div><div class="tab-content"><div id="buy" class="boxes tabcontent" style="display: block;"><div class="row"><br><div class="form-group col-sm-12"><div class="col-sm-3"><label style=" padding-top: 10px;">BTC</label></div><div class="col-sm-9"><input type="text" id="btc" class="form-control btc-input"></div></div></div><div class="row"><div class="form-group col-sm-12"><div class="col-sm-3"><label style=" padding-top: 10px;">USD</label></div><div class="col-sm-9"><input type="text" id="usd" class="form-control btc-input"></div></div></div></div><div id="sell" class="boxes tabcontent" style="display: none;"><div class="row"><div class="form-group col-sm-12"><div class="col-sm-3"><label style=" padding-top: 10px;">BTC Sell</label></div><div class="col-sm-9"><input type="text" id="btc_sell" class="form-control btc-input"></div></div></div><div class="row"><div class="form-group col-sm-12"><div class="col-sm-3"><label style=" padding-top: 10px;">USD Sell</label></div><div class="col-sm-9"><input type="text" id="usd_sell" class="form-control btc-input"></div></div></div></div></div></div></div></div></div></div></section><div class="clearfix"></div><section class="quotes"><div class="container"><div class="row"><div class="col-md-12"><div class="chart-box"><div class="chart-box-inner-load"> <span class="buttonload"> <i class="fa fa-spinner fa-spin"></i>Loading.. </span> </div><div id="chartContainer" style="height: 300px; width: 100%;"></div><div class="white-box-size"></div></div><div class="col-sm-12" style="margin-top:40px;"><div class="btn-group"> <button type="button" class="btn btn-primary btn-style 30days">30 Days</button> <button type="button" class="btn btn-primary btn-style 60days">60 Days</button> <button type="button" class="btn btn-primary btn-style 180days">180 Days</button> <button type="button" class="btn btn-primary btn-style 1year">1 Year</button> <button type="button" class="btn btn-primary btn-style 2year">2 Year</button> <button type="button" class="btn btn-primary btn-style allt">All Time</button></div></div></div></div></div></section>
@csrf
<section class="meeting"><div class="container"><div class="row"> <h3>What is Bitcoin?</h3><p>Bitcoin is the world's first open-source decentralized digital currency<br>(a digital token that has a perceived value) and payment network (that can be used to send and receive the bitcoin itself). Due to its many unique properties,<br>Bitcoin allows exciting uses that could not be achieved<br>by any previous payment system.</p></div></div></section><div class="clearfix"></div><script>

window.onload = function () {
	var btc_s = {{sprintf("%.2f",(isset($itbit['old_bid'])?$itbit['bid']:((-3*$itbit['bid'])/100)+$itbit['bid']))}};
	var btc_p = {{sprintf("%.2f",(isset($itbit['old_ask'])?$itbit['ask']:((3*$itbit['ask'])/100)+$itbit['ask']))}};
	var getEl = (id) => {
  		return document.getElementById(id) || null; 
	};
	var btc  	 = getEl('btc');
	var usd 	 = getEl('usd');
	var btc_sell = getEl('btc_sell');
	var usd_sell = getEl('usd_sell');

	btc.onclick = btc.onchange = btc.onkeyup = () => {
		usd1 = btc.value*btc_p;
		usd.value = usd1;
	}
	usd.onclick = usd.onchange = usd.onkeyup = () => {
		btc2 = usd.value/btc_p;
		btc.value = btc2;
	}
	btc_sell.onclick = btc_sell.onchange = btc_sell.onkeyup = () => {
		usd1 = btc_sell.value*btc_s;
		usd_sell.value = usd1;
	}
	usd_sell.onclick = usd_sell.onchange = usd_sell.onkeyup = () => {
		btc2 = usd_sell.value/btc_s;
		btc_sell.value = btc2;
	}

 $(".btc").append("BUY BTC: <i class='fa fa-usd' aria-hidden='true'></i>"+{{sprintf("%.2f", isset($itbit['old_ask'])?$itbit['ask']:(((3*$itbit['ask'])/100)+$itbit['ask']))}});
 	market_price(""),$(".30days").click(function(){market_price("30days")}),$(".60days").click(function(){market_price("60days")}),$(".180days").click(function(){market_price("180days")}),$(".1year").click(function(){market_price("1year")}),$(".2year").click(function(){market_price("2years")}),$(".allt").click(function(){market_price("all")});					
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