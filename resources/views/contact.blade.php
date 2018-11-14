@extends('layouts.app')
@section('content')
@section('title', 'Bitcoin Trading Services | Contact Us | Perfekt Capital Limited')
@section('content12')
  <meta name="description" content="Perfekt Capital Limited provides best Bitcoin Trading Services. Buy bitcoin in a few minutes of safe transaction at world-class exchange rates using Perfekt Pay network. It also offers paper wallet to keep our bitcoin safe.  For more information contact us @ +852 6024 5489!!">
  <meta name=keywords content="Bitcoin Trading Services">
@stop
<style>
    .hug-contactus-banner {
  background: rgba(0, 0, 0, 0) url("images/contactus-banner.jpg") no-repeat scroll center center / cover ;
}
.hug-aa-darkheader .container {
  padding: 90px 0;
}
.hug-aa-darkheader {
  background-color: #333;
  border-bottom: 3px solid #41C9F0;
}
.contact-inner-form {
  border: 2px solid rgb(2, 44, 84);
  box-shadow: 0 0 5px #aaa;
  margin-bottom: 30px;
  padding: 20px;
}
.contact-inner-form .form-group label {
  color: rgb(2, 44, 84);
  font-weight: normal;
  text-transform: uppercase;
}
.dark-container {
  background-color: #41c9f0;
  border-radius: 3px;
  color: #fff;
  margin-top: 0;
  padding: 20px;
}
</style>	
<div class="hug-aa-content">
    <div class="about-banner">
        <div class="container" style="padding:0">
            <div class="row">
                <p></p>
                <div class="banner-list">
                    <ul style="visibility:hidden">
                        <li>
                        BUY BTC:
                        <i class="fa fa-inr" aria-hidden="true"></i>
                        175,667
                        </li>
                        <li>
                        SELL BTC:
                        <i class="fa fa-inr" aria-hidden="true"></i>
                        170,837
                        </li>
                    </ul>
                </div>
                <p></p>
                <h3>CUSTOMER SUPPORT</h3>
            </div>
        </div>
    </div>
    
    <div class="hug hug-container" style="padding-bottom: 60px">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <h2 class="content-title color-primary">
                    <span id="hs_cos_wrapper_content_title" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_text" data-hs-cos-type="text" data-hs-cos-general-type="widget" style="">Questions? Want to Learn More About Perfektpay?</span>
                    </h2>
                    <p class="content-sub-title">
                    <span id="hs_cos_wrapper_content_sub_title" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_text" data-hs-cos-type="text" data-hs-cos-general-type="widget" style="">Whether you are a client requiring assistance or an investor interested in learning more about Perfektpay’s bitcoin trading services, please do not hesitate to contact us. Complete the form below and our global customer support team will contact you shortly!</span>
                    </p>
                    <br>
                    </div>
                <div class="col-sm-9">
                        <div class="contact-inner-form col-sm-12">
                            <form method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group  col-sm-6">
                                        <label style=" padding-top: 10px;">Your Name </label>
                                        @csrf
                                        <input class="form-control btc-input" name="name" placeholder="Your Name" required type="text">
                                    </div>
                                    <div class="form-group  col-sm-6">
                                        <label style=" padding-top: 10px;">Email</label>
                                        <input class="form-control btc-input" name="email" placeholder="Your Email" required type="text">
                                    </div>
                                </div>
                            </div>
                       
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group  col-sm-6">
                                        <label style=" padding-top: 10px;">Phone Number </label>
                                        <input class="form-control btc-input" name="ph_num" placeholder="Your Number" required type="Number">
                                    </div>
                                    <div class="form-group  col-sm-6">
                                        <label style=" padding-top: 10px;">Nature of Inquiry</label>
                                        <select class="form-control btc-input" name="nature_inq" required placeholder="Your Nature of Inquiry" type="select">
                                    <option value="">Please Select</option>
                                    <option value="2 Factor Authentication (2FA)">2 Factor Authentication (2FA)</option>
                                    <option value="Account Opening">Account Opening</option>
                                    <option value="API Queries">API Queries</option>
                                    <option value="Deposit Queries">Deposit Queries</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Media Inquiry">Media Inquiry</option>
                                    <option value="Opportunities &amp; Partnerships">Opportunities &amp; Partnerships</option>
                                    <option value="Product Feedback">Product Feedback</option>
                                    <option value="Withdrawal Queries">Withdrawal Queries</option>
                                    <option value="Other">Other</option></select>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group  col-sm-12">
                                        <label style=" padding-top: 10px;">Subject </label>
                                        <input class="form-control btc-input" name="subject" placeholder="Subject" required type="text">
                                    </div>
                                    <div class="form-group  col-sm-12">
                                        <label style=" padding-top: 10px;">Message</label>
                                        <textarea class="form-control btc-input" name="message" placeholder="Message" required type="textarea"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group  col-sm-12">
                                        <center>
                                            <button class="btn btn-newbtnW" >
                                            <h4>
                                            <span  class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_rich_text" style="" data-hs-cos-general-type="widget" data-hs-cos-type="rich_text">
                                            SUBMIT
                                            </span>
                                            </h4>
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>

                        </form>
                        </div>
                        
                    <!--<p>
                    DFS complaint:
                    <br>
                    You may also direct your complaint to the attention of the NY Department of Financial Services at One State Street New York, NY 10004-1511 or 1-800-342-3736. Please visit www.dfs.ny.gov for information.
                    </p>-->
                </div>
                
                <div class="col-sm-3">
                    <div class="dark-container">
                        <h3 class="color-primary">
                        <span id="hs_cos_wrapper_contact_info_title" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_text" data-hs-cos-type="text" data-hs-cos-general-type="widget" style=""></span>
                        </h3>
                        <p>
                            <span id="hs_cos_wrapper_content_info_text" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_text" data-hs-cos-type="text" data-hs-cos-general-type="widget" style=""></span>
                        </p>
                        <span id="hs_cos_wrapper_contact_info_rich_text" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_rich_text" data-hs-cos-type="rich_text" data-hs-cos-general-type="widget" style="">
                        <h3>
                            <span style="font-size: 18px; color:  rgb(0,52,102);">Email Customer Support</span>
                        </h3>
                        <p class="p1">
                            <span class="s1" style="color: #f9be00;">
                                <span class="s2">
                                    <a href="">
                                        <span style="color: rgb(0,52,102);">support@perfektpay.com</span>
                                    </a>
                                </span>
                            </span>
                        </p>
                        <hr>
                        <h3>
                            <span style="font-size: 18px;">
                            <span style="color: rgb(0,52,102);">Global Phone Support</span>
                            </span>
                        </h3>
                        <p class="p1">
                            <span class="s1" style="color: #f9be00;">
                                <span class="s2">
                                    <a href="">
                                        <span style="color: rgb(0,52,102);">+852 6024 5489</span>
                                    </a>
                                </span>
                            </span>
                        </p>
                        <hr>
                        <h3>
                            <span style="font-size: 18px;">
                            <span style="color:  rgb(0,52,102);;">Address</span>
                            </span>
                        </h3>
                        <p class="p1">
                            <span class="s1" style="color: #fff;">
                                <span class="s2">
                                    <a href="">
                                        <span style="color: rgb(0,52,102);">Perfekt Capital Limited,<br>Unit 804 8F Boss Commercial Centre<br>28 Ferry Street, Yau Ma Tei,<br>Kowloon, Hong Kong</span>
                                    </a>
                                </span>
                            </span>
                        </p>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>




		
@stop