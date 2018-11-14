@extends('admin.layout.layout')
@section('content')
<!-- Main -->
<div class="content-main " id="content-main">
   <!-- ############ Main START-->
   <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
   <div class="padding" data-plugin="waves">
      <div class="d-flex mb-3">
         <div class="flex">
            <h1 class="text-md mb-1 _400">Welcome back.</h1>
            <!-- <small class="text-muted">Last logged in: 03:00 21, July</small> -->
         </div>
         <div>
         </div>
      </div>
      <!--USD-->
      <div class="row">
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded primary">
               <span class="fa fa-dollar"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"> <span class="text-sm">Today's Deposit<small> (USD)</small></span></a></h4>
                  <small class="text-muted tdu">0.00</small>
               </div>
            </div>
         </div>
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded info success">
               <span class="fa fa-dollar"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"> <span class="text-sm">Total Deposit<small> (USD)</small></span></a></h4>
                  <small class="text-muted ttd">0.00</small>
               </div>
            </div>
         </div>
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded cyan">
               <span class="fa fa-dollar"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"><span class="text-sm">Today's Withdrawal<small> (USD)</small></span></a></h4>
                  <small class="text-muted twu">0.00</small>
               </div>
            </div>
         </div>
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded success">
               <span class="fa fa-dollar"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"> <span class="text-sm">Total Withdrawal<small> (USD)</small></span></a></h4>
                  <small class="text-muted ttw">0.00</small>
               </div>
            </div>
         </div>
      </div>
      <!--bitcoin-->
      <div class="row">
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded primary">
               <span class="fa fa-bitcoin"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"> <span class="text-sm">Today's Deposit<small> (Bitcoin)</small></span></a></h4>
                  <small class="text-muted tdub">0.00</small>
               </div>
            </div>
         </div>
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded info success">
               <span class="fa fa-bitcoin"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"> <span class="text-sm">Total Deposit<small> (Bitcoin)</small></span></a></h4>
                  <small class="text-muted ttdb">0.00</small>
               </div>
            </div>
         </div>
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded cyan">
               <span class="fa fa-bitcoin"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"><span class="text-sm">Today's Withdrawal<small> (Bitcoin)</small></span></a></h4>
                  <small class="text-muted twub">0.00</small>
               </div>
            </div>
         </div>
         <div class="col-6 col-lg-3">
            <div class="box list-item">
               <span class="avatar w-40 text-center rounded success">
               <span class="fa fa-bitcoin"></span>
               </span>
               <div class="list-body">
                  <h4 class="m-0 text-md"><a href="#"> <span class="text-sm">Total Withdrawal<small> (Bitcoin)</small></span></a></h4>
                  <small class="text-muted  twbc">0.00</small>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="box">
               <div class="box-header">
                  <h3>Today Chart</h3>
               </div>
               <div class="box-body pb-4">
                  <div class="row">
                     <div class="col-lg-7">
                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                           <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                              <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                           </div>
                           <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                              <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                           </div>
                        </div>
                        <canvas id="chart-doughnuttb" data-plugin="chart" width="274" height="137" class="chartjs-render-monitor" style="display: block;">
                        </canvas>
                     </div>
                  </div>
               </div>
               <div class="box-footer">
                  <small class="text-muted"></small>
               </div>
            </div>
         </div>
         <!--zzz-->  
         <div class="col-sm-6">
            <div class="box">
               <div class="box-header">
                  <h3>Total Chart</h3>
               </div>
               <div class="box-body pb-4">
                  <div class="row">
                     <div class="col-lg-7">
                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                           <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                              <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                           </div>
                           <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                              <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                           </div>
                        </div>
                        <canvas id="chart-doughnuttc" data-plugin="chart" width="274" height="137" class="chartjs-render-monitor" style="display: block;">
                        </canvas>
                     </div>
                  </div>
               </div>
               <div class="box-footer">
                  <small class="text-muted"></small>
               </div>
            </div>
         </div>
         <!--dd-->    
      </div>
{{--       <div class="row">
         <div class="col-sm-6">
            <div class="box">
               <div class="box-header">
                  <h3>Withdrawal</h3>
               </div>
               <div class="box-body">
                  <div class="padding light lt">
                     <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                           <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                           <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div>
                     </div>
                     <canvas id="chart-line-lineone" data-plugin="chart" height="261" width="654" class="chartjs-render-monitor" style="display: block; width: 654px; height: 261px;"></canvas>
                  </div>
               </div>
            </div>
         </div>
         <!--dd-->    
      </div> --}}
   </div>
   <!-- ############ Main END-->
</div>
<!-- Main END-->
<!-- Main END-->
@endsection