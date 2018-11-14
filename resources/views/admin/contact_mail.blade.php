@extends('admin.layout.layout')
@section('content')

<style>
    .navbar.flex-nowrap.box-shadow {
  display: none;
}
</style>
<!-- Main -->
<div class="content-main " id="content-main">
<!-- ############ Main START-->
<!-- start: page -->
<div class="padding">
   <div class="row">
      <div class="col-lg-12">
         <div class="box">
            <div class="box-header">
               <h4>Contact Us</h4>
            </div>
         </div>
      </div>
   </div>
   <div class="box">
      <div class="navbar flex-nowrap box-shadow">
         <a data-toggle="modal" data-target="#content-aside" data-modal class="mr-1 d-md-none">
         <span class="btn btn-sm btn-icon primary">
         <i class="fa fa-th"></i>
         </span>
         </a>
         <form class="w-100">
            <div class="input-group">
               <input type="text" class="form-control form-control-sm search" placeholder="Input the keywords to search" required>
               <span class="input-group-btn">
               <button class="btn btn-default btn-sm no-shadow" type="button"><i class="fa fa-search"></i></button>
               </span>
            </div>
         </form>
         <button id="sort" class="btn btn-sm white ml-1 sort" data-sort="item-title" data-toggle="tooltip" title="Sort">
         <i class="fa fa-sort"></i>
         </button>
      </div>
      <div class="scroll-y">


    	@foreach($userList as $key=>$val)
	        <div class="list">
	           <div class="list-item dataMessage"  data-toggle="modal" data-target="#modal-new" style="cursor:pointer;" data-name="{{$val->name}}" data-email="{{$val->email}}" data-inquiry="{{$val->inquiry}}" data-subject="{{$val->subject}}" data-message="{{$val->message}}" data-phone="{{$val->phn_no}}">
	               <span class="w-40 avatar circle brown">
	                  <h5>{{strtoupper(substr($val->name,0,1))}}</h5>
	               </span>
	               <div class="list-body">
	                  <a href="" class="item-title _500">{{$val->name}}</a>
	                  <div class="item-except text-sm text-muted h-1x">
	                    {{$val->subject}}

	                  </div>
	                  <div class="item-tag tag hide">
	                     Draft
	                  </div>
	               </div>
	               <div>
	                  <span class="item-date text-xs text-muted">{{date("d-m-Y h:i:s", strtotime($val->created_at))}}</span>
	               </div>
	           </div>
	        </div>
	        <div class="box-divider m-0"></div>
        @endforeach  



         <div class="no-result hide">
            <div class="p-4 text-center">
               No Results
            </div>
         </div>
      </div>
      <div class="p-3 b-t mt-auto">
         <div class="d-flex align-items-center">
            <div class="flex d-flex flex-row">
               <a href="#" class="btn btn-xs white no-border pager-prev hide">
               <i class="fa fa-angle-left"></i>
               </a>
               <div class="pagination pagination-xs">
               </div>
               <a href="#" class="btn btn-xs white no-border pager-next hide">
               <i class="fa fa-angle-right"></i>
               </a>
            </div>
            <div>
               <span class="text-muted">{{$userList->appends(array_filter($_GET))->links()}}</span>
               <span id="count"></span>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!-- Main END-->
@endsection