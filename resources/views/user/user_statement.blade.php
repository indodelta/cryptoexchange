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
            <h4>User Statement</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box"> 
      <div class="p-2">
        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
        <form action="" method="">
          <div class="row">
            <div class="col-sm-4">
                <label>Mode</label>
                <select class="form-control mb-md" name="column">
                  <option value="first_name" {{(!empty($_GET['column'])&&$_GET['column']=="first_name"?'selected':'')}}>Name</option>
                  <option value="username" {{(!empty($_GET['column'])&&$_GET['column']=="username"?'selected':'')}}>Username</option>
                  <option value="email" {{(!empty($_GET['column'])&&$_GET['column']=="email"?'selected':'')}}>Email</option>
                  <option value="mobile_no" {{(!empty($_GET['column'])&&$_GET['column']=="mobile_no"?'selected':'')}}>Phone</option>  
                </select>            
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <label>Search by keywords</label>
                <div class="input-group mb-sm">
                  <input class="form-control" type="text" placeholder="Search keywords" name="param" value="{{(!empty($_GET['param'])?$_GET['param']:'')}}">
                  <span class="input-group-btn">
                   <button class="btn btn-info" type="submit">Search</button>
{{--                    <a href="{{URL('/organize/manageWithdrawalCancelDownload')}}/{{(!empty($_GET['param'])?$_GET['param']:'null')}}/{{(!empty($_GET['column'])?$_GET['column']:'null')}}">
                      <button class="btn btn-primary" type="button">Excel</button>
                    </a> --}}
                  </span>
               </div>
            </div>
          </div>
        </form>  
     </div>
     <div class="table-responsive">
      <table class="table table-striped b-t">
        <thead>
          <tr>
            <th>#</th>
            <th>Transaction Id</th>
            <th>Date</th>
            <th>User info</th>
            <th style="text-align:right;">Type</th>
            <th style="text-align:right;">Quantity</th>
            <th style="text-align:right;">Limit Price</th>
            {{-- <th style="text-align:right;">Filled</th>
            <th style="text-align:right;">Remaining</th> --}}
            <th style="text-align:right;">Avg. Price</th>
            <th style="text-align:right;">Balance</th>
            {{-- <th style="text-align:center;">Status</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach($userList as $key=>$val) 
          <tr>
           <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
           <td>ORB{{sprintf("%04s", $val->transaction_id)}}Mkl</td>
           <td>{{date("d-m-Y h:i:s", strtotime($val->updated_at))}}</td>
           <td><i class="fa fa-user"></i><a href="admin-edit-user/{{Crypt::encrypt($val->user_id)}}" style="text-decoration: underline;color:#007bff;">@if($val->first_name)&nbsp;{{$val->first_name}}@endif
                  @if($val->last_name)&nbsp;{{$val->last_name}}@endif 
                  ({{$val->username}})</a>
              @if($val->email)<br><i class="fa fa-envelope"></i>&nbsp;{{$val->email}}@endif           
              @if($val->mobile_no)<br><i class="fa fa-phone"></i>&nbsp;{{$val->country_code}}-{{$val->mobile_no}}@endif
           </td>

           <td style="text-align:right;">
           @if($val->side == 1)
              Buy
           @elseif($val->side == 2)
              Sell
           @endif      

          <td style="text-align:right;">{{sprintf("%.4f", $val->quantity)}}</td>
          <td style="text-align:right;">{{sprintf("%.2f", $val->limit_price)}}</td>
          {{-- <td style="text-align:right;">{{sprintf("%.4f", $val->filled)}}</td>
          <td style="text-align:right;">{{sprintf("%.4f", $val->remaining)}}</td> --}}
          <td style="text-align:right;">{{sprintf("%.2f", $val->avg_price)}}</td>

          <td style="text-align:right;"></td>

          {{-- <td style="text-align:center;">
            @if($val->status==0)
                <span class="badge amber pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Open</span>
            @elseif($val->status==1)
                <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Filled</span>
            @elseif($val->status==2)
              <span class="badge danger pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Cancelled</span>
            @endif
          </td> --}}

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