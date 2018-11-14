@extends('admin.layout.layout')
@section('content')
<!-- Main -->
<!--popup model start-->
<!--popup model end-->
<div class="content-main " id="content-main">
  <!-- ############ Main START-->
  <!-- start: page -->
  <div class="padding">
    <div class="row">
      <div class="col-lg-12">
        <div class="box">
          <div class="box-header">
            <h4>Approved Withdrawal </h4>
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
                   <a href="{{URL('/organize/manageWithdrawalPaidDownload')}}/{{(!empty($_GET['param'])?$_GET['param']:'null')}}/{{(!empty($_GET['column'])?$_GET['column']:'null')}}">
                      <button class="btn btn-primary" type="button">Excel</button>
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
           <th >#</th>           
           <th style="text-align:left;">Request Date</th>
           <th >User Info</th>
           <th style="text-align:left;">Payment Mode</th>
           <th style="text-align:left;">Account Number/Address</th>
           <th style="text-align:right;">Amount</th>
           <th style="text-align:right;">Approved Date</th>
         </tr>
       </thead>
        <tbody>  
         @foreach($userList as $key=>$val)                               
          <tr>
            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>            
            <td style="text-align:left;">{{date("d-m-Y h:m:i", strtotime($val->created_at))}}</td>
            <td><i class="fa fa-user"></i><a href="admin-edit-user/{{Crypt::encrypt($val->user_id)}}" style="text-decoration: underline;color:#007bff;">@if($val->first_name)&nbsp;{{$val->first_name}}@endif
              @if($val->last_name)&nbsp;{{$val->last_name}}@endif 
                  ({{$val->username}})</a>
              @if($val->email)<br><i class="fa fa-envelope"></i>&nbsp;{{$val->email}}@endif
              @if($val->mobile_no)<br><i class="fa fa-phone"></i>&nbsp;{{$val->country_code}}-{{$val->mobile_no}}@endif 
            </td>
            <td style="text-align:left;">
              @if($val->modetype == 2)
              Bitcoin                             
              @elseif($val->modetype == 1)
              Bank
              @endif
            </td>
            <td style="text-align:left;">
              @if($val->beneficiary_name && $val->beneficiary_name!='x')Name :&nbsp;{{$val->beneficiary_name}}<br>@endif
              @if($val->account_no && $val->account_no!='x')A/C :&nbsp;{{$val->account_no}}<br>@endif
              @if($val->bank_name && $val->bank_name!='x')Bank :&nbsp;{{$val->bank_name}}<br>@endif
              @if($val->swift_code && $val->swift_code!='x')Swift Code :&nbsp;{{$val->swift_code}}@endif
            </td>
            <td style="text-align:right;">@if($val->modetype == 2)
                  {{$val->amount}}                             
              @elseif($val->modetype == 1)
                  {{sprintf("%.2f", $val->amount)}}
              @endif
            </td>
            <td style="text-align:right;">{{date("d-m-Y h:i:s", strtotime($val->updated_at))}}</td>
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