<!DOCTYPE html>
	<html>
		<head>
			<title>Manage Order Sell</title>
		</head>
		<body>			
			<table>
				<tbody>
					<tr>
						<th>S.N.</th>
						<th>Transaction Id</th>
						<th>Date</th>
                        <th>User Name</th>
                        <th>Full Name</th>
		                <th>Email</th>
		                <th>mobile</th>
		                <th style="text-align:right;">Quantity</th>
			            <th style="text-align:right;">Limit Price</th>
			            <th style="text-align:right;">Filled</th>
			            <th style="text-align:right;">Remaining</th>
			            <th style="text-align:right;">Avg. Price</th>
			            <th style="text-align:center;">Status</th> 
					</tr>
					@foreach($userList as $key=>$val)                              
                        <tr>                            
                            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
                            <td>OSR{{sprintf("%04s", $val->id)}}SWl</td>
                            <td>{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</td>
                            <td>{{$val->username}}</td>
                            <td>{{$val->first_name}}&nbsp;{{$val->last_name}}</td>
                            <td>{{$val->email}}</td>
			                <td>{{$val->country_code}}-{{$val->mobile_no}}</td>		                
							<td style="text-align:right;">{{$val->quantity}}</td>
				         <td style="text-align:right;">{{sprintf("%.2f", $val->limit_price)}}</td>
				            <td style="text-align:right;">{{sprintf("%.4f", $val->filled)}}</td>
				          	<td style="text-align:right;">{{$val->remaining}}</td>
				         	<td style="text-align:right;">{{sprintf("%.2f", $val->avg_price)}}</td>
				          <td style="text-align:center;">
				            @if($val->status==0)Open
				            @elseif($val->status==1)Filled
				            @elseif($val->status==2)Cancelled
				            @endif
				          </td>
                        </tr>                              
                    @endforeach
				</tbody>	
			</table>
		</body>
	</html>
