@extends('admin.layout.layout')
@section('content')
<!-- Main -->
<!--popup model start-->
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }

.field1 button {
    margin: -4px;
    cursor: pointer;
}
.field1 input {
    text-align: center;
    width: 40px;
    margin: -1px;
    color: 000;
}
button#sub {
    background:#00bcd4;
    border: 2px solid #00bcd4;
    color: #fff;
}
button#add{
    background: #22b66e;
    border: 2px solid #22b66e;
    color: #fff;
}
  }
</style>
  @if(Session::has('success')) 
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        successAlert('{{Session::get('success')}}');
    }, false);
    </script>
  @endif
<!--popup model end-->
<div class="content-main " id="content-main">
  <!-- ############ Main START-->
  <!-- start: page -->
  <div class="padding">
    <div class="row">
      <div class="col-lg-12">
        <div class="box">
          <div class="box-header">
            <h4>Settings</h4>
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
                   <a href="{{URL('/organize/manageSettingDownload')}}/{{(!empty($_GET['param'])?$_GET['param']:'null')}}/{{(!empty($_GET['column'])?$_GET['column']:'null')}}">
                      <button class="btn btn-primary" type="button">Excel</button>
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
           <th >#</th>
           <th >User Info</th>
           <th >2FA Status</th>
           <th style="text-align:center;" colspan="2">Trading </th>
           <th style="text-align:center;" colspan="2">Ticker Price</th>
           <th class="text-center">Action</th>
         </tr>
         <tr>
          <th></th>
          <th></th>
          <th></th>
          <th class="text-center">Buy</th>
          <th class="text-center">Sell</th>
          <th class="text-center">Bid</th>
          <th class="text-center">Ask</th>
          <th></th>
        </tr>
       </thead>
        <tbody>  
         @foreach($userList as $key=>$val)                               
          <tr>
            <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>            
            <td><i class="fa fa-user"></i><a href="admin-edit-user/{{Crypt::encrypt($val->id)}}" style="text-decoration: underline;color:#007bff;">@if($val->first_name)&nbsp;{{$val->first_name}}@endif
                  @if($val->last_name)&nbsp;{{$val->last_name}}@endif 
                  ({{$val->username}})</a>
              @if($val->email)<br><i class="fa fa-envelope"></i>&nbsp;{{$val->email}}@endif 
            </td>
            <td>
              @if(($val->G_AUTH == 0 && $val->is_gAuth == 0 && $val->AUTH_skip ==1)|| ($val->G_AUTH ==0 && $val->is_gAuth==0 && $val->AUTH_skip==0))
                <input type="checkbox" data-toggle="toggle" data-style="ios" data-size="mini" disabled style="cursor: not-allowed;" value="{{Crypt::encrypt($val->id)}}" id="{{ $key}}dk">
              @else
                <input type="checkbox" checked data-toggle="toggle" data-style="ios" data-onstyle="success" data-size="mini" class="update_auth" value="{{Crypt::encrypt($val->id)}}" id="{{$key}}dk">
              @endif
            </td>

            <td class="text-center">
              <div class="field1">
                  <button type="button" id="sub" class="suba">-</button>
                  <input type="text" class="field trading_buy" value="{{$val->trading_buy}}" id="{{$key}}tb" min="-10" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/>
                  <button type="button" id="add" class="add">+</button>
              </div>
            </td>

            <td class="text-center">
              <div class="field1">
                  <button type="button" id="sub" class="suba">-</button>
                  <input type="text" class="field trading_sell" value="{{$val->trading_sell}}" id="{{$key}}ts" min="-10" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/>
                  <button type="button" id="add" class="add">+</button>
              </div></td>
            <td class="text-center">
              <div class="field1">
                  <button type="button" id="sub" class="sub">-</button>
                  <input type="text" class="field ticker_paid" value="{{$val->ticker_paid}}" id="{{$key}}tp"  min="-10" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/>
                  <button type="button" id="add" class="add">+</button>
              </div>
            </td>
            <td class="text-center">
                <div class="field1">
                  <button type="button" id="sub" class="sub">-</button>
                  <input type="text" class="field ticker_ask" value="{{$val->ticker_ask}}" id="{{$key}}ta" min="-10" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/>
                  <button type="button" id="add" class="add">+</button>
              </div>
            </td>
            <td class="text-center"><button class="btn primary btn-xs value_model" value="{{$key}}">Update</button></td>
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