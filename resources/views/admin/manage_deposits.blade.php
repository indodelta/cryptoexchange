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
            <h4>All Deposits</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
<!--       <div class="box-header">
        <h3>Table with elements</h3>
      </div> -->
      <div class="p-2">
        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
        <form action="{{ URL('/organize/manage-deposits')}}" method="get">
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
             <label></label>
             <select class="form-control mb-md" name="type">
               <option value="0" {{(!empty($_GET['type'])&&$_GET['type']=="0"?'selected':'')}}>Mode</option>
               <option value="1" {{(!empty($_GET['type'])&&$_GET['type']=="1"?'selected':'')}}>Bitcoin</option>
               <option value="2" {{(!empty($_GET['type'])&&$_GET['type']=="2"?'selected':'')}}>Bank</option> 
             </select>
           </div>
            <div class="col-sm-5">
                <label></label>
                <div class="input-group mb-sm">
                  <input type="hidden" name="searchcolumn" value="username"> 
                  <input class="form-control" type="text" placeholder="Search by User Name" name="searchparam" value="{{(!empty($_GET['searchparam'])?$_GET['searchparam']:'')}}">
                  <span class="input-group-btn">
                    <button class="btn btn-info" type="submit">Search</button>
                    <a href="{{URL('/organize/manageDepositsDownload')}}/{{(!empty($_GET['datetimepicker1'])?date("Y-m-d", strtotime($_GET['datetimepicker1'])):'null')}}/{{(!empty($_GET['datetimepicker2'])?date("Y-m-d", strtotime($_GET['datetimepicker2'])):'null')}}/{{(!empty($_GET['type'])?$_GET['type']:'0')}}/{{(!empty($_GET['searchcolumn'])?$_GET['searchcolumn']:'null')}}/{{(!empty($_GET['searchparam'])?$_GET['searchparam']:'null')}}">
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
            <th>Date</th>
            <th>User info</th>
            <th>Payment Mode</th>
            <th style="text-align:right;">Total Amount</th>
            <th style="text-align:right;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($userList as $key=>$val) 
          <tr>
           <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-2)*10)+(++$key):++$key) }}</td>
           <td>{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</td>
           <td><i class="fa fa-user"></i>@if($val->first_name)&nbsp;{{$val->first_name}}@endif
                  @if($val->last_name)&nbsp;{{$val->last_name}}@endif 
                  ({{$val->username}})

              @if($val->email)<br><i class="fa fa-envelope"></i>&nbsp;{{$val->email}}@endif             
              @if($val->mobile_no)<br><i class="fa fa-phone"></i>&nbsp;{{$val->country_code}}-{{$val->mobile_no}}@endif
              @if($val->country)<br><i class="fa fa-map-marker"></i>&nbsp;{{$val->country}}@endif
           </td>
           <td>@if($val->modetype == 1)
            Bitcoin                             
            @elseif($val->modetype == 2)
            Bank
            @endif
          </td>
          <td style="text-align:right;">@if($val->modetype == 1)
                  {{$val->amount}}                             
              @elseif($val->modetype == 2)
                  {{sprintf("%.2f", $val->amount)}}
              @endif
          </td>
          <td style="text-align:right;">
            @if($val->modetype == 1)  
              <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Approved</span>
            @elseif($val->modetype == 2)
              @if($val->status == 0) 
                 <span class="badge danger pos-rlt mr-2 update_action" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Pending</span>
              @elseif($val->status == 3)
                <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Approved</span>
              @endif                 
            @endif
          </td>
        </tr>
        @endforeach  
      </tbody>
      </table>
    </div>
    <footer class="light lt p-2">
      <div class="row">
        <div class="col-sm-12">                
          {{$userList->appends(array_filter($_GET))->links()}}
        </div>
      </div>
    </footer>
  </div>
</div>
</div> 
<!-- Main END-->
@endsection