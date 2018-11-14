@extends('admin.layout.layout')
@section('content')
<!-- ############ Content START-->
<style type="text/css">
 .btn.dark-white.p-x-md {
   background: transparent none repeat scroll 0 0 !important;
   color: #fff !important;
   position: absolute;
   right: -30px;
   top: -30px;
 }
 #m-a-a .modal-content {
   color: rgba(70, 90, 110, 0.85);
   margin-top: 100px;
 }
 .modal-body {
   padding: 0;
 }
</style>
<!-- .modal -->
<div id="m-a-a" class="modal fade" data-backdrop="true">
 <div class="modal-dialog animate" id="animate">
  <div class="modal-content">
   <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">X</button> 
   <div class="modal-body text-center p-lg">
    <img src="" id="zoom" style="width:100%; max-height: 600px;">
  </div>
</div>
<!-- /.modal-content -->
</div>
</div>

<!-- / .modal -->
<div id="content" class="app-content box-shadow-3" role="main">
 <div class="content-main " id="content-main">
  <div class="padding">
@if(Session::has('message'))
  @if(Session::get('message') == 'debit')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        successAlert('Amount Debit Successfully.');
    }, false);
    </script>
   @else if(Session::get('message') =='credit')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        successAlert('Amount Cradit Successfully.');
    }, false);
    </script>
   @endif
@endif

@if(Session::has('error')) 
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      errorAlert('System Error');
  }, false);
  </script>
@endif

<!-- start: page -->
<section class="panel panel-featured">
  <div class="row">
   <div class="col-lg-12">
    <section class="panel panel-featured">
     <header class="panel-heading" style="padding-left: 12px; padding-top: 12px;background: #e0ebeb;    padding-bottom: 3px;">
      <div class="panel-actions">
      </div>
      <h5 class="panel-title">Bank Transactions</h5>
    </header>
    <input type="hidden" id="csrf-token" name="cdsrf-token" value="{{ csrf_token() }}">
    <form action="{{URL('/admin/user_wallet')}}" method="post">
      <div class="col-md-12" style="margin-top: 14px;">
       <div class="row">
        <div class="col-sm-2">
         {{ csrf_field() }}   
         <div class="form-group">
          <label>User Name</label>  
          <div class="input-group"> 
           <select  class="form-control" placeholder="Enter Username" id="userName" name="userName" onchange="refamt();" required>
           </select>                                           
         </div>
       </div>
     </div>
     <div class="col-sm-2">
       <div class="form-group">
        <label>Ref. Amount</label>  
        <div class="input-group"> 
         <select  class="form-control" placeholder="Ref. Amount" id="ref_amount_id" name="ref_amount_id">
         </select>                                           
       </div>
     </div>
   </div>
   <div class="col-sm-2">
     <div class="form-group">
      <label>Enter Amount</label>
      <div class="input-group mb-sm">
       <input class="form-control" type="text" placeholder="Enter Amount" name="ref_amount" id="ref_amount" required>
     </div>
   </div>
 </div>
 <div class="col-sm-3">
   <div class="form-group">
    <label>Remarks</label>
    <div class="input-group mb-sm">
     <input class="form-control" type="text" placeholder="Remarks" name="remark" id="remark" required>
   </div>
 </div>
</div>
<div class="col-sm-3">
 <div class="form-group">
  <label>Type</label>  
  <div class="input-group">
   <select  class="form-control" placeholder="Enter Username" name="type" id="type">
    <option value="0">Credit</option>
    <option value="1">Debit</option>
  </select>
  <span class="input-group-btn">                 
   <button type="submit" class="btn btn-info" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>  
 </span>        
