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

                        <th>User Name</th>

                        <th>Payment Mode</th>

                        <th>Total Amount</th>

					</tr>



					@foreach($userList as $key=>$val)                              

                        <tr>                            

                            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>

                            <td>{{$val->created_at}}</td>

                            <td>{{$val->username}}</td>

                            <td>Bank</td>

                            <td>{{$val->amount}}</td>                               

                        </tr>                              

                    @endforeach

				</tbody>	

			</table>

		</body>

	</html>