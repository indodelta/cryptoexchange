@extends($header)  

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
      <h3 class="main-heading">Verify KYC</h3>
      <hr style="margin: 5px auto;display:block;width:60px;height:2px; background:#234f79;">
      <?php if($header !="user.layouts.layout"){ ?>
      <div class="panel-body">
        <ul class="inner-listing">
          <li><div class="inner-circle" style="float:left;"></div><img src="images/blue-line.png" style="float:left;line-height:20px;margin-top:10px;margin-left:10px;margin-right:10px"></li>
          <li><div class="inner-circle active"style="float:left;"></div><img src="images/blue-line.png" style="float:left;line-height:20px;margin-top:10px;margin-left:10px;margin-right:10px"></li>
          <li><div class="inner-circle"style="float:left;"></div></li>
        </ul>
      </div>
      <?php } ?>
      
      
      <div class="col-sm-8 col-sm-offset-2 inner-white-card1">
        <div class="row top-search-bar">
          <div class="col-sm-9">
            <div class="search-container">
                <label for="pwd">Country</label>
                <div class="search-form-box">
                  <input type="text" placeholder="" name="search" class="form-control" value="{{$value['country']}}" disabled="disabled">
                  <!-- button type="submit" class="side-button"><i class="fa fa-search"></i></button> -->
                </div>
            </div>
          </div>
        </div>
       <form  id="uploadfile" action="" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
        <div class="row">
          <!-- <div class="col-sm-11 col-sm-offset-1">
            <h4 style="color:#000;margin-bottom:20px;font-weight:normal">Select Id</h4>
          </div> -->
          <input type="hidden"  name="id" id="id" value="{{$value['id']}}">
          <div class="col-sm-6">
            <div class="displaying-image-style">
            <h4>National Id</h4>
              <img src="{{url('images/id-card.png')}}" alt="" id="output" />
            </div>
            <div class="file-upload">
              <label for="upload" class="file-upload__label">Upload Document <img src="images/upload.png" style="float:right;"></label>
              <input id="upload" class="file-upload__input" type="file" name="image_file" accept="image/*" onchange="loadFile(event)" required="">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="displaying-image-style1">
            <h4>Address Proof</h4>
              <img id="output2" src="{{url('images/id-card.png')}}" alt="" />
            </div>
            <div class="file-upload1">
              <label for="upload1" class="file-upload__label1">Upload Document <img src="images/upload.png" style="float:right;"></label>
              <input id="upload1" class="file-upload__input1" type="file" name="image_file1" accept="image/*" onchange="loadFile2(event)" required="">
            </div>
          </div>
        </div>
      
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <button type="submit" class="btn btn-submit" id="upload_img" value="" style="text-align:center;">Submit</button>
            </div>
          </div>
        </div>
        </form> 
        <?php if($header !="user.layouts.layout"){ ?>               
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group last-linking"><!-- 
              <a href="kyc" class="back">< < Back</a> -->
              <a href="kyc_skip" class="skip">Skip > ></a>
            </div>
          </div>
        </div>  
        <?php } ?>        
      </div>
      </form>
    </div>
  </div>
</div>

 <script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>  

<script>
  var loadFile2 = function(event) {
    var output2 = document.getElementById('output2');
    output2.src = URL.createObjectURL(event.target.files[0]);
  };
</script>  
@stop