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
            <h4>Manage Users</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
<!--       <div class="box-header">
        <h3>Table with elements</h3>
      </div> -->
      <div class="p-2">
        <form action="" method="">
          <div class="row">
            <div class="col-sm-4">
                <label>Mode</label>
                <select class="form-control mb-md" name="column">
                  <option value="first_name" {{(!empty($_GET['column'])&&$_GET['column']=="first_name"?'selected':'')}}>Name</option>
                  <option value="username" {{(!empty($_GET['column'])&&$_GET['column']=="username"?'selected':'')}}>Username</option>
                  <option value="email" {{(!empty($_GET['column'])&&$_GET['column']=="email"?'selected':'')}}>Email</option>
                  <option value="mobile_no" {{(!empty($_GET['column'])&&$_GET['column']=="mobile_no"?'selected':'')}}>Phone</option>
                  <option value="kyc_pending" {{(!empty($_GET['column'])&&$_GET['column']=="kyc_pending"?'selected':'')}}>KYC Pending</option>
                  <option value="activate" {{(!empty($_GET['column'])&&$_GET['column']=="activate"?'selected':'')}}>Activated</option>  
                  <option value="deactivate" {{(!empty($_GET['column'])&&$_GET['column']=="deactivate"?'selected':'')}}>Deactivated</option>  
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
                   <a href="{{route('manageuserDownload',['column'=>(!empty($_GET['column'])?$_GET['column']:'null'),'param'=>(!empty($_GET['param'])?$_GET['param']:'null')])}}">
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
            <th><input type="checkbox" class="icheckbox1 select_all"></th>
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
            <td><input type="checkbox" class="checkbox" id="chk_{{$val->id}}"></td>
            <td><a href="admin-edit-user/{{Crypt::encrypt($val->id)}}" style="text-decoration: underline;color:#007bff;">{{ $val->username}}</a></td>
            <td>{{ $val->first_name}}&nbsp;{{ $val->last_name}}</td>
            <td>{{$val->email}}</td>
            <td>{{$val->country_code}}&nbsp;{{$val->mobile_no}}</td>
            <td>{{$val->countryname}}</td>
            <td style="white-space:nowrap">{{ Carbon\Carbon::parse($val->created_at)->format('d-M-Y') }}</td>  
            <td style="white-space:nowrap">
              <a href="user-statement-show/{{Crypt::encrypt($val->id)}}/1" style="text-decoration: underline;color:#007bff;">
                <i class='fa fa-btc' aria-hidden='true'></i>
                  {{sprintf("%.4f",round($val->total_btc,4))}}   
                <br>
                <i class='fa fa-usd' aria-hidden='true'></i> 
                  {{sprintf("%.2f",$val->total_usd)}}
              </a>
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
    </div>
    <footer class="light lt p-2">
      <div class="row">
        <div class="col-sm-4 d-block-sm">
          <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
          <button class="btn btn-danger btn-sm req_action" data-tbl="users" data-action="update_userstatus" value="1">Deactivate</button>
          <button class="btn btn-primary btn-sm req_action" data-tbl="users" data-action="update_userstatus" value="0">Activate</button>
        </div>
        <div class="col-sm-4">         
        </div>
        <div class="col-sm-4">                
          {{$userList->appends(array_filter($_GET))->links()}}
        </div>
      </div>
    </footer>
  </div>
</div>
</div> 
<!-- Main END-->
@endsection