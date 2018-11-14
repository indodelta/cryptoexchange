<!DOCTYPE html>
	<html>
		<head>
			<title>All Deposits</title>
		</head>
		<body>			
			<table>
				<tbody>
					<tr>
						<th>S.N.</th>
						<th>Date</th>
                        <th>User Name</th>
                        <th>Full Name</th>
		                <th>Email</th>
		                <th>mobile</th>
		                <th>Country</th>
                        <th>Payment Mode</th>
                        <th style="text-aliogn:right;">Total Amount</th>
					</tr>
					@foreach($userList as $key=>$val)                              
                        <tr>                            
                            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
                            <td>{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</td>
                            <td>{{$val->username}}</td>
                            <td>{{$val->first_name}}&nbsp;{{$val->last_name}}</td>
                            <td>{{$val->email}}</td>
			                <td>{{$val->country_code}}-{{$val->mobile_no}}</td>
			                <td>{{$val->country}}</td>
                            <td>@if($val->modetype == 1)
                                    Bitcoin                           
                                  @elseif($val->modetype == 2)
                                    Bank 
                                  @endif
                            </td>
                            <td style="text-aliogn:right;">{{$val->amount}}</td>                               
                        </tr>                              
                    @endforeach
				</tbody>	
			</table>
		</body>
	</html>