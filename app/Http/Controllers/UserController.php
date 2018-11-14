<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Respons;
use App\Http\Requests;
use Redirect;
use Validator;
use DB;
use Illuminate\Support\Facades\Session;
use Crypt;
use Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Libraries\block_io;
use App\Libraries\itbit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination;
use Excel;


class UserController extends Controller
{
    use ValidatesRequests;

    public function login(){
        if(Session::has('user_id')){ 
            $user_id = Session::get('user_id');
            $g_auth = DB::table('users')->where(['id'=>$user_id,'G_AUTH'=>0,'is_gAuth'=>0,'AUTH_skip'=>0])->first(['id']);
            if(isset($g_auth)){
                return redirect('user_authent');
            }else{
                return redirect('funding');
            }        
        }else{
            return view('/login');
        }
        
    }

    public function signup(){
        if(Session::has('user_id')){
            $user_id = Session::get('user_id');
            $g_auth = DB::table('users')->where(['id'=>$user_id,'G_AUTH'=>0,'is_gAuth'=>0,'AUTH_skip'=>0])->first(['id']);
            if(isset($g_auth)){
                return redirect('user_authent');
            }else{
                return redirect('funding');
            }   
        }else{            
            return view('/signup');            
        }
    }




    public function check_bitcoin_payment($ajax="")
    {       
        $user_id=Session::get("user_id");
        $bitcoin_add = DB::table('bitcoin_transactions')->where(['user_id'=>$user_id])->where(function ($query) {
                                                        $query->where('status', 0)
                                                              ->orWhere('status',2);  })->first();
        if(isset($bitcoin_add) && !empty($bitcoin_add)){
            $apiKey = env('BLOCK_IO_API_KEY');
            $pin = env('BLOCK_IO_PIN');
            $version = env('BLOCK_IO_VERSION'); 
            $block_io = new block_io($apiKey, $pin, $version);
            $data = $block_io->get_transactions(array('type' => 'received', 'addresses' => $bitcoin_add->address));
             
               if(!empty($data->data->txs) && $data->data->txs[0]->confirmations >= 6){
                       $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "6"]);
                if($ajax){
                    echo "1";
                }else{
                    Session::flash('message','Amount Received.');
                    return redirect('funding');
                }
            }elseif (!empty($data->data->txs) && $data->data->txs[0]->confirmations < 6 && $bitcoin_add->status!=2) {
                        $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "2"]);
                        $user=DB::table('users')->where('id',$bitcoin_add->user_id)->first();
                        User::mail_send($user,3,$data->data->txs[0]->amounts_received[0]->amount);
                       if($ajax){
                        echo "2";
                    }else{
                        Session::flash('message','Amount Pending');
                        return redirect('funding');
                    } 
            } 
            else{
                if($ajax){
                    echo "0";
                }else{
                    Session::flash('error','Sorry no amount received yet on this address.');
                    return redirect('funding');
                }
            }
        }else{
            $bitcoin_add_det = DB::table('bitcoin_transactions')->where(['user_id'=>$user_id])->first(["id","label","address","status"]);
            if(isset($bitcoin_add_det) && !empty($bitcoin_add_det)){
                if($bitcoin_add_det->status == 1){
                    if($ajax){
                        echo "2";
                    }else{
                        Session::flash('message','Amount Pending');
                        return redirect('funding');
                    }
                }else{
                    if($ajax){
                        echo "1";
                    }else{
                        Session::flash('message','Amount Received');
                        return redirect('funding');
                    }
                }
            }else{
                if($ajax){
                    echo "3";
                }else{
                    Session::flash('error','No record found.');
                    return redirect('funding');
                }
            }
        }
    }




    public function check_bitcoin_payment_ajax()
    {
        $data = Input::all();
        if(isset($data) && !empty($data)){
            $ajax = $data['ajax'];
            return $this->check_bitcoin_payment($ajax);
        }
    }

    public function contact_us(){
        return view('/contact');
    }

    public function exchange(){
        return view('/exchange');
    }

    public function contact_us_p(){
        //dd(Input::all());
//support@perfektpay.com
        return User::contact_us_p(Input::all());
    }
    
    public function generate_address()
    {
        $apiKey = env('BLOCK_IO_API_KEY');
        $pin = env('BLOCK_IO_PIN');
        $version = env('BLOCK_IO_VERSION'); 
        $block_io = new block_io($apiKey, $pin, $version);        
        // dd($block_io);
        $user_id=Session::get('user_id');
        $bitcoin_add = DB::table('bitcoin_transactions')->where(['user_id'=>$user_id, 'amount'=>0])->where(function ($query) {
                                                        $query->where('status', 0)
                                                              ->orWhere('status',2);  })->first();
        if(isset($bitcoin_add) && !empty($bitcoin_add)){
             $data = $block_io->get_transactions(array('type' => 'received', 'addresses' => $bitcoin_add->address));
             
               if(!empty($data->data->txs) && $data->data->txs[0]->confirmations >= 6){
                       $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "6"]);       
                $bitcoin_add = DB::table('bitcoin_transactions')->where(['user_id'=>$user_id,'status'=>'0'])->first();

                $getNewAddressInfo = $block_io->get_new_address();
                $label = $getNewAddressInfo->data->label;
                $address = $getNewAddressInfo->data->address;
            }elseif (!empty($data->data->txs) && $data->data->txs[0]->confirmations < 6 && $bitcoin_add->status!=2) {
                        $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "2"]);
                        $user=DB::table('users')->where('id',$bitcoin_add->user_id)->first();
                        User::mail_send($user,3,$data->data->txs[0]->amounts_received[0]->amount);
                $bitcoin_add = DB::table('bitcoin_transactions')->where(['user_id'=>$user_id])->where(function ($query) {
                                                        $query->where('status', 0)
                                                              ->orWhere('status',2);  })->first();

                $getNewAddressInfo = $block_io->get_new_address();
                $label = $getNewAddressInfo->data->label;
                $address = $getNewAddressInfo->data->address;       
            } 
            else{
                $label = $bitcoin_add->label;
                $address = $bitcoin_add->address;
            }
        }else{
            if(isset($bitcoin_add) && !empty($bitcoin_add) && $bitcoin_add->status == 2){
                 $data = $block_io->get_transactions(array('type' => 'received', 'addresses' => $bitcoin_add->address));
               if(!empty($data->data->txs) && $data->data->txs[0]->confirmations >= 6){
                       $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "6"]);
               }
               elseif (!empty($data->data->txs) && $data->data->txs[0]->confirmations < 6 && $bitcoin_add->status!=2) {
                        $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "2"]);
                        $user=DB::table('users')->where('id',$bitcoin_add->user_id)->first();
                        User::mail_send($user,3,$data->data->txs[0]->amounts_received[0]->amount);      
            }     
            }
            $getNewAddressInfo = $block_io->get_new_address();
            $label = $getNewAddressInfo->data->label;
            $address = $getNewAddressInfo->data->address;
        }
        
        $current_price = $block_io->get_current_price(array('USD' => 'btc'));
        foreach($current_price->data->prices as $btc_key=>$btc_value)
        {
            if($btc_value->exchange == 'bitfinex' && $btc_value->price_base == 'USD')
            {
                $btcValue = $btc_value->price;
                $exchange = $btc_value->exchange;
                break;
            }else if($btc_value->exchange == 'coinbase' && $btc_value->price_base == 'USD'){
                $btcValue = $btc_value->price;
                $exchange = $btc_value->exchange;
                break;   
            }
        }

        if(isset($user_id) && !empty($user_id)){ 
            if(isset($bitcoin_add) && !empty($bitcoin_add) && $bitcoin_add->status == 0){
                $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['btc_value'=> $btcValue,'updated_by' => $user_id]);
            }else{
                $bitcoin_data_id = DB::table('bitcoin_transactions')->insertGetId(array(
                                                            'user_id' => $user_id,
                                                            'label'      => $label,
                                                            'address'   => $address,
                                                            'btc_value'=> $btcValue, 
                                                            'exchange' => $exchange,
                                                            'created_by' => $user_id,
                                                            'updated_by' => $user_id
                                                            ));
            }
        }

        $url ='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=bitcoin:'.$address;

       return json_encode(array('address' => $address, 'label'=> $label,'btcValue'=>$btcValue,'exchange'=>$exchange,'url'=>$url));
    }

    public function user_detailspage(){
        $signedUp_user=Session::get("signedUp_user");
        $flag = false;
        if(isset($signedUp_user)&& !empty($signedUp_user)){ 
            $signup_user_detail = DB::table('users')->where('id',$signedUp_user)->first(["is_email"]);
            // dd($signup_user_detail);
            if($signup_user_detail->is_email){
                $countries = DB::table('countries')->get();
                return View('user.user_details')->with(['value'=>array("id"=>$signedUp_user,"type"=>"c"),"country"=>$countries]);
            }else{ $flag = true;}
        }else{ $flag = true;}

        if($flag){
            return redirect("signup");
        }
    }
    public function fetchCountryCode()
    {
        $country = Input::post('country');
        $countryData = DB::table('countries')->where('id',$country)->first();
        echo $countryData->phonecode;
    }

    public function funding(){
        $user_id=Session::get("user_id");  
        // dd(Session::get("noti"));      
        $funding_history = json_decode(User::funding_history($user_id,"funding"),true);
        //create pagination
       if($funding_history!=''){
           $currentPage = LengthAwarePaginator::resolveCurrentPage();
           $col = new Collection($funding_history);    
           $perPage = 10;
           $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
           $funding_history = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
           $funding_history->setPath(route('funding'));
       }
        $skipped_notification = (array)User::skipped_notification($user_id);
        $itbit = $this->itbit();
        $total_btc = User::total_bitcoin($user_id)[0];        
        $balance_btc = User::balance_bitcoin($user_id)[0];
        $total_usd = User::total_usd($user_id)[0];
        $balance_usd = User::balance_usd($user_id)[0];
        $kyc_resp = json_decode(User::check_rejected($user_id),true);
        $banks = User::get_bank($user_id);

        $g_auth = DB::table('users')->where('id',$user_id)->first(['G_AUTH']);
// dd($funding_history);
        return view('user.funding')->with(['itbit'=>$itbit,'total_btc'=>$total_btc->total_btc,'balance_btc'=>$balance_btc->balance_btc,'balance_usd'=>$balance_usd->balance_usd,'total_usd'=>$total_usd->total_usd,'funding_history'=>$funding_history,'skipped_notification'=>$skipped_notification,'kyc_resp'=>$kyc_resp,'banks'=>$banks,'g_auth'=>$g_auth]);
            
    }

    public function cancel_with(){
        $input = Input::all();
        User::cancel_with($input);
        Session::flash('message','your withdrawal has been cancel successfully');
        return redirect('funding');
    }

    public function down_csv(){
        $user_id=Session::get("user_id");
        $input = input::all();
         $orders_detail = User::get_orders($user_id,"trading_history_down",0);
          if(!is_null($input['end_d'])){
                $orders_detail = User::get_orders($user_id,"trading_history_down",$input);
            }
        if($orders_detail!=''){
               Excel::create('Orders detail data', function($excel) use ($orders_detail){
                   $excel->sheet('Profit', function($sheet) use ($orders_detail)
                   {
                       $sheet->loadView('user.excel_layout.orders_detailExcel',['orders_detail'=>$orders_detail]);
                   });
               })->download('csv');
           }
    }
    
    public function bank_details(){     
        $data= Input::all();
        if(isset($data['amount']) && !empty($data['amount']) && isset($data['image_file']) && !empty($data['image_file'])){
            $amount = $data['amount'];
            $user_id=Session::get("user_id");
            $image = $data['image_file'];
            $file = Input::file('image_file');      
            if(isset($file)){
                if(Input::file('image_file')->isValid() && substr($file->getMimeType(), 0, 5) == 'image')        
                {
                    $file = Input::file('image_file');
                    $directory = public_path().'/user_images';
                    $extension = $file->getClientOriginalExtension(); 
                    $filename = "thumb_" . substr(sha1(time().time()), 0, 15).str_random(5). ".{$extension}";
                    $upload_success = Input::file('image_file')->move($directory, $filename);
                    $national_id_flag =1;
                    $value=User::dep_bank_trans($user_id,$amount,$filename);    

                    if($value['success']==1){
                        Session::flash('message','Request submitted successfully');
                        return redirect('funding');
                    }                 
                }else{
                    Session::flash('error','Your image is not valid');
                    return redirect('funding');
                }
            }
        }else{
            Session::flash('error','Both fields are required');
            return redirect('funding');
        }
    }

    public function index(){
        $user_id=Session::get("user_id");
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.itbit.com/v1/markets/XBTUSD/ticker"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $itbit = curl_exec($ch); 
        $itbit = json_decode($itbit,true);
        curl_close($ch);
        if(!empty($user_id)){
            $itbit = $this->itbit();
        }
        $user_id = (isset($user_id) && !empty($user_id) ? $user_id : "");
        return view('index')->with(["user_id"=>$user_id,"itbit"=>$itbit]);
    } 

    public function logout(){
        $user_id = Session::get("user_id");
        if(isset($user_id)&& !empty($user_id)){
            DB::table('users')->where('id',$user_id)->update(['is_gAuth'=>0]);
        }
        Session::forget('user_id');
        return redirect("/");
    }

    public function aboutbitcoin(){
        $user_id = "";
        if(Session::has('user_id')){
            $user_id = Session::get("user_id");
        }   
        return view('about-bitcoin')->with("user_id",$user_id);
    }    

    public function howitworks(){
        $user_id = "";
        if(Session::has('user_id')){
            $user_id = Session::get("user_id");
        }  
        return view('how-it-works')->with("user_id",$user_id);
    } 


    public function about(){
        $user_id = "";
        if(Session::has('user_id')){
            $user_id = Session::get("user_id");
        }  
        return view('about')->with("user_id",$user_id);
    } 

    public function security(){
        $user_id = "";
        if(Session::has('user_id')){
            $user_id = Session::get("user_id");
        }  
        return view('security')->with("user_id",$user_id);
    }

    public function support(){
        $user_id = "";
        if(Session::has('user_id')){
            $user_id = Session::get("user_id");
        }  
        return view('support')->with("user_id",$user_id);
    } 

    public function loginpost(){
        $data=Input::all();
        if($data['g-recaptcha-response']!=''){
           $value=User::loginpost($data);
           if($value['success']==1){  
              return redirect()->route('user_details');
            }else if($value['success']==2){
                return redirect()->route('verify_kyc');
            }else if($value['success']==3){
                return redirect()->route('user_authentpage');
            }else if($value['success']==0){
                return View('login')->withErrors($value['msg']);
            }
        }else{
            return View('login')->with('CaptchaErr',"Please Compalete Captcha!");
        }
    }


    public function signuppost(){    	
        $data=Input::all();
        // dd($data);
        if(isset($data['g-recaptcha-response']) && !empty($data['g-recaptcha-response']) &&$data['g-recaptcha-response']!=''){
        	$value=User::signuppost($data);
        	if($value['success']==1){   
                return \View::make('signup')->with('value',$value);
        	}elseif($value['success']==0){
                return View('signup')->withErrors($value['msg']);
            }
        }else{
            return View('signup')->with('CaptchaErr','Please Complete Captcha!');
        }
    }

    public function validateemail(){
        $data=Input::all();
        $value=User::validateemail($data);        
        return $value;       
    }

    public function check_username(){        
        $data=Input::all();
        $value=User::checkusername($data);        
        return $value;       
    }

    public function confirmUser($rem_token){
        if(isset($rem_token) && !empty($rem_token)){
            $value=User::confirmUser($rem_token);
            // dd($value);  
            if($value['success']==1){
                return redirect("user_details"); 
            }else if($value['success']==0){
                return View('error.error606');
            }else if($value['success']==404){
                return View('error.error404');
            }
        }
    }

    public function legal(){
        return View('legal');
    }

