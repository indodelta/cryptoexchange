@extends('layouts.app')
@section('content')
<style>

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
	<section class="about-banner">
		<div class="container">
		<p><div class="banner-list">
         	<ul style='visibility:hidden'>
						<li>BUY BTC: <i class="fa fa-inr" aria-hidden="true"></i> 175,667</li>
						<li>SELL BTC: <i class="fa fa-inr" aria-hidden="true"></i> 170,837</li>
					</ul>
		</div> </p>
		<h3>About Bitcoin</h3>
	</section>
	<div class="clearfix"></div>
	<section class="bitcoin-content about-back">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">	
					<div class="col-md-7 bitcoin-left">
					<img src="images/about-bitcoin.png">
					</div>
					<div class="col-md-5 bitcoin-right">
					<h4>What is Bitcoin?</h4>
						 <p>Bitcoin is a digital asset and a payment system. It is commonly called a decentralized digital currency.It was invented by Satoshi Nakamoto in 2009. It is an open source software. This means, that no person, company or country owns this network just like no one owns the Internet.The system is peer-to-peer, that is, users can transact directly without an intermediary like a bank, a credit card company or a clearing house.Transactions are verified by network nodes and recorded in a public distributed ledger called the blockchain. To know what is blockchain, <a href="https://en.wikipedia.org/wiki/History_of_bitcoin" target="_blank"> click here</a>. Check out the history of bitcoin here.</p>

						<h4>Bitcoin Mining</h4>
						<p>Just like anyone can join the Internet, anyone can help to verify and record payments into the block chain. This process is called mining.In mining, users offer their computing power.Miners are rewarded with newly created bitcoins and transaction fees.Currently, miners receive 12.5 bitcoins every 10 minutes. This halves every 4 years. The next halving will happen in mid-2020.</p>
						
				</div>
				</div>
		</div>
		</div>
	</section>
	
	<section class="bitcoin-vedio about-back">
	<div class="container">
	<div class="row">
	
	<div class="col-sm-12">
	<h4>Videos on Bitcoin</h4>
	<div class="col-sm-4">
	<div class="inner-box-bitcoin">
	<iframe width="100%" height="200" src="https://www.youtube.com/embed/l9jOJk30eQs" frameborder="0" allowfullscreen></iframe>
	
	</div>
	</div>
	<div class="col-sm-4">
	<div class="inner-box-bitcoin">
	<iframe width="100%" height="200" src="https://www.youtube.com/embed/l9jOJk30eQs" frameborder="0" allowfullscreen></iframe>

	</div>
	</div>
	<div class="col-sm-4">
	<div class="inner-box-bitcoin">
	<iframe width="100%" height="200" src="https://www.youtube.com/embed/l9jOJk30eQs" frameborder="0" allowfullscreen></iframe>
	</div>
	</div>
	</div>
	</div>
	</div>
	</section>
	
	<div class="clearfix"></div>
	
	
	<section class="boom-cycle about-back">
	<div class="container-fluid">
	<div class="row">
	<div class="container">
	<div class="col-sm-12">
	<h4>Bitcoin Boom Cycles</h4>
	<p>Like any other commodity, bitcoins price keeps changing. We have broken down bitcoin’s historic price in separate
graphs. We see that if we ignore the short term highs and lows, bitcoin is increasing in value.</p><br>
	</div>
	</div>
	<div class="chart-box">
				<div id="chartContainer" style="height: 300px; width: 100%;">
				</div>
				<div class="white-box-size"></div>
			</div>
	</div>

	</div>
	</div>
	</section>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script>
window.onload = function () {

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


var data12  = <?php echo file_get_contents('https://api.blockchain.info/charts/market-price?timespan=all&format=json');?>

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

}
</script>

@stop