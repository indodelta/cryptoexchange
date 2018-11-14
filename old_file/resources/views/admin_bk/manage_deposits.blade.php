@extends('admin.layout.layout')

@section('content')





  <div id="content" class="app-content box-shadow-3" role="main">

    <div class="content-main " id="content-main">

        <div class="padding">



          <!-- start: page -->

          <section class="panel panel-featured"> 

            <div class="row">

              <div class="col-lg-12">

                <section class="panel panel-featured">

                  <header class="panel-heading" style="padding-left: 12px; padding-top: 12px;background: #e0ebeb;    padding-bottom: 3px;">

                    <div class="panel-actions">

                    </div>            

                    <h5 class="panel-title">Manage Deposits</h5>

                  </header>

                  <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">

                  <form action="{{ URL('/admin/manage-deposits')}}" method="get">

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

                          <button class="btn btn-primary" type="submit">Search</button>

                          <a href="{{URL('/admin/manageDepositsDownload')}}/{{(!empty($_GET['datetimepicker1'])?date("Y-m-d", strtotime($_GET['datetimepicker1'])):'null')}}/{{(!empty($_GET['datetimepicker2'])?date("Y-m-d", strtotime($_GET['datetimepicker2'])):'null')}}/{{(!empty($_GET['type'])?$_GET['type']:'0')}}/{{(!empty($_GET['searchcolumn'])?$_GET['searchcolumn']:'null')}}/{{(!empty($_GET['searchparam'])?$_GET['searchparam']:'null')}}">

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

                            <th>Date</th>

                            <th>User Name</th>

                            <th>Payment Mode</th>

                            <th>Total Amount</th>    

                          </tr>

                        </thead>

                        <tbody>                    

                          @foreach($userList as $key=>$val) 

                            <tr>                            

                              <td>{{ ((!empty($_GET['page'])&&$_GET['page']!=1)?(($_GET['page']-2)*10)+(++$key):++$key) }}</td>

                              <td>{{$val->created_at}}</td>

                              <td>{{$val->username}}</td>

                              <td>@if($val->modetype == 1)

                                   Bitcoin                             

                                  @elseif($val->modetype == 2)

                                     Bank
                                    
                                  @endif

                              </td>  

                              <td>{{$val->amount}}</td>

                            </tr>                          

                          @endforeach 

                        </tbody>

                      </table>                      

                      <div class="panel-heading" style="display:flex; justify-content:center;align-items:center;">

                          <!--   paginate-->

                          {!! $userList->links() !!}

                          <!--end paginate--> 

                        </div>

                    </div>

                  </div>

                </section>

              </div>

            </div>

          </section>  

        </div>

    </div>

@stop