<!DOCTYPE html>
<html>
   <head>
      <title>Bank Transactions</title>
   </head>
   <body>
      <table>
         <tbody>
            <tr>
               <th>S.N.</th>
               <th>Date</th>
               <th>Transaction</th>               
               <th>User Name</th>
               <th>Full Name</th>
               <th>Email</th>
               <th>mobile</th>
               <th>Country</th>
               <th>Payment Mode</th>
               <th>Total Amount</th>
            </tr>
            @foreach($userList as $key=>$val)                              
            <tr>
               <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
               <td>{{date("d-m-Y h:m:i", strtotime($val->created_at))}}</td>
               <td>BTC{{sprintf("%04s", $val->transactionsId)}}</td>               
               <td>{{$val->username}}</td>
               <td>{{$val->first_name}}&nbsp;{{$val->last_name}}</td>
               <td>{{$val->email}}</td>
               <td>{{$val->country_code}}-{{$val->mobile_no}}</td>
               <td>{{$val->country}}</td>
               <td>Bitcoin</td>
               <td style="text-align:right;">{{sprintf("%.4f", $val->amount)}}</td> 
            </tr>
            @endforeach
         </tbody>
      </table>
   </body>
</html>