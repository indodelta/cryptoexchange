@extends('admin.layout.layout')
@section('content')
  <!-- ############ Content START-->

  <div id="content" class="app-content box-shadow-3" role="main">
    <div class="content-main " id="content-main">
        <div class="padding">
          @if(Session::has('message'))
                  <div id="modalFullColorSuccess" class="modal fade modal-block-success modal-full-color">
                  <div class="modal-dialog">
                      <section class="panel">
                        <header class="panel-heading" style="border-bottom:
                        0px;">
                          <h2 class="panel-title">Success!</h2>
                        </header>
                        <div class="panel-body" style="background:#5CB85C; color:#fff">
                          <div class="modal-wrapper">
                            <div class="modal-icon" style="color:#fff">
                              <i class="fa fa-check"></i>
                            </div>
                            <div class="modal-text">
                              <h4>Success!</h4>
                              <p>{{ Session::get('message') }}.</p>
                            </div>
                          </div>
                        </div>
                        <footer class="panel-footer" style=" border-top: 0 none;">
                          <div class="row">
                            <div class="col-md-12 text-right">
                              <button class="btn btn-default modal-dismiss" data-dismiss="modal" aria-hidden="true">Ok</button>
                            </div>
                          </div>
                        </footer>
                      </section>
                      </div>
                    </div> 
                    @endif
                    
                    @if(Session::has('error'))                    
                      <div id="modalFullColorSuccess" class="modal fade  modal-full-color modal-block-danger">
                                        <div class="modal-dialog">
                                            <section class="panel">
                                                <header class="panel-heading" style="border-bottom:
                                                0px;">
                                                    <h2 class="panel-title" style="color:#fff">Error!</h2>
                                                </header>
                                                <div class="panel-body" style="color:#fff; background:#D9534F ;">
                                                    <div class="modal-wrapper">
                                                        <div class="modal-icon">
                                                            <i class="fa fa-times-circle" style="color:#fff"></i>
                                                        </div>
                                                        <div class="modal-text" >
                                                            <h4>Sorry</h4>
                                                            <p>{{ Session::get('error') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <footer class="panel-footer" style=" border-top: 0 none;">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                                <button class="btn btn-default modal-dismiss" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </section>
                                            </div>
                                      </div>
                    @endif
          <!-- start: page -->
          <section class="panel panel-featured"> 
            <div class="row">
              <div class="col-lg-12">
                <section class="panel panel-featured">
                  <header class="panel-heading" style="padding-left: 12px; padding-top: 12px;background: #e0ebeb;    padding-bottom: 3px;">
                    <div class="panel-actions">
                    </div>            
                    <h5 class="panel-title">Manage Users</h5>
                  </header>
                  <form action="{{ URL('/admin/manage_user')}}" method="get">
                    <div class="col-md-12" style="margin-top: 14px;">
                    <div class="row">                    
                    <div class="col-sm-2">
                    <label>Mode</label>
                    <select class="form-control mb-md" name="column">
                      <option value="first_name" {{(!empty($_GET['column'])&&$_GET['column']=="first_name"?'selected':'')}}>Name</option>
                      <option value="username" {{(!empty($_GET['column'])&&$_GET['column']=="username"?'selected':'')}}>Username</option>
                      <option value="email" {{(!empty($_GET['column'])&&$_GET['column']=="email"?'selected':'')}}>Email</option>
                      <option value="mobile_no" {{(!empty($_GET['column'])&&$_GET['column']=="mobile_no"?'selected':'')}}>Phone</option>  
                    </select>
                    </div>
                    <div class="col-sm-5"> </div>
                      <div class="col-sm-5">
                        <label>Search by keywords</label>
                          <div class="input-group mb-sm">
                            <input class="form-control" type="text" placeholder="Search keywords" name="param" value="{{(!empty($_GET['param'])?$_GET['param']:'')}}">
                            <span class="input-group-btn">
                             <button class="btn btn-primary" type="submit">Search</button>
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
                            <th><input type="checkbox" class="icheckbox1 select_all"></th>
                            <th>User Name</th>
                            <th>Name</th>
                            <th>email</th>
                            <th>mobile</th>
                            <th>country</th>
                            <th>Reg. Date</th>
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
                              <td>{{ Carbon\Carbon::parse($val->created_at)->format('d-M-Y') }}</td>  
                              <td style="text-align:center;"> 

                                  @if($val->KYCF_skip == 1 )                                   
                                    <span class="badge alert-info text-u-c">NO Document</span>
                                  @elseif($val->user_kyc_status == 0 && $val->KYCF_skip == 0)
                                    <span class="badge warning text-u-c">Pending</span> 
                                  @elseif($val->user_kyc_status == 1)  
                                    <span class="badge success text-u-c">Approve</span> 
                                  @elseif($val->user_kyc_status == 2) 
                                    <span class="badge danger text-u-c">Reject</span>
                                  @endif

                              </td>
                              <td class="app_req" id="{{$val->id}}"> 
                              @if($val->status == 0)
                                <span class="badge danger text-u-c">Deactivate</span>
                              @elseif($val->status == 1)
                                <span class="badge success text-u-c">Activate</span>
                              @endif
                              </td>
                            </tr>                          
                          @endforeach  
                        </tbody>
                      </table>                      
                      <div class="panel-heading" style="display:flex; justify-content:center;align-items:center;">
                            {{$userList->appends(array_filter($_GET))->links()}}
                        </div>
                    </div>
                  </div>
                  <div class="panel-footer">
                        <input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
                        <button class="btn btn-danger btn-sm req_action" data-tbl="users" data-action="update_userstatus" value="1">Deactivate</button>
                        <button class="btn btn-primary btn-sm req_action" data-tbl="users" data-action="update_userstatus" value="0">Activate</button>
                  </div>
                </section>
              </div>
            </div>
          </section>  
        </div>
    </div>
<!-- ############ Main END-->    

@endsection