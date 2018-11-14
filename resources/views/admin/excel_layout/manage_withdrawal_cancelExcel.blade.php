<!DOCTYPE html>
	<html>
		<head>
			<title>Manage Withdrawal Cancel</title>
		</head>
		<body>			
			<table>
				<tbody>
					<tr>
						<th>S.N.</th>
                        <th>User Name</th>
                        <th>Full Name</th>
		                <th>Email</th>
		                <th>mobile</th>
		                <th>Payment Mode </th>
		                <th>Beneficiary Name</th>
		                <th>Account Number</th>
		                <th>Bank Name</th>
		                <th>Swift Code</th>
		                <th >Amount</th>
		                <th >Request Date</th>
		                <th ">Cancel Date</th>
		                <th style="text-align:right;">Status</th>
                        
					</tr>
					@foreach($userList as $key=>$val)                              
                        <tr>                            
                            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
                            <td>{{$val->username}}</td>
                            <td>{{$val->first_name}}&nbsp;{{$val->last_name}}</td>
                            <td>{{$val->email}}</td>
			                <td>{{$val->country_code}}-{{$val->mobile_no}}</td>
			                <td style="text-align:left;">
				              @if($val->modetype == 2)
				              Bitcoin                             
				              @elseif($val->modetype == 1)
				              Bank
				              @endif
				            </td>
				            <td style="text-align:left;">
				              @if($val->beneficiary_name && $val->beneficiary_name!='x'){{$val->beneficiary_name}}<br>@endif
				             </td> 
				             <td> @if($val->account_no && $val->account_no!='x'){{$val->account_no}}<br>@endif </td>
				             <td>
				              @if($val->bank_name && $val->bank_name!='x'){{$val->bank_name}}<br>@endif
				              </td>
				              <td>
				              @if($val->swift_code && $val->swift_code!='x'){{$val->swift_code}}@endif
				            </td>

				            <td style="text-align:right;">@if($val->modetype == 2)
				                  {{$val->amount}}                             
				              @elseif($val->modetype == 1)
				                  {{sprintf("%.2f", $val->amount)}}
				              @endif
				            </td>
                            <td style="text-align:right;">{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</td>
                            <td style="text-align:right;">{{date("d-m-Y h:i:s", strtotime($val->updated_at))}}</td>
                            <td>Cancel</td>
                        </tr>                              
                    @endforeach
				</tbody>	
			</table>
		</body>
	</html>
