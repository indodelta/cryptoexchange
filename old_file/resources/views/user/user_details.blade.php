@extends('layouts.app_userDetails')
@section('content')

<style>
.form-control {
  min-height: 40px;
}
#support-header {
  display: none;
}
header {
  background: #24507a none repeat scroll 0 0;
  padding: 15px 0;
  position: relative;
  width: 100%;
  z-index: 99;
}
legend {
  background: #fff none repeat scroll 0 0 !important;
  border-bottom: 0 none !important;
  font-size: 17px;
  margin-left: 20px;
  margin-top: 19px;
  position: relative;
  text-align: center;
  width: 180px;
}
fieldset {
  border: 1px solid #ccc !important;
}
@media screen and (max-width: 767px){
.navbar-fixed-bottom, .navbar-fixed-top {
  left: 0;
  right: 0;
  z-index: 1030;
  margin-bottom:0 !important;
}
#wrapper {
  margin: 122px auto auto !important;
}
}
.inner-circle {
  background: transparent none repeat scroll 0 0;
  border: 1px solid #234f79;
  border-radius: 50%;
  height: 25px;
  width: 25px;
}
.inner-circle.active {
  background: #41c9f0 none repeat scroll 0 0;
  border: 3px double #fff;
  border-radius: 50%;
  height: 25px;
  width: 25px;
}
.inner-listing {
  display: block;
  list-style: outside none none;
  margin:30px auto 0;
  text-align: center;
}
.inner-listing > li {
  display: inline-block;
}
.main-heading {
  color: #234f79;
  margin-bottom: 0;
  text-align: center;
}
</style>

<div id="wrapper">
    <div class="main-form-back">
        <div class="container">
            <h3 class="main-heading">User Detail</h3>
            <hr style="margin: 5px auto;display:block;width:60px;height:2px; background:#234f79;">
            <div class="panel-body">
                <ul class="inner-listing">
                    <li><div class="inner-circle active" style="float:left;"></div><img src="images/blue-line.png" style="float:left;line-height:20px;margin-top:10px;margin-left:10px;margin-right:10px"></li>
                    <li><div class="inner-circle"style="float:left;"></div><img src="images/blue-line.png" style="float:left;line-height:20px;margin-top:10px;margin-left:10px;margin-right:10px"></li>
                    <li><div class="inner-circle"style="float:left;"></div></li>
                </ul>
            </div>
            <div class="col-sm-8 col-sm-offset-2 inner-white-card">
              <form method="post" data-toggle="validator" id="user_details" action="{{url('user_details')}}">
                {{ csrf_field() }}
                <input type="hidden" id='type' name="type" value="{{$value['type']}}">
                <input type="hidden" id='id' name="id" value="{{$value['id']}}"> 
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="pwd">Date of Birth:</label>
                              <div class='input-group date'>
                                <input type='text' class="form-control" name="dob" id='datetimepicker1'/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                      </div>
                    </div>
                </div>
                  <div class="row">
                      <div class="col-sm-12">   
                              <fieldset>
                                  <legend>Address</legend>
                                  <div class="col-sm-12">
                                      <div class="row">
                                          <div class="col-sm-12">
                                                  <div class="form-group">
                                                      <label for="email">Address</label>
                                                      <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                                  </div>
                                          </div>
                                      </div>
                                      
                                      <div class="row">
                                          <div class="col-sm-6">
                                                  <div class="form-group">
                                                      <label for="text">City</label>
                                                      <input type="text" class="form-control" id="city" name="city">
                                                  </div>
                                          </div>
                                          <div class="col-sm-6">
                                              <div class="form-group">
                                                  <label for="pwd">State</label>
                                                  <input type="text" class="form-control" id="state" name="state">
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <div class="row">
                                          <div class="col-sm-6">                                            
                                                  <div class="form-group">
                                                      <label for="text">Country</label>
                                                      <select id="country" class="form-control" name="country" required="">
                                                          <option value="">Select Country</option>
                                                          @foreach ($country as $val)
                                                              @if(old('country_id') == $val->id)
                                                                  <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                                              @else
                                                              <option value="{{$val->id}}">{{$val->name}}</option>
                                                              @endif
                                                          @endforeach
                                                      </select>
                                                  </div>
                                          </div>
                                          <div class="col-sm-6">
                                              <div class="form-group">
                                                  <label for="pwd">Zip Code</label>
                                                  <input type="text" class="form-control" id="zipcode" name="zipcode">
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <div class="row">
                                          <div class="col-sm-3">
                                                  <div class="form-group">
                                                      <label for="text">Country Code</label>
                                                      <input type="text" class="form-control" readonly id="countrycode" name="country_code" style="text-align:center;">
                                                  </div>
                                          </div>
                                          <div class="col-sm-9">
                                              <div class="form-group">
                                                  <label for="pwd">Mobile Number</label>
                                                  <input type="text" class="form-control" id="mobileNo" name="mobileNo" maxlength="15">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </fieldset>                      
                      </div>
                  </div>
              
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <button type="submit" class="btn btn-submit" id="UserDetailsSubmit" style="text-align:center;">Submit</button>
                          </div>
                      </div>
                  </div>
                  </form>                                
                    <div class="col-sm-12">
                        <div class="form-group last-linking">
                           <!--  <a href="kyc?page=page3" class="skip">Skip > ></a> -->
                        </div>
                    </div>
                </div>                  
            </div>
        </div>
    </div>
</div>
@stop