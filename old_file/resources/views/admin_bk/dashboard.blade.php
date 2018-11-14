@extends('admin.layout.layout')
@section('content')

  <!-- ############ Aside END-->
  <!-- ############ Content START-->
  <div id="content" class="app-content box-shadow-3" role="main">
    <div class="content-main " id="content-main">

<!-- ############ Main START-->
      <div class="padding" data-plugin="waves">
        <div class="d-flex mb-3">
          <div class="flex">
            <h1 class="text-md mb-1 _400">Welcome back.</h1>
            <small class="text-muted"></small>
          </div>
        </div>
        <div class="row">
            <div class="col-6 col-lg-3">
              <div class="box p-3 white">
                <div class="d-flex">
                  <span class="text-muted">Today's Deposit</span>
                </div>
                <div class="py-3 text-center text-lg text-primary">
                  $0.00
                </div>
                <div class="d-flex">
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="box p-3 white">
                <div class="d-flex">
                  <span class="text-muted">Total Deposit</span>
                </div>
                <div class="py-3 text-center text-lg text-warning">
                  $0.00
                </div>
                <div class="d-flex">
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="box p-3 white">
                <div class="d-flex">
                  <span class="text-muted">Today's Withdrawal</span>
                </div>
                <div class="py-3 text-center text-lg text-success">
                 $0.00
                </div>
                <div class="d-flex">
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="box p-3 white">
                <div class="d-flex">
                  <span class="text-muted">Total Withdrawal</span>
                </div>
                <div class="py-3 text-center text-lg text-danger">
                  $0.00
                </div>
              </div>
            </div>
        </div>
      </div>

<!-- ############ Main END-->
    </div>

@endsection