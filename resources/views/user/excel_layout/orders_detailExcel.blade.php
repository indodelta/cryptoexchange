<!DOCTYPE html>
	<html>
		<head>
			<title>All Deposits</title>
		</head>
		<body>			
			<table>
				<tbody>
					<tr class="bottom-border">
						<th>S.no</th>
						<th>Date</th>
						<th>Instrument</th>
						<th>Direction</th>
						<th class="text-right">Currency 1</th>
						<th class="text-right">Currency 2</th>
						<th class="text-right">Rate</th>
						<th class="text-right">Fee</th>
					</tr>
					@foreach($orders_detail as $key=>$odd_value)                              
                        <tr>                            
                            <td>{{++$key}}</td>
                            <td>{{date("Y-m-d h:i", strtotime($odd_value->created_at))}}</td>
							<td>BTCUSD</td>
							<td>{{$odd_value->side == 1?"Buy":"Sell"}}</td>
							<td class="text-right"><i class="fa fa-bitcoin" aria-hidden="true"></i> {{number_format((float)$odd_value->quantity, 4, '.', '')}}</td>
							<td class="text-right"><b>$</b>{{number_format((float)$odd_value->limit_price_actual*(float)$odd_value->quantity, 2, '.', '')}}</td>
							<td class="text-right"><b>$</b>{{number_format((float)$odd_value->limit_price_actual, 2, '.', '')}}</td>
							<td class="text-right"><b>$</b>{{number_format((float)$odd_value->pc_calculated_amount, 2, '.', '')}}</td>
                                                         
                        </tr>                              
                    @endforeach
				</tbody>	
			</table>
		</body>
	</html>