public function check_checked(){
    $user_id = Session::get("user_id");
    return User::check_checked($user_id);
}

public function faq(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.faq-main')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function accepted_documents(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.accepted-documents')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function i_haven_t_received_my_bitcoin_withdrawal(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.i-haven-t-received-my-bitcoin-withdrawal')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function my_deposit_hasn_t_been_applied_to_my_account(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.my-deposit-hasn-t-been-applied-to-my-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function how_to_report_an_perfekt(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-to-report-an-perfekt-website-issue-to-the-support-team')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function get_access_to_the_perfektpay_api(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-can-i-get-access-to-the-perfektpay-api')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function what_is_rest_api(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.what-is-rest-api')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function what_is_fix_api(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.what-is-fix-api')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function s_security_unique(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-is-perfektpay-s-security-unique')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function recaptcha_isn_t_appearing(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.what-to-do-when-recaptcha-isn-t-appearing')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function website_isn_t_loading_correctly(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.steps-to-take-if-the-perfekt-website-isn-t-loading-correctly')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function have_a_market_data_api(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.does-perfektpay-have-a-market-data-api')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function why_is_it_important(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.what-is-cost-basis-and-why-is-it-important')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function move_any_funds(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.i-didn-t-move-any-funds')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function need_to_file(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.when-do-i-need-to-file')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function file_bitcoin_income(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-do-i-file-bitcoin-income')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function why_do_i_need_it(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.what-is-2fa-and-why-do-i-need-it')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function how_to_add_2fa(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-to-add-2fa-to-my-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function how_to_reset_2fa(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-to-reset-2fa-on-my-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function weekly_client(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.weekly-client-website')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function industry_alert(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.industry-alert')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function apis_perfektpay_support(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.what-apis-does-perfektpay-support')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function kept_private_and_secure(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.will-my-information-be-kept-private-and-secure')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function required_documents(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.required-documents')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function compliance(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.compliance')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function deposit_id(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.deposit-id')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function faq_bitcoin(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.faq-bitcoin')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function faq_open(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.faq-open')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function faq_overview(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.faq-overview')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function faq_trade_history(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.faq-trade-history')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function faq_why(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.faq-why')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function fee_structure(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.fee-structure')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function holidays(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.holidays')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function deposit_schedule_us(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.fiat-deposit-schedule-us-non-us-customers')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function fund_my_account(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-do-i-fund-my-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function withdraw_my_funds(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-do-i-withdraw-my-funds')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function fiat_withdrawal_processing(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.bitcoin-fiat-withdrawal-processing')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function how_long_verify(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-long-verify')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function how_to_close_account(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-to-close-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function how_to_create_account(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.how-to-create-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function manage_account(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.manage-account')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function support_bitcoin_forks(){
     $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.support-bitcoin-forks')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function why_are_bitcoin_prices_different(){
     $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.why-are-bitcoin-prices-different')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function why_can_t_my_onboarding_be_completed(){
     $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.why-can-t-my-onboarding-be-completed')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function i_didn_t_receive_my_verification_email(){
     $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.i-didn-t-receive-my-verification-email')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function my_2fa_is_not_syncing(){
     $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.my-2fa-is-not-syncing')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}

public function order_support(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.order-support')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function recover_username(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.recover-username')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function start_Trading(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.start-Trading')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function trade_with(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.trade-with')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function trading_desk(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.trading-desk')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function verification(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.verification')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function withdrawal_limits(){
    $user_id=Session::get("user_id");
    $itbit = $this->itbit();
    $skipped_notification = (array)User::skipped_notification($user_id);
    return View('user.withdrawal-limits')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification]);
}
public function check_unchecked(){
     $user_id = Session::get("user_id");
    return User::check_unchecked($user_id);
}

    public function user_details(){
        $data=Input::all();
        
        if(isset($data)){
            $value=User::userdetails($data);            
            if($value['success']==1){
                if($data['type']=='c'){
                    return redirect('login'); 
                }else if($data['type']=='l'){



                    $country = DB::table('countries')->where('id',$data['country'])->first(["name"]);
                    return View('user.verify_kyc')->with(['value'=>array('id'=>$data['id'], 'country'=>$country->name),"header"=>"layouts.app_login"]);
                }
            }else if($value['success'==404]){
                    return View('error.error404');
            }
        }else {
            return View('error.error404');
        }   
    }


    public function kyc_details(){
            $data= Input::all();                        
            $suss=0;
            $chko=0;

            $data['id'] = (empty($data['id'])?Session::get("user_id"):$data['id']);
            if(isset($data['image_file'])){
                $image = $data['image_file'];
                $file = Input::file('image_file');      
                if(isset($file)){
                    if(Input::file('image_file')->isValid() && substr($file->getMimeType(), 0, 5) == 'image')        
                    {
                        
                        $file = Input::file('image_file');
                        $directory = public_path().'/user_images';
                        $extension = $file->getClientOriginalExtension(); 
                        $filename = "thumb_" . substr(sha1(time().time()), 0, 15).str_random(5). ".{$extension}";
                        $upload_success = Input::file('image_file')->move($directory, $filename);
                        $national_id_flag =1;
                        $chko=$chko+1; 
                        $value=User::kyc_data($data['id'],$filename,"1",$chko);    

                        if($value['success']==1){
                            $suss=1;
                        }                 
                    }
                }
            }

            if(isset($data['image_file1'])){
                $image = $data['image_file1'];
                $file = Input::file('image_file1');
                if(isset($file)){
                    if(Input::file('image_file1')->isValid() && substr($file->getMimeType(), 0, 5) == 'image')        
                    {
                        $file = Input::file('image_file1');

                        $directory = public_path().'/user_images';
                        $extension = $file->getClientOriginalExtension(); 
                        $filename  = "thumb_" . substr(sha1(time().time()), 0, 15).str_random(5). ".{$extension}";
                        $upload_success  = Input::file('image_file1')->move($directory, $filename);
                        $address_id_flag = 1;
                        $chko=$chko+1; 
                        $value=User::kyc_data($data['id'],$filename,"2",$chko);  

                        if($value['success']==1){
                            $suss=1;
                        } 
                    }
                }
            }
            if($suss==1){
                $from_profile = false;
                if(isset($data['u__token']) && !empty($data['u__token']) && md5(Session::get("user_id")) == $data['u__token']){
                    $data['id'] = Session::get("user_id");
                    if(isset($data['image_file1'])){
                        $proof = 2;
                    }else if(isset($data['image_file'])){
                        $proof = 1;
                    }
                    DB::table('user_kyc_details')->where(['user_id'=>$data['id'], 'kyc_name'=>$proof])->update(['status'=>0]);
                    $from_profile = true;
                }

                if($from_profile){
                    Session::flash('message','Document submitted successfully');
                }else{
                    Session::flash('message','KYC request submitted successfully');
                    DB::table('users')->where('id',$data['id'])->update(['KYCF'=>'1','KYCF_skip'=>'0']); 
                }
                return array('success'=> 1);
            }else{
                Session::flash('error','Your image is not valid');
                return array('success'=> 1);
            }
    }

    // restpassword view
public function reset_password_get($token){
      $data=User::adminmatchtoken($token);
        if($data==0){
        $res=array();
        $res['token']=$token;
        $res['success']=0;
        $res['msg']='Your password reset link has expired';
        return view('forgot_password2',compact('res')); 
        }

    return \View::make('forgot_password2')->with('token', $token);
    }


//post restpassword api
public function reset_password_post(){
    $input= Input::all();
    // dd($input);
    $token=$input['token'];
    $data = User::reset_password_post($input);
    $res=array();
    if($data['success']==1){

          $res['token']=$token;
          $res['success']=1;
          $res['msg']='Password updated successfully';
           Session::flash('message','password change successfully');
          return redirect('login');
    }
    else{
          $res['token']=$token;
          $res['success']=0;
          $res['msg']=$data['msg'];
          return view('forgot_password2',compact('res'));  
    }
}

    //kyc skip
    public function kyc_skip(){  
        if(Session::has('user_id')){
            $user_id=Session::get("user_id");
            $value=User::user_authent($user_id);
            if($value['success']==1){
                //return View('user.user_authent')->with('value',array('id' =>$input['key'] ));
                return redirect()->route('user_authentpage');
            }else{
                return View('error.error404');
            }  
        }  
    }

    /**********Verify KYC**********/
    public function reverify_kyc(){
        $user_id=Session::get("user_id");
        $country = DB::table('users')->where('users.id',$user_id)->leftJoin('countries', 'users.country', '=', 'countries.id')->first(['countries.name as country']);
        if(isset($country) && !empty($country)){
            $itbit = $this->itbit();
            $skipped_notification = (array)User::skipped_notification($user_id);
            // dd($skipped_notification); 
            return View('user.verify_kyc')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification,'value'=>array('id'=>$user_id,'country'=>$country->country),'header'=>"user.layouts.layout"]);
        }else{
            Session::flash('error','No record');
            return redirect('funding');
        }        
    }

    //kyc complete
    public function user_authenticat(){       
        if(Session::has('user_id')){
            $user_id=Session::get("user_id");
            $value=User::user_authenticat($user_id);
            if($value['success']==1){
                //return View('user.user_authent');
                 return redirect()->route('user_authentpage');

            }else{
                return View('error.error404');
            }    

        }
    }

    public function user_authent_skip(){       
        if(Session::has('user_id')){
            $user_id=Session::get("user_id");
            $value=User::user_authent_skip($user_id);

            if($value['success']==1){
                return redirect('funding'); 
            }else{
                return View('error.error404');
            }  
        }  
    }

    public function user_authentpage(){
        if(Session::has('user_id')){
            return $this->g2f('layouts.app_login');
        }else{
            return redirect("/");
        }
    }
    public function g_security(){
        if(Session::has('user_id')){
            // dd('here');
            $user_id=Session::get("user_id");
            $itbit = $this->itbit();
            $skipped_notification = (array)User::skipped_notification($user_id);
            $extra = ['itbit'=>$itbit,'skipped_notification'=>$skipped_notification];
            return $this->g2f('user.layouts.layout',$extra);
        }else{
            return redirect("/");
        }
    }

public function my_noti(){
    $input = Input::all();
    if($input['type'] == 'google'){
            $i = Session::put('noti2', '1');
        }
        else if($input['type'] == 'kyc'){
            $i = Session::put('noti', '1');  
        }
        return 1;
}

    public function g2f($header,$extra="")
    {
        if(Session::has('user_id')){
            $user_id=Session::get("user_id");
            
            $user_data=User::check_per($user_id);
            $g_auth = DB::table('users')->where('id',$user_id)->first(['G_AUTH']);

            if(isset($g_auth) && !empty($g_auth) && $g_auth->G_AUTH == 1){
                return view('user.user_authent', ['g_auth' => $g_auth->G_AUTH])->with(['value'=>array('id'=>$user_id),'header'=>$header])->with($extra);
            }else{
                //generate new secret
                 // dd($header);
                if($user_data->AUTH_skip==1&&$header!="user.layouts.layout"){
                    return redirect('/funding');
                }
                // dd("google2fa_secret");
                $google2fa_secret = Google2FA::generateSecretKey();
                $encrypt = Crypt::encrypt($google2fa_secret);

                $data = DB::table('users')->where('id',$user_id)->update(['google2fa_secret'=>$encrypt]);
                $email = DB::table('users')->where('id',$user_id)->first(['email']);
                                //generate image for QR barcode
                $imageDataUri = Google2FA::getQRCodeInline(
                    env('APP_NAME'),
                    $email->email,
                    $google2fa_secret,
                    200
                );
                // dd($imageDataUri);
                return view('user.user_authent', ['image' => $imageDataUri,
                'secret' => $google2fa_secret])->with(['value'=>array('id'=>$user_id),'header'=>$header])->with($extra);
            }
        }else{
            return redirect("/");
        } 
    }

    public function gValidateToken()
    {
        if(Session::has('user_id')){
            $user_id=Session::get("user_id");
            $data= Input::all();
            // dd($data);
            $u_data = DB::table('users')->where('id',$user_id)->first(['google2fa_secret']);
            $secret = Crypt::decrypt($u_data->google2fa_secret);
            $resp = Google2FA::verifyKey($secret,$data['totp']);
            if($resp){
                $g_auth_data = DB::table('users')->where('id',$user_id)->first(['G_AUTH']);
                if(isset($g_auth_data) && $g_auth_data->G_AUTH != 1){
                    DB::table('users')->where('id',$user_id)->update(['G_AUTH'=>1,'AUTH_skip'=>0]);
                }
                DB::table('users')->where('id',$user_id)->update(['is_gAuth'=>1]);

                if(isset($data['ajax'])&& !empty($data['ajax']) && $data['ajax']==1){
                    echo "1";
                }else{
                    return redirect('funding');
                }
            }else{
                if(isset($data['ajax'])&& !empty($data['ajax']) && $data['ajax']==1){
                    echo "0";
                }else{
                    return redirect("/user_authent");
                }
            }
        }else{
            if(isset($data['ajax'])&& !empty($data['ajax']) && $data['ajax']==1){
                echo "2";
            }else{
                return redirect("/");
            }
        }
    }


    public function kyc_detailspage(){
        if(session::has('user_id') && session::has('country')){
            $user_id=Session::get("user_id");
            $country=Session::get("country");
            $kycf = DB::table('users')->where('id',$user_id)->first(["KYCF"]);
            if(isset($kycf) && !empty($kycf) && $kycf->KYCF == 1){
                return redirect('user_authent');
            }else{
                return View('user.verify_kyc')->with(['value'=>array('id'=>$user_id,'country'=>$country),"header"=>"layouts.app_login"]);
            }
        }else{
            return View('error.error404');
        }
    } 

    public function profile(){
        if(session::has('user_id')){
            $user_id=Session::get("user_id");
            $userData['userinfo'] = User::profile($user_id);
            $userData['country'] = DB::table('countries')->get();
            $userData['kycinfo'] = DB::table('user_kyc_details')->select('user_id','kyc_name','status')->where(['user_id'=>$user_id])->get();
            $itbit = $this->itbit();
            $skipped_notification = (array)User::skipped_notification($user_id);
            $banks = User::get_bank($user_id);
            /*echo "<pre>";
            print_r($banks);
            echo "</pre>";*/
            return View('user.profile')->with(['userData'=>$userData,'itbit'=>$itbit,'skipped_notification'=>$skipped_notification,'banks'=>$banks]);
        }else{
            return redirect('/');
        }
    }

    public function update_profile(){
        if(session::has('user_id')){
            $user_id=Session::get("user_id");
            $data = Input::all();
            if(isset($data) && !empty($data)){                
                if($user_id == Crypt::decrypt($data['enc_id'])){                    
                    $response = User::update_profile($data);
                    if($response['success']==1){
                        Session::flash('message','Profile updated successfully.');
                        // return redirect('profile');
                        return redirect('settings');
                    }else{
                        Session::flash('error','Something went wrong');
                        // return redirect('profile');
                        return redirect('settings');
                    }
                }   
            }else{
                Session::flash('error','Something went wrong');
                return redirect('funding');
            }            
        }else{
            return redirect('/');
        }
    }

    public function trading()
    {
        if(session::has('user_id')){

            /*$itbit_api = new itbit(env('CLIENT_ITBIT_CLIENT_SECRET'),env('CLIENT_ITBIT_CLIENT_KEY'),env('CLIENT_ITBIT_USER_ID'));

            echo '<pre>';
            print_r($itbit_api->wallet(env('CLIENT_ITBIT_CLIENT_WALLET_ID')));
            print_r($itbit_api->orders(env('CLIENT_ITBIT_CLIENT_WALLET_ID')));
            echo '</pre>';*/

            $user_id=Session::get("user_id");
            $kyc_resp = json_decode(User::check_rejected($user_id),true);
            
            $skipped_notification = (array)User::skipped_notification($user_id);
            $itbit = $this->itbit();
            $order_arr = json_decode($this->order_book(),true);
            $order_html = $this->order_html($order_arr);
            $total_btc = User::total_bitcoin($user_id)[0];
            $balance_btc = User::balance_bitcoin($user_id)[0];
            $total_usd = User::total_usd($user_id)[0];
            $balance_usd = User::balance_usd($user_id)[0];

            $itbit_comm =  User::get_perfektpay_meta("itbit_commission");
            $perfektpay_comm =  User::get_commission($user_id);
            $orders_detail = json_decode(User::get_orders($user_id,"trading"),true);
            return View('user.trade')->with(['itbit'=>$itbit,'skipped_notification'=>$skipped_notification,'order_html'=>$order_html,'total_btc'=>$total_btc->total_btc,'balance_btc'=>$balance_btc->balance_btc,'balance_usd'=>$balance_usd->balance_usd,'total_usd'=>$total_usd->total_usd,"orders_detail"=>$orders_detail,"itbit_commission"=>$itbit_comm,"perfektpay_commission"=>$perfektpay_comm,"kyc_resp"=>$kyc_resp]);
        }else{
            return redirect('/');
        }
    }

    public function order_html($order,$ajax="")
    {
        $user_data=User::check_per(Session::get("user_id"));
        $bid = $user_data->ticker_paid;
        $ask = $user_data->ticker_ask;
        /*
        $itbit['old_bid'] = $itbit['bid'];
        $itbit['bid'] = (($bid*$itbit['bid'])/100)+$itbit['bid'];
        $itbit['old_ask'] = $itbit['ask'];
        $itbit['ask'] = (($ask*$itbit['ask'])/100)+$itbit['ask'];
        */
        $html = $bid_total = $asks_total = "";
        if(isset($order)&& !empty($order)){
            if(count($order['bids']) > count($order['asks'])){
                $i=0;
                foreach ($order['bids'] as $index => $data) { 

                    $bid_total = floatval($bid_total) + floatval($data[1]);
                    $asks_total = (isset($order['asks'][$index][1]) && !empty($order['asks'][$index][1]) ? round(floatval($asks_total) + floatval($order['asks'][$index][1]),4) : "");
                    if($i>9 && empty($ajax)){
                        $html .= '<tr style="display:none;">';
                    }else{
                        $html .= '<tr>';
                    }

                        $data[0] = (($bid*$data[0])/100)+$data[0];
                        if(isset($order['asks'][$index][0]) && !empty($order['asks'][$index][0])){
                            $order['asks'][$index][0] = (($ask*$order['asks'][$index][0])/100)+$order['asks'][$index][0];
                        }

                        $html .= '<td>'.round($bid_total,4).'</td>
                                <td>'.number_format((float)$data[1], 4, '.', '').'</td>
                                <td >$'.number_format((float)$data[0], 2, '.', '').'</td>
                                <td class="text-right">'.(isset($order['asks'][$index][0]) && !empty($order['asks'][$index][0]) ? "$".number_format((float)$order['asks'][$index][0], 2, '.', '') : "").'</td>
                                <td class="text-right">'.(isset($order['asks'][$index][1]) && !empty($order['asks'][$index][1]) ? number_format((float)$order['asks'][$index][1], 4, '.', '') : "").'</td>
                                <td class="text-right">'.$asks_total.'</td>
                            </tr>';
                    $i++;
                }   
            }else{
                $i=0;
                foreach ($order['asks'] as $index => $data) { 
                    $bid_total = (isset($order['bids'][$index][1]) && !empty($order['bids'][$index][1]) ? round(floatval($bid_total) + floatval($order['bids'][$index][1]),4) : "");

                    $asks_total = floatval($asks_total) + floatval($data[1]);
                    if($i>9 && empty($ajax)){                        
                        $html .= '<tr style="display:none;">';
                    }else{
                        $html .= '<tr>';
                    }
                         $data[0] = (($ask*$data[0])/100)+$data[0];
                        if(isset($order['bids'][$index][0]) && !empty($order['bids'][$index][0])){
                            $order['bids'][$index][0] = (($bid*$order['bids'][$index][0])/100)+$order['bids'][$index][0];
                        }
                        $html .= '<td>'.$bid_total.'</td>
                                <td>'.(isset($order['bids'][$index][1]) && !empty($order['bids'][$index][1]) ? number_format((float)$order['bids'][$index][1], 4, '.', '') : "").'</td>
                                <td >'.(isset($order['bids'][$index][0]) && !empty($order['bids'][$index][0]) ? "$".number_format((float)$order['bids'][$index][0], 2, '.', '') : "").'</td>
                                <td class="text-right">$'.number_format((float)$data[0], 2, '.', '').'</td>
                                <td class="text-right">'.number_format((float)$data[1], 4, '.', '').'</td>
                                <td class="text-right">'.round($asks_total,4).'</td>
                            </tr>';
                    $i++;
                }   
            } 
                                                                      
        }else{ 
            $html .= '<tr>
                        <td class="text-center" colspan="6" style="padding-top:50px;padding-bottom:50px;">
                            <img src="assets/images/empty.png"><br>
                            <p>There is no order history to display.</p>
                        </td>
                    </tr>';
        } 
        return $html;
    }

    public function trading_history()
    {
        if(session::has('user_id')){
            $input = Input::all();
            $user_id=Session::get("user_id");            
            $skipped_notification = (array)User::skipped_notification($user_id);
            $kyc_resp = json_decode(User::check_rejected($user_id),true);
            $orders_detail = User::get_orders($user_id,"trading_history",0);
            if(isset($input['end_d'])){
                $orders_detail = User::get_orders($user_id,"trading_history",$input);
            }
            $itbit = $this->itbit();
            // dd($orders_detail);
            return View('user.trading_history')->with(['itbit'=>$itbit,'kyc_resp'=>$kyc_resp,"orders_detail"=>$orders_detail,'skipped_notification'=>$skipped_notification]);
        }else{
            return redirect('/');
        }
    }

    public function itbit()
    {
        

        $user_data=User::check_per(Session::get("user_id"));
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.itbit.com/v1/markets/XBTUSD/ticker"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $itbit = curl_exec($ch); 
        curl_close($ch);
        $bid = $user_data->ticker_paid;
        $ask = $user_data->ticker_ask;
        $itbit = json_decode($itbit,true);
        $itbit['old_bid'] = $itbit['bid'];
        $itbit['bid'] = (($bid*$itbit['bid'])/100)+$itbit['bid'];
        $itbit['old_ask'] = $itbit['ask'];
        $itbit['ask'] = (($ask*$itbit['ask'])/100)+$itbit['ask'];
        $itbit['old_lastPrice'] = $itbit['lastPrice'];
        $itbit['lastPrice'] = (($ask*$itbit['lastPrice'])/100)+$itbit['lastPrice'];
        return $itbit;
    } 

    public function order_book()
    {
        $ajax = Input::get('ajax'); 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.itbit.com/v1/markets/XBTUSD/order_book"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $order_book = curl_exec($ch); 
        curl_close($ch);

        if(isset($ajax)&& !empty($ajax) && $ajax==1){
            $order_arr = json_decode($order_book,true);
            $order_html = $this->order_html($order_arr,$ajax);
            echo json_encode(array("order_html"=>$order_html));
        }else{
            return $order_book;
        }        
    } 
    
    public function thpdata()
    {
        $itbit = json_encode($this->itbit());
        $order_book = $this->order_book();
        $order_arr = json_decode($order_book,true);
        $order_html = $this->order_html($order_arr,1);
        $this->check_orders();
        echo json_encode(array("itbit"=>$itbit,"order_html"=>$order_html));
    } 

    public function current_btc_price($return="")
    {
        $block_io = new block_io(env('BLOCK_IO_API_KEY'), env('BLOCK_IO_PIN'), env('BLOCK_IO_VERSION'));   
        $current_price = $block_io->get_current_price(array("price_base" => "USD"));
        foreach ($current_price->data->prices as $btc_data) {
            if($btc_data->exchange == "bitfinex"){
                if($return){
                    return $current_price = $btc_data->price;
                }else{
                    echo $current_price = $btc_data->price;
                }
                break;
            }else if($btc_data->exchange == "coinbase"){
                if($return){
                    return $current_price = $btc_data->price;
                }else{
                    echo $current_price = $btc_data->price;
                }
                break;
            }
           
        }
    }

    public function trading_order()
    {
        $data = Input::all();
        $user_id=Session::get("user_id");
// dd($data);
        $data_itbit = $this->itbit();

        $block_io = new block_io(env('BLOCK_IO_API_KEY'), env('BLOCK_IO_PIN'), env('BLOCK_IO_VERSION'));
        
        $flag = false;
        $side = "";
        if(isset($data['buy_xbt']) && !empty($data['buy_xbt']) && $data['buy_xbt'] == 1){
            $side = "1";
            $flag = true;            
        }else if(isset($data['sell_xbt']) && !empty($data['sell_xbt']) && $data['sell_xbt'] == 2){
            $side = "2";
            $flag = true;
        }
        
        $data['order_price_old'] = $data['order_price'];
        if($side==1){//case for buy
              $percent = ($data['order_price']*100)/$data_itbit['ask'];

              $data['order_price'] = ($percent*$data_itbit['old_ask'])/100;
        }else{
              $percent = ($data['order_price']*100)/$data_itbit['bid'];
              $data['order_price'] = ($percent*$data_itbit['old_bid'])/100;
        }
        // dd($data_itbit,$data,$side);
        if($flag){
            $itbit_api = new itbit(env('CLIENT_ITBIT_CLIENT_SECRET'),env('CLIENT_ITBIT_CLIENT_KEY'),env('CLIENT_ITBIT_USER_ID'));
            $resp = $itbit_api->create_order(env('CLIENT_ITBIT_CLIENT_WALLET_ID'),($side==1?"buy":"sell"), round($data['quantity'],4), round($data['order_price'],2));
            echo "1";
            
            $bank_transactions = $bitcoin_transactions = $order_status = $avg_price = $filled = 0; 
            if(isset($resp))
                {   
                 if($resp->status != "submitted" && $resp->status != "open"){                
                    if($resp->status == "filled"){
                        $bank_transactions = $bitcoin_transactions = $order_status = 1; 

                       $avg_price = $resp->volumeWeightedAveragePrice;
                        $filled = $resp->amountFilled;

                        }else{
                        $bank_transactions = 2;
                        $bitcoin_transactions = 3; 
                        }
                    }
                }

            $itbit_comm =  User::get_perfektpay_meta("itbit_commission");
            $perfektpay_comm =  User::get_commission($user_id);
            //$perfektpay_comm =  User::get_perfektpay_meta("perfektpay_commission");
            $db_new_order = array(
                            "txn_id" => $resp->id,
                            "wallet_id" => $resp->walletId,
                            "user_id" => $user_id,
                            "side" => ($resp->side=="buy"?"1":"2"),
                            "currency" => "XBT",
                            "quantity" => $resp->amount,
                            "limit_price" => $resp->price,
                            "limit_price_actual" => $data['order_price_old'],
                            "remaining" => $resp->amount,
                            "avg_price" => $avg_price>0?$avg_price:$resp->volumeWeightedAveragePrice,
                            "filled" => $filled>0?$filled:$resp->amountFilled,
                            "displayAmount" => $resp->displayAmount,
                            "total_paid" => round($data['total'],2),
                            "perfektpay_comm" => ($resp->side=="buy"?$perfektpay_comm->trading_buy:$perfektpay_comm->trading_sell)."%",
                            "pc_calculated_amount" => (floatval($data['usd_conversion'])*(($resp->side=="buy"?$perfektpay_comm->trading_buy:$perfektpay_comm->trading_sell)/100)),
                            "itbit_comm" => $itbit_comm."%",
                            "itbit_calculated_amount" => (floatval($data['usd_conversion'])*($itbit_comm/100)),
                            "usd_conversion" => $data['usd_conversion'],
                            "instrument" => "XBTUSD",
                            "itbit_orderplaced_at" => $resp->createdTime,
                            "created_by" => $user_id,
                            "updated_by" => $user_id,
                            "status" => $order_status
                        );
            $ref_id = User::create_new_order($db_new_order);

            if($side == 1){
                $bnk_trans = array("ref_id"=>$ref_id,"user_id"=>$user_id,"amount"=>$data['total'],"type"=>2,"remark"=>"Buy XBT(".$data['quantity'].") from USD(".$data['total'].")","created_by"=>$user_id,"status"=>$bank_transactions,"updated_by"=>$user_id);
                $bnk_resp = DB::table('bank_transactions')->insertGetId($bnk_trans); 

                $bit_trans = array("ref_id"=>$ref_id,"user_id"=>$user_id,"type"=>2,"amount"=>$data['quantity'],"status"=>$bitcoin_transactions,"btc_value"=>$this->current_btc_price(1),"exchange"=>"bitfinex","created_by"=>$user_id,"updated_by"=>$user_id,"remark"=>"Buy XBT(".$data['quantity'].") from USD(".$data['total'].")");
                $bit_resp = DB::table('bitcoin_transactions')->insertGetId($bit_trans); 

            }else if($side == 2){
                $bit_trans = array("ref_id"=>$ref_id,"user_id"=>$user_id,"amount"=>$data['quantity'],"status"=>$bitcoin_transactions,"type"=>3,"btc_value"=>$this->current_btc_price(1),"exchange"=>"bitfinex","created_by"=>$user_id,"updated_by"=>$user_id,"remark"=>"Sell XBT(".$data['quantity'].") of USD(".$data['total'].")");
                $bit_resp = DB::table('bitcoin_transactions')->insertGetId($bit_trans); 

                $bnk_trans = array("ref_id"=>$ref_id,"user_id"=>$user_id,"amount"=>$data['total'],"status"=>$bank_transactions,"type"=>3,"remark"=>"Sell XBT(".$data['quantity'].") of USD(".$data['total'].")","created_by"=>$user_id,"updated_by"=>$user_id);
                $bnk_resp = DB::table('bank_transactions')->insertGetId($bnk_trans); 
            }

            if($ref_id){
                Session::flash('message','Order Placed');
                // echo $ref_id;
                // return redirect("trading");    
            }
        }else{
            Session::flash('error','Something went wrong');
            // return redirect("trading");
            echo 0;
        }
    }

    public function check_orders()
    {
        $orders = json_decode(User::get_orders());
        $itbit_api = new itbit(env('CLIENT_ITBIT_CLIENT_SECRET'),env('CLIENT_ITBIT_CLIENT_KEY'),env('CLIENT_ITBIT_USER_ID'));
        if(isset($orders) && !empty($orders)){
            foreach ($orders as $detail) {
                $order_status = $itbit_api->orders(env('CLIENT_ITBIT_CLIENT_WALLET_ID'), $detail->txn_id);
                if($order_status->status != "submitted" && $order_status->status != "open"){
                    User::update_order($order_status,$detail->id);
                    if($order_status->status == "filled"){
                        DB::table('bank_transactions')->where(["ref_id"=>$detail->id])->update(["status"=>1]); 
                        DB::table('bitcoin_transactions')->where(["ref_id"=>$detail->id])->update(["status"=>1]); 
                    }else{
                        DB::table('bank_transactions')->where(["ref_id"=>$detail->id])->update(["status"=>2]); 
                        DB::table('bitcoin_transactions')->where(["ref_id"=>$detail->id])->update(["status"=>3]); 
                    }
                }
            }
        }  
    }


    public function bank_sub(){
        $input = Input::all();
        return User::bank_sub($input);
    }

    public function btc_sub(){
        $input = Input::all();
        return User::btc_sub($input);
    }

    public function cancel_order($txn)
    {
        $txn = Crypt::decrypt($txn); 
        $itbit_api = new itbit(env('CLIENT_ITBIT_CLIENT_SECRET'),env('CLIENT_ITBIT_CLIENT_KEY'),env('CLIENT_ITBIT_USER_ID'));
        $order = $itbit_api->orders(env('CLIENT_ITBIT_CLIENT_WALLET_ID'),$txn);
        
        if(isset($order) && !empty($order) && $order->status == "open"){

            $order_cancel_status = $itbit_api->cancel(env('CLIENT_ITBIT_CLIENT_WALLET_ID'),$txn);

            if(isset($order_cancel_status->description) && !empty($order_cancel_status->description)){
                Session::flash('error',$order_cancel_status->description);

            }else{

                $order_id = DB::table('orders')->where(["txn_id"=>$txn])->first(["id"]);

                DB::table('orders')->where(["id"=>$order_id->id])->update(["status"=>2]); 
                DB::table('bank_transactions')->where(["ref_id"=>$order_id->id])->update(["status"=>2]); 
                DB::table('bitcoin_transactions')->where(["ref_id"=>$order_id->id])->update(["status"=>3]);

                Session::flash('message','The cancellation request has been received and is being processed.');
            }
            return redirect("trading");
        }else{
            Session::flash('error','Sorry!! you cannot cancel this order. This order is '.$order->status." now.");
            return redirect("trading");
        }
    }

    public function addbank()
    {
        $data = Input::all();
        $resp = User::add_bank($data);
        echo $resp;
    }

    public function getbank()
    {
        $bank_id = Input::get("bank_id");
        $resp = User::get_bank(Session::get("user_id"),$bank_id);
        echo $resp;
    }

    public function forgot_password(){
        return View('/forgot_password');
    }

    public function forgot_password_post(){
        $data = Input::all();
        return User::forgot_password_post($data);
    }

    public function updatebank()
    {
        $data = Input::all();
        echo $bank_id = Crypt::decrypt($data['encbnk']);
        if(isset($bank_id) && !empty($bank_id)){
            unset($data['_token']);
            unset($data['encbnk']);
            unset($data['ubank']);
            $resp = User::update_bank($data,$bank_id);
            if($resp){
                Session::flash('message','Bank updated successfully');
            }else{
                Session::flash('error','Something went wrong!!');
            }
            return redirect("settings");
        }
        
    }

    public function deletebank($bid)
    {
        $bank_id = Crypt::decrypt($bid);
        
        $resp = User::delete_bank($bank_id);
        if($resp){
            Session::flash('message','Bank removed successfully');
        }else{
            Session::flash('error','Something went wrong!!');
        }
        return redirect("settings");
    }

public function cron_check_bitcoin_payment()
   {    
       $user_ids = DB::table('bitcoin_transactions')->select('id','user_id',"label","address","status")
                                                   ->where(['type'=>'0'])
                                                   ->where(function ($query) {
                                                        $query->where('status', 0)
                                                              ->orWhere('status',2);  })
                                                   ->get();
       foreach ($user_ids as $key => $val) {
           $this->cron_cal($val);
       }    
   }

   public function cron_cal($bitcoin_add){
           if(isset($bitcoin_add) && !empty($bitcoin_add)){
               $apiKey     = env('BLOCK_IO_API_KEY');
               $pin        = env('BLOCK_IO_PIN');
               $version    = env('BLOCK_IO_VERSION');
               $block_io   = new block_io($apiKey, $pin, $version);
               $data = $block_io->get_transactions(array('type' => 'received', 'addresses' => $bitcoin_add->address));
             
               if(!empty($data->data->txs) && $data->data->txs[0]->confirmations >= 6){
                       $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "6"]);
               }
               elseif (!empty($data->data->txs) && $data->data->txs[0]->confirmations < 6 && $bitcoin_add->status!=2) {
                        $bitcoin_data_id = DB::table('bitcoin_transactions')->where('id',$bitcoin_add->id)->update(['amount'=> $data->data->txs[0]->amounts_received[0]->amount,'status' => "2"]);
                        $user=DB::table('users')->where('id',$bitcoin_add->user_id)->first();
                        User::mail_send($user,3,$data->data->txs[0]->amounts_received[0]->amount);
            }     
           }
   }

   public function market_price()
   {
        $timespan = "";
        if(Input::post("timespan") != ""){
            $timespan = 'timespan='.Input::post("timespan")."&";
        }
        echo file_get_contents('https://api.blockchain.info/charts/market-price?'.$timespan.'format=json');
   }
}
