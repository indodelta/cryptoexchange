@extends('admin.layout.layout')
@section('content')
<!-- Main -->
<style type="text/css">
.bootstrap-select.btn-group .dropdown-menu.inner {
 display: block  !important;
} 
.dropdown-toggle.btn-default {
  color: #292b2c;
  background-color: #fff;
  border-color: #ccc;
}

.bootstrap-select.show>.dropdown-menu>.dropdown-menu {
  display: block;
}

.bootstrap-select > .dropdown-menu > .dropdown-menu li.hidden{
  display:none;
}

.bootstrap-select > .dropdown-menu > .dropdown-menu li a{
  display: block;
  width: 100%;
  padding: 3px 1.5rem;
  clear: both;
  font-weight: 400;
  color: #292b2c;
  text-align: inherit;
  white-space: nowrap;
  background: 0 0;
  border: 0;
}

.dropdown-menu > li.active > a {
  color: #fff !important;
  background-color: #337ab7 !important;
}

.bootstrap-select .check-mark::after {
  content: "✓";
}

.bootstrap-select button {
  overflow: hidden;
  text-overflow: ellipsis;
}


/* Make filled out selects be the same size as empty selects */
.bootstrap-select.btn-group .dropdown-toggle .filter-option {
  display: inline !important;
}

.bootstrap-select.btn-group .dropdown-menu {
 box-sizing: border-box;
 max-height: 200px !important;
 min-width: 100%;
}
</style>
<div class="content-main " id="content-main">
  <!-- ############ Main START-->
  @if(Session::has('message'))
    @if(Session::get('message') == 'debit')
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          successAlert('Amount debit successfully');
      }, false);
      </script>
     @elseif(Session::get('message') =='credit')
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          successAlert('Amount credit successfully.');
      }, false);
      </script>
     @endif
  @endif
  @if(Session::has('error')) 
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        errorAlert('{{Session::get('error')}}');
    }, false);
    </script>
  @endif  
  @if(Session::has('error2')) 
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        errorAlert2('{{Session::get('error2')}}');
    }, false);
    </script>
  @endif 
  <!-- start: page -->
  <div class="padding">
    <div class="row">
      <div class="col-lg-12">
        <div class="box">
          <div class="box-header">
            <h4>Manage USD wallet</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="p-2">
        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
            <form action="{{URL('/organize/user_wallet')}}" method="post">
              <div class="row">
                <div class="col-sm-2">   
                  {{ csrf_field() }}    
                  <div class="form-group">
                    <label>User Name</label>  
                    <div class="input-group"> 
                     <select  class="form-control selectpicker" data-live-search="true"  placeholder="Enter Username" id="userName" name="userName" onchange="refamt();" required>
                     <option value="">Select User</option>
                     </select>                                           
                   </div>
                 </div>           
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Referred Amount</label>  
                  <div class="input-group"> 
                    <select  class="form-control" placeholder="Ref. Amount" id="ref_amount_id" name="ref_amount_id">
                    </select>                                           
                  </div>
                </div>
              </div>  
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Enter Amount</label>  
                  <div class="input-group"> 
                    <input class="form-control" type="text" placeholder="Enter Amount" name="add_amount" id="add_amount" required>     
                  </div>
                </div>
              </div>   
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Remarks</label>  
                  <div class="input-group"> 
                    <input class="form-control" type="text" placeholder="Remarks" name="remark" id="remark" required>                                           
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Action</label>  
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
        </form>
        <div class="box-divider m-0"></div>
        <form action="" method="get">
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
               <option value="1" {{(!empty($_GET['type'])&&$_GET['type']=="1"?'selected':'')}}>Credit</option>
               <option value="2" {{(!empty($_GET['type'])&&$_GET['type']=="2"?'selected':'')}}>Debit</option> 
             </select>
           </div>
            <div class="col-sm-5">
                <label></label>
                <div class="input-group mb-sm">
                  <input type="hidden" name="searchcolumn" value="username"> 
                  <input class="form-control" type="text" placeholder="Search by User Name" name="searchparam" value="{{(!empty($_GET['searchparam'])?$_GET['searchparam']:'')}}">
                  <span class="input-group-btn">
                    <button class="btn btn-info" type="submit">Search</button>
{{--                     <a href="{{URL('/organize/manageDepositsDownload')}}/{{(!empty($_GET['datetimepicker1'])?date("Y-m-d", strtotime($_GET['datetimepicker1'])):'null')}}/{{(!empty($_GET['datetimepicker2'])?date("Y-m-d", strtotime($_GET['datetimepicker2'])):'null')}}/{{(!empty($_GET['type'])?$_GET['type']:'0')}}/{{(!empty($_GET['searchcolumn'])?$_GET['searchcolumn']:'null')}}/{{(!empty($_GET['searchparam'])?$_GET['searchparam']:'null')}}">
                      <button class="btn btn-primary" type="button">Excel</button> --}}
                    </a>
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
           <th>Date</th>
           <th>User Info</th>
           <th style="text-align:right;">Referred Amount</th>
           <th style="text-align:right;">Amount</th>
           <th style="max-width:200px;">Remarks</th>
           <th style="text-align:center;">Action</th>
         </tr>
       </thead>
        <tbody>
        @foreach($userList as $key=>$val) 
          <tr>
           <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
           <td>{{date("d-m-Y h:m:i", strtotime($val->created_at))}}</td>
           <td><i class="fa fa-user"></i>@if($val->first_name)&nbsp;{{$val->first_name}}@endif
                  @if($val->last_name)&nbsp;{{$val->last_name}}@endif 
                  ({{$val->username}})
              @if($val->email)<br><i class="fa fa-envelope"></i>&nbsp;{{$val->email}}@endif             
              @if($val->mobile_no)<br><i class="fa fa-phone"></i>&nbsp;{{$val->country_code}}-{{$val->mobile_no}}@endif
              @if($val->country)<br><i class="fa fa-map-marker"></i>&nbsp;{{$val->country}}@endif</td>
           <td style="text-align:right;">@if($val->ref_amount == null)
              NA                             
            @elseif($val->ref_amount != null)
              {{sprintf("%.2f", $val->ref_amount)}}
            @endif
            </td>
           <td style="text-align:right;">{{sprintf("%.2f", $val->amount)}}</td>
           <td style="max-width:200px">{{$val->remark}}</td>
           <td>@if($val->type == 0)
              Credit                             
            @elseif($val->type == 1)
              Debit
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