</div>
</div>
</div>
</div>
</div>
</form>
<hr>
<form action="{{URL('/admin/bank-transactions')}}" method="get">
  <div class="col-md-12" style="margin-top: 14px;">
   <div class="row">
    <div class="col-sm-4">
     <label></label>
     <div class="form-group">
      <div class='input-group'>
       <input type='text' class="form-control datetimepicker-input" id="datetimepicker1" data-toggle="datetimepicker1" data-target="#datetimepicker1" name="datetimepicker1" value="{{(!empty($_GET['datetimepicker1'])?$_GET['datetimepicker1']:'')}}" placeholder="Start date">
       <span class="input-group-addon">
         &nbsp;TO&nbsp;
       </span>
       <input type='text' class="form-control datetimepicker-input" id="datetimepicker2" data-toggle="datetimepicker2" data-target="#datetimepicker2" name="datetimepicker2" value="{{(!empty($_GET['datetimepicker2'])?$_GET['datetimepicker2']:'')}}" placeholder="End Date">
     </div>
   </div>
 </div>
 <div class="col-sm-3">
   <div class="form-group">
    <label></label>  
    <div class="input-group">
     <select  class="form-control" placeholder="Enter Username">
      <option value="">Search Type</option>
      <option value="">Wallet Transfer</option>
      <option value="">Wire Transfer</option>
    </select>
  </div>
</div>
</div>
<div class="col-sm-5">
 <label></label>
 <div class="input-group mb-sm">
  <input type="hidden" name="column" value="username" id="column"> 
  <input class="form-control" type="text" placeholder="Search by User Name" name="param" value="{{(!empty($_GET['param'])?$_GET['param']:'')}}" id="param">
  <span class="input-group-btn">
    <button class="btn btn-primary" type="submit">Search</button>
    <a href="{{URL('/admin/bankTransactionListdownload')}}/{{(!empty($_GET['datetimepicker1'])?date("Y-m-d", strtotime($_GET['datetimepicker1'])):'null')}}/{{(!empty($_GET['datetimepicker2'])?date("Y-m-d", strtotime($_GET['datetimepicker2'])):'null')}}/{{(!empty($_GET['column'])?$_GET['column']:'null')}}/{{(!empty($_GET['param'])?$_GET['param']:'null')}}">
      <button class="btn btn-primary" type="button">Excel</button>
    </a>
  </span>
</div>
</div>
</div>
</div>
</form>
<div class="panel-body" style="padding-top: 20px;">
  <table class="table table-bordered table-striped mb-none" class="table mb-none">
   <thead>
    <tr>
     <th>#</th>
     <th>Transaction</th>
     <th>Date</th>
     <th>User Name</th>
     <th>Payment Mode</th>
     <th>Total Amount</th>
     <th>Image</th>
     <th style="text-align:center;">Action</th>
   </tr>
 </thead>
 <tbody>
  @foreach($userList as $key=>$val)                              
  <tr>
   <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
   <td>USD{{sprintf("%04s", $val->transactionsId)}} </td>
   <td>{{$val->created_at}}</td>
   <td>{{$val->username}}</td>
   <td>Bank</td>
   <td>{{$val->amount}}</td>
   <td class="text-center"><a data-toggle="modal" data-target="#m-a-a" class='zoomex'><img class="img_zoom" src="{{env('UPLOADED_USER_IMAGES')}}{{$val->recepit}}" style="max-width:60px;max-height:40px;"></a>
   </td>
   <td class="app_req" id="" style="text-align:center;">
    @if($val->status==0)
    <button class="btn btn-xs primary update_action" data-action="update_user_action_status" data-key="{{Crypt::encrypt($val->transactionsId)}}">Pending</button>
    @elseif($val->status==3)  
    <button class="btn badge success text-u-c" disabled>Approve</button>
    @endif
  </td>
</tr>
@endforeach 
</tbody>
</table>
<div class="panel-heading" style="display:flex; justify-content:center;align-items:center;">
 <!--   pagination-->
 {{$userList->appends(array_filter($_GET))->links()}}
</div>
</div>
</div>
               <!--                   <div class="panel-footer">
                  <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
                  
                  <button class="btn btn-danger btn-sm req_action" data-tbl="users" data-action="update_userstatus" value="1">Deactivate</button>
                  
                  <button class="btn btn-primary btn-sm req_action" data-tbl="users" data-action="update_userstatus" value="0">Activate</button>
                  
                </div> -->
              </section>
            </div>
          </div>
        </section>  
      </div>
    </div>
    @endsection