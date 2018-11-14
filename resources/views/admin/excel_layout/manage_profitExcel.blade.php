<!DOCTYPE html>
<html>
<head>
	<title>Manage Profit</title>
</head>
<body>			
<table>
		<thead>
			<tr>
				<th >#</th>
				<th>Order Id</th>
				<th>Date</th>
				<th >Type</th>
				<th style="text-align:right;">Price</th>
	            <th style="text-align:right;">Quantity</th>
	            <th style="text-align:right;">USD Conversion</th>
				<th style="text-align:right;">Fees</th>    
				<th style="text-align:right;">Commission</th>        
				<th style="text-align:right;">Profit(USD)</th>
			</tr>
		</thead>
		<tbody>     
		</tbody>
		@foreach($userList as $key=>$val) 
		<tr>
			<td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
			<td>
				@if($val->side ==1)
				ORB{{sprintf("%04s", $val->id)}}Mkl
				@elseif($val->side ==2)
				OSR{{sprintf("%04s", $val->id)}}SWl
				@endif
			</td>
			<td>{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</td>
			<td>
				@if($val->side ==1)
				Buy
				@elseif($val->side ==2)
				Sell
				@endif
			</td>
			<td style="text-align:right;">{{sprintf("%.2f",($val->limit_price))}}</td>
            <td style="text-align:right;">{{sprintf("%.4f",($val->quantity))}}</td>
            <td style="text-align:right;">{{sprintf("%.2f",($val->usd_conversion))}}</td>
			<td style="text-align:right;">
				@if($val->usd_conversion > 1000)
				{{sprintf("%.4f",($val->pc_calculated_amount - $val->itbit_calculated_amount))}} 
				@else
				NA
				@endif
			</td>
			<td style="text-align:right;">{{$val->perfektpay_comm}}</td>
			<td style="text-align:right;">
				@if($val->side ==1)
				{{sprintf("%.4f", ($val->total_paid - $val->pc_calculated_amount) - ($val->limit_price * $val->quantity))}}
				@elseif($val->side ==2)
				{{sprintf("%.4f", ($val->quantity * $val->limit_price) - ($val->total_paid))}}
				@endif
			</td>
		</tr>
		@endforeach  
	</table>
</body>
</html>
