<!DOCTYPE html>
	<html>
		<head>
			<title>All Deposits</title>
		</head>
		<body>			
			<table>
        <thead>
          <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Name</th>
            <th>email</th>
            <th>mobile</th>
            <th>country</th>
            <th>Reg. Date</th>
            <th>Available Balance</th>
            <th style="text-align:center;">KYC Status</th>
            <th style="text-align:center;">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($userList as $key=>$val)
          <tr>   
          	<td>{{++$key}}</td>                         
            <td>{{ $val->username}}</td>
            <td>{{ $val->first_name}}&nbsp;{{ $val->last_name}}</td>
            <td>{{$val->email}}</td>
            <td>{{$val->country_code}}&nbsp;{{$val->mobile_no}}</td>
            <td>{{$val->countryname}}</td>
            <td style="white-space:nowrap">{{ Carbon\Carbon::parse($val->created_at)->format('d-M-Y') }}</td>  
            <td style="white-space:nowrap">฿ {{sprintf("%.4f",$val->total_btc)}}<br>
                $  {{sprintf("%.2f",$val->total_usd)}}
            </td>      
            <td style="text-align:center;"> 
              @if($val->kyc_img == 0 )     
              <span class="badge alert-info pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>NO Document</span>
              @elseif($val->user_kyc_status == 0 && $val->kyc_img == 1)
              <span class="badge warning pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Pending</span>
              @elseif($val->user_kyc_status == 1 && $val->kyc_img == 1)  
              <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Approved</span>              
              @elseif($val->user_kyc_status == 2 && $val->kyc_img == 1) 
              <span class="badge danger pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Rejected</span>
              @endif
            </td>
            <td class="app_req" id="{{$val->id}}"> 
              @if($val->status == 0)
              <span class="badge danger pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Deactivated</span>              
              @elseif($val->status == 1)
              <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Activated</span> 
              @endif
            </td>
          </tr>                          
          @endforeach  
        </tbody>
      </table>
		</body>
	</html>