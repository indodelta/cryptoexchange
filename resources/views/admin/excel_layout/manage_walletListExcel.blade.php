<!DOCTYPE html>
	<html>
		<head>
			<title>Manage Wallet</title>
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
                        <th style="text-align:right;">Referred Amount</th>
			            <th style="text-align:right;">Amount</th>
			            <th style="max-width:200px;">Remarks</th>
			            <th style="text-align:center;">Action</th>
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
                            <td style="text-aliogn:right;">@if($val->ref_amount == null)
					              NA                             
					            @elseif($val->ref_amount != null)
					              {{sprintf("%.2f", $val->ref_amount)}}
					            @endif
					        </td>   
					        <td style="text-align:right;">{{sprintf("%.2f", $val->amount)}}</td>
					        <td style="max-width:200px">{{$val->remark}}</td>
					        <td>@if($val->type == 0)
					              Credit                             
					            @elseif($val->type == 1)
					              Debit
					            @endif
					          </td>                            
                        </tr>                              
                    @endforeach
				</tbody>	
			</table>
		</body>
	</html>