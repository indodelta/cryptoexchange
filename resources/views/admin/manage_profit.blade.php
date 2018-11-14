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
            <h4>Profit <span style="color:#22b66e"> (Total&nbsp;:&nbsp;{{round($userList[0]->totalProfit,2)}} USD)</span></h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="p-2">
        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
        <form action="" method="">
          <div class="row">
            <div class="col-sm-3">
                <label>Type</label>
                <select class="form-control mb-md" name="column">
                  <option value="" {{(!empty($_GET['column'])&&$_GET['column']==""?'selected':'')}}>Select</option>
                  <option value="1" {{(!empty($_GET['column'])&&$_GET['column']=="1"?'selected':'')}}>Buy</option>
                  <option value="2" {{(!empty($_GET['column'])&&$_GET['column']=="2"?'selected':'')}}>Sell</option>
                </select>            
            </div>
            <div class="col-sm-5">
            </div>
            <div class="col-sm-4">
                <label>Search by Order Id</label>
                <div class="input-group mb-sm">
                  <input class="form-control" type="text" placeholder="Order Id" name="param" value="{{(!empty($_GET['param'])?$_GET['param']:'')}}">
                  <span class="input-group-btn">
                   <button class="btn btn-info" type="submit">Search</button>
                   <a href="{{URL('/organize/manageProfitDownload')}}/{{(!empty($_GET['param'])?$_GET['param']:'null')}}/{{(!empty($_GET['column'])?$_GET['column']:'null')}}">
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
           <th>Order Id</th>
           <th>Date</th>
           <th >Type</th>
           <th style="text-align:right;">Price</th>
           <th style="text-align:right;">Quantity</th>
           <th style="text-align:right;">USD Conversion</th>
           <th style="text-align:right;">Fees(Commission)</th>           
           <th style="text-align:right;">Profit<small>(USD)</small></th>
           <th style="text-align:center;">Status</th>
         </tr>
       </thead>
        <tbody>  
{{-- s --}}    
      </tbody>
        @foreach($userList as $key=>$val) 
          <tr>
           <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
            <td>
              @if($val->side ==1)
                ORB{{sprintf("%04s", $val->id)}}Mkl
              @elseif($val->side ==2)
                OSR{{sprintf("%04s", $val->id)}}SWl
              @endif
            </td>
            <td>{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</td>
            <td>
              @if($val->side ==1)
                Buy
              @elseif($val->side ==2)
                Sell
              @endif
            </td>
            <td style="text-align:right;">{{sprintf("%.2f",($val->limit_price))}}</td>
            <td style="text-align:right;">{{sprintf("%.4f",($val->quantity))}}</td>
            <td style="text-align:right;">{{sprintf("%.2f",($val->usd_conversion))}}</td>
            <td style="text-align:right;">
              @if($val->usd_conversion > 1000)
               {{sprintf("%.4f",($val->pc_calculated_amount - $val->itbit_calculated_amount))}} ({{$val->perfektpay_comm}})
              @else
                NA
              @endif
            </td>
            <td style="text-align:right;">
              @if($val->status ==2)
                0.00
              @else
                @if($val->side ==1)
                  {{sprintf("%.4f", ($val->total_paid - $val->pc_calculated_amount) - ($val->limit_price * $val->quantity))}}
                @elseif($val->side ==2)
                  {{sprintf("%.4f", ($val->quantity * $val->limit_price) - ($val->total_paid))}}
                @endif
              @endif
            </td>
            <td style="text-align:center;">
              @if($val->status==0)
                  <span class="badge amber pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Open</span>
              @elseif($val->status==1)
                  <span class="badge success pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Filled</span>
              @elseif($val->status==2)
                <span class="badge danger pos-rlt mr-2" style="font-size: 85%;padding: 0.30em .7em;"><b class="top b-success pull-in" ></b>Cancelled</span>
              @endif
            </td>
        </tr>
        @endforeach  
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