<!DOCTYPE html>
	<html>
		<head>
			<title>All Deposits</title>
		</head>
		<body>			
			<table>
				<tbody>
					<tr>
			           <th >#</th>
			           <th >User Name</th>
			           <th >Full Name</th>
			           <th >Email</th>
			           <th >2FA Status</th>
			           <th style="text-align:center;" colspan="2">Trading </th>
			           <th style="text-align:center;" colspan="2">Ticker Price</th>
			         </tr>
			         <tr>
			          <th></th>
			          <th></th>
			          <th></th>
			          <th></th>
			          <th></th>
			          <th class="text-center">Buy</th>
			          <th class="text-center">Sell</th>
			          <th class="text-center">Bid</th>
			          <th class="text-center">Ask</th>
			        </tr>
					@foreach($userList as $key=>$val)                              
                        <tr>                            
                            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
                            <td>{{$val->username}}</td>
                            <td>{{$val->first_name}}&nbsp;{{$val->last_name}}</td>
                            <td>{{$val->email}}</td>
                            <td>
				              @if(($val->G_AUTH == 0 && $val->is_gAuth == 0 && $val->AUTH_skip ==1)|| ($val->G_AUTH ==0 && $val->is_gAuth==0 && $val->AUTH_skip==0))
				                OFF
				              @else
				                ON
				              @endif
				            </td>	
				            <td>{{$val->trading_buy}}</td>
				            <td>{{$val->trading_sell}}</td>
				            <td>{{$val->ticker_paid}}</td>
				            <td>{{$val->ticker_ask}}</td>
                        </tr>                              
                    @endforeach
				</tbody>	
			</table>
		</body>
	</html>