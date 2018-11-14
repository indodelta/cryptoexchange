@extends('admin.layout.layout')
@section('content')
<!-- Main -->

<div class="content-main " id="content-main">
  <!-- ############ Main START-->
  <!-- start: page -->
  <div class="padding">
    <div class="row">
      <div class="col-lg-12">
        <div class="box">
          <div class="box-header">
            <h4>Bitcoin Deposits</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="p-2">
        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
        <form action="{!! route('bitcoin-transactions') !!}" method="get">
          <div class="row">
            <div class="col-sm-4">
              <label></label>
              <div class='input-group'>
               <input type='text' class="form-control datetimepicker-input" id="datetimepicker1" data-toggle="datetimepicker1" data-target="#datetimepicker1" name="datetimepicker1" value="{{(!empty($_GET['datetimepicker1'])?$_GET['datetimepicker1']:'')}}" placeholder="Start date">
               <span class="input-group-addon">
                 &nbsp;TO&nbsp;
               </span>
               <input type='text' class="form-control datetimepicker-input" id="datetimepicker2" data-toggle="datetimepicker2" data-target="#datetimepicker2" name="datetimepicker2" value="{{(!empty($_GET['datetimepicker2'])?$_GET['datetimepicker2']:'')}}" placeholder="End Date">
             </div>            
           </div>
            <div class="col-sm-3">
           </div>
            <div class="col-sm-5">
                <label></label>
                <div class="input-group mb-sm">
                  <input type="hidden" name="column" value="username" id="column">  
                  <input class="form-control" type="text" placeholder="Search by User Name" name="param" value="{{(!empty($_GET['param'])?$_GET['param']:'')}}" id="param">
                  <span class="input-group-btn">
                    <button class="btn btn-info" type="submit">Search</button>
                    <a href="{{URL('/organize/bitcoinTransactionListdownload')}}/{{(!empty($_GET['datetimepicker1'])?date("Y-m-d", strtotime($_GET['datetimepicker1'])):'null')}}/{{(!empty($_GET['datetimepicker2'])?date("Y-m-d", strtotime($_GET['datetimepicker2'])):'null')}}/{{(!empty($_GET['column'])?$_GET['column']:'null')}}/{{(!empty($_GET['param'])?$_GET['param']:'null')}}">
                    <button class="btn btn-success" type="button"><i class="fa fa-file-excel-o"></i></button>
                    </a>
                  </span>
                </div>
              </div>
          </div>
        </form>  
     </div>
     <div class="table-responsive">
      <table class="table table-bordered b-t">
        <thead>
          <tr>
           <th>#</th>
           <th>Transaction Id</th>
           <th>Date</th>
           <th>User Info</th>
           <th>Payment Mode</th>
           <th style="text-align:right;">Total Amount</th>
           <th style="text-align:center;">Action</th>
         </tr>
       </thead>
        <tbody>
        @foreach($userList as $key=>$val)                              
          <tr>
            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
            <td>BTC{{sprintf("%04s", $val->transactionsId)}} </td>
            <td>{{date("d-m-Y h:m:i", strtotime($val->created_at))}}</td>
            <td><i class="fa fa-user"></i>@if($val->first_name)&nbsp;{{$val->first_name}}@endif
                  @if($val->last_name)&nbsp;{{$val->last_name}}@endif 
                  ({{$val->username}})
              @if($val->email)<br><i class="fa fa-envelope"></i>&nbsp;{{$val->email}}@endif             
              @if($val->mobile_no)<br><i class="fa fa-phone"></i>&nbsp;{{$val->country_code}}-{{$val->mobile_no}}@endif
              @if($val->country)<br><i class="fa fa-map-marker"></i>&nbsp;{{$val->country}}@endif
            </td>
            <td>Bitcoin</td>
            <td style="text-align:right;">{{sprintf("%.4f", $val->amount)}}</td>            
            <td class="app_req" id="" style="text-align:center;">
               @if($val->status==2)
                <span class="badge danger pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Pending</span><br>
                @else
                <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Confirmed</span><br>
                @endif
               @if($val->status==6)
              <button class="btn btn-xs danger update_action" data-action="update_user_action_status_bit" data-key="{{Crypt::encrypt($val->transactionsId)}}">Pending</button>
              @elseif($val->status==1)  
              <button class="btn badge success text-u-c" disabled>Approved</button>
              @else
              <button class="btn badge warning text-u-c" disabled>Not Confirm</button>
              @endif
            </td>
          </tr>
        @endforeach  
      </tbody>
      </table>
    </div>
    <footer class="light lt p-2">
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-6">  
           {{$userList->appends(array_filter($_GET))->links()}}       
        </div>
        <div class="col-sm-2">   
        </div>
      </div>
    </footer>
  </div>
</div>
</div> 
<!-- Main END-->
@endsection