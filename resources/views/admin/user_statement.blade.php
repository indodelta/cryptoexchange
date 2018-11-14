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
            <h4>User Statement </h4>
          </div>
        </div>
      </div>
    </div>
    <div class="box"> 
      <div class="p-2">
        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">

     </div>
     <div class="table-responsive">
      <table class="table table-bordered b-t">
        <thead>
          <tr>
            <th>#</th>
            <th>Transaction Id</th>
            <th>Date &nbsp;
            @if(isset($userList[((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10):0)]))
            <a href="{{route('user-statement-show',['user_id'=>Crypt::encrypt($userList[((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10):0)]->user_id),'sh_type'=>$userList[((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10):0)]->sh_type])}}"><i class="fa fa-retweet" aria-hidden="true"></i></a>
            @endif
            </th>
            <th style="text-align:center;">Type</th>
            <th style="text-align:right;">Amount</th>
            <th style="text-align:right;">Quantity</th>
            <th style="text-align:right;">Limit Price</th>
            <th style="text-align:right;">Avg. Price</th>
            <th style="text-align:right;">BTC Balance</th>            
            <th style="text-align:right;">USD Balance</th>            
          </tr>
        </thead>
        <tbody>
          @foreach($userList as $key=>$val)       
          <tr>
           <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-1)*10)+(++$key):++$key) }}</td>
           <td>
            @if($val->ref_id != 0 && $val->type ==2 && $val->status ==1)
             ORB{{sprintf("%04s", $val->ref_id)}}MKI
            @elseif($val->ref_id != 0 && $val->type ==3 && $val->status ==1)
             OSR{{sprintf("%04s", $val->ref_id)}}SWl
            @elseif($val->ref_id == 0 && $val->type ==0 && $val->status ==1 && $val->currency =='btc')
             BTC{{sprintf("%04s", $val->id)}} 
            @elseif($val->ref_id == 0 && $val->type ==0 && $val->status ==1 && $val->currency =='usd')
             USD{{sprintf("%04s", $val->id)}} 
            @elseif($val->ref_id == 0 && $val->type ==4 && $val->status ==5 && $val->currency =='btc')
             BTC{{sprintf("%04s", $val->id)}}
            @elseif($val->ref_id == 0 && $val->type ==4 && $val->status ==5 && $val->currency =='usd')
             USD{{sprintf("%04s", $val->id)}}
            @elseif($val->ref_id == 0 && $val->type ==1 && $val->status ==1 && $val->currency =='usd')
             USD{{sprintf("%04s", $val->id)}}   
            @elseif($val->ref_id == 0 && $val->type ==0 && $val->status ==1 && $val->currency =='usd')
             USD{{sprintf("%04s", $val->id)}}               
            @endif
           </td>           
           <td>{{date("d-m-Y h:i:s", strtotime($val->updated_at))}}</td>           
           <td style="text-align:center;">
             @if($val->ref_id != 0 && $val->type ==2 && $val->status ==1)
                Buy
             @elseif($val->ref_id != 0 && $val->type ==3 && $val->status ==1)
                Sell
             @elseif($val->ref_id == 0 && $val->type ==0 && $val->status ==1 && ($val->ref_amount_id != 0||$val->currency =='btc'))
                Deposit
             @elseif($val->ref_id == 0 && $val->type ==4 && $val->status ==5 && $val->withdrawal_status ==2)
                Withdrawal     
             @elseif($val->ref_id == 0 && $val->type ==1 && $val->status ==1 && $val->withdrawal_status ==0)
                Debit 
             @elseif($val->ref_id == 0 && $val->type ==0 && $val->status ==1 && $val->withdrawal_status ==0)
                Credit     
             @endif  
          </td>   
          <td style="text-align:right;">
{{--             @if($val->currency == 'bnk')
              <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;{{sprintf("%.2f", $val->amount)}}
            @elseif($val->currency == 'btc')
              <i class="fa fa-btc" aria-hidden="true"></i>&nbsp;{{sprintf("%.4f", $val->amount)}}
            @endif  --}}
            <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;{{sprintf("%.2f", $val->pusd)}}
          </td>
          <td style="text-align:right;">
            <i class="fa fa-btc" aria-hidden="true"></i>&nbsp;{{sprintf("%.4f", $val->quantity)}}            
          </td>
          <td style="text-align:right;">
            @if($val->limit_price != 'NA')
              <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;{{sprintf("%.2f", $val->limit_price)}}
            @else
              NA
            @endif
          </td>
          {{-- <td style="text-align:right;">{{sprintf("%.4f", $val->filled)}}</td>
          <td style="text-align:right;">{{sprintf("%.4f", $val->remaining)}}</td> --}}
          <td style="text-align:right;">
            @if($val->avg_price != 'NA')
              <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;{{sprintf("%.2f", $val->avg_price)}}
            @else
              NA
            @endif 
          </td>
          <td style="text-align:right;">
            <i class="fa fa-btc" aria-hidden="true"></i>&nbsp;{{sprintf("%.4f", $val->btc_blance)}}
          </td>
          <td style="text-align:right;">
            <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;{{sprintf("%.2f", $val->usd_blance)}}
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