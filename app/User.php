<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Input;
use App\welcome;
use Carbon\Carbon;
use Response;
use DB;
use Hash;
use AWS;
use Validator;
use Mail;
use Crypt;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /** 
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $signup_rule = array(
                                    'username' => 'required|unique:users|min:5|max:12|regex:/^[a-z0-9]+$/',
                                    'email'     => 'required|unique:users',
                                    'password'  => 'required|confirmed|min:6'
    );

    public static $vale_email_rule = array(
                                    'email'     => 'required|unique:users'
    );
    public static $username_rule = array(
                                    'username'     => 'required|unique:users|min:5|max:12|regex:/^[a-z0-9]+$/'
    );

    public static $add_bank_rule = array(
                                    'bank_name'     => 'required',
                                    'beneficiary_name'     => 'required',
                                    'beneficiary_account_no'     => 'required|numeric',
                                    'swift_code'     => 'required',
    );
    public static $forgot_password_post_rule = array(
        'email'    => 'required|email|exists:users,email',
); 
    public static $reset_password_post_rule = array(
'token'=>'required|exists:users,forgotpass_token',
'password'=>'required|min:6|confirmed',
'password_confirmation'=>'required|min:6',
    );

    public static $contact_us_p_rule = array(
    'name'        => 'required',
    'email'       => 'required|email',
    'ph_num'      => 'required|numeric',
    'nature_inq'  => 'required',
    'subject'     => 'required',
    'message'     => 'required',
    );


    public static function validateemail($data){
        $rules      = user::$vale_email_rule;
        $validation = validator::make($data,$rules);
        if($validation->passes()){
            return Response::json(array('valid' => 'true'));
        }else{
            return Response::json(array('valid' => 'false'));
        } 
    }

    public static function signuppost($data){
        $rules      = user::$signup_rule;
        $validation = validator::make($data,$rules);       
        $token=str_random(50);
        if($validation->passes()){
            $signup = DB::table('users')->insertGetId(array(
                                                            'username' => $data['username'],
                                                            'email'      => $data['email'],
                                                            'password'   => Hash::make($data['password']),
                                                            'encrypted'=> $data['password'], 
                                                            'remember_token' => $token
                                                            )); 

            $link = env('USER_CONFIRM_URL').'/confirm/'.$token; 
            $mail = Mail::send('emails.registration_mail',array('name'=>$data['username'],'link'=>$link),function($message) use ($data){ $message->to($data['email'], $data['username'])->subject('PerfektPay Registration Verification');
                             });

            return array('success'=>1, 'msg'=>"Step 1 completed, Please click on the link sent to your email address, to verify your account");
        }else{
            return array('success'=>0, 'msg'=> $validation->getMessageBag()->first());
        }  
    } 

    public static function mail_send($data,$type,$amount=0){
       
       if($type==1)//login
       {
        $mail = Mail::send('emails.login_confirm',array('name'=>$data->username),function($message) use ($data){ $message->to($data->email, $data->username)->subject('PerfektPay login attempt');
                             });
        }
        elseif ($type==2) {//login fail
            $mail = Mail::send('emails.login_fail',array('name'=>$data),function($message) use ($data){ $message->to($data->email, $data->username)->subject('Failed login notification '.date("Y-m-d h:i"));
                             });
        }
        elseif ($type==3) {
            $mail = Mail::send('emails.bitcoin_receiv',array('name'=>$data,'amount'=>$amount),function($message) use ($data){ $message->to($data->email, $data->username)->subject('Your bitcoin deposit was received');
        });
        }
        elseif ($type==4) {
              $mail = Mail::send('emails.usd_withdrawal',array('name'=>$data),function($message) use ($data){ $message->to($data->email, $data->username)->subject('Your USD withdrawal request was received');
        });
        }
        elseif ($type==5) {
              $mail = Mail::send('emails.btc_withdrawal',array('name'=>$data),function($message) use ($data){ $message->to($data->email, $data->username)->subject('Your BTC withdrawal request was received');
        });  
        }
        elseif ($type==6) {
              $mail = Mail::send('emails.kyc_request_recived',array('name'=>$data),function($message) use ($data){ $message->to($data->email, $data->username)->subject('Verification Received');
        });  
        }

    }


    public static function loginpost($data){ 
        if(isset($data)){
            $check = DB::table('users')->where('email',$data['login'])->orWhere('username',$data['login'])->first();   
            if(isset($check)){
                $check_data = Hash::Check($data['password'],$check->password); 
                if($check_data){
                    if($check->is_email == '1' && $check->status == '1' ){
                        User::mail_send($check,1);
                        if($check->UDF == '0'){
                            session(['signedUp_user' => $check->id]);
                            return array('success'=>1,'id'=>$check->id);  
                        }else if($check->KYCF == '0' && $check->KYCF_skip =='0'){  
                            $country = DB::table('countries')->where('id',$check->country)->first(["name"]);
                            $noti="0";
                            $noti2 ="0";
                            session(['user_id' => $check->id,'country'=>$country->name,'noti'=>$noti,"noti2"=>$noti2]);
                            return array('success'=>2);
                        }else{
                            Session::forget('country');
                            if(session::has('user_id')){
                                return array('success'=>3);   
                            }else{
                                $noti="0";
                            $noti2 ="0";
                                session(['user_id' => $check->id,'noti'=>$noti,"noti2"=>$noti2]);
                                return array('success'=>3);  
                            }
                        }
                    }else{
                        return array('success'=>0, 'msg'=>'Email not verified.');
                    }
                }else{
                    User::mail_send($check,2);
                    return array('success'=>0, 'msg'=>'Wrong password. Try again!');
                }
            }else{
                
                return array('success'=>0, 'msg'=>'Wrong password. Try again!');
            }    
        }
    } 

    public static function confirmUser($rem_token){
        if(isset($rem_token) && !empty($rem_token)){
            $check = DB::table('users')->where(['remember_token'=>$rem_token,'is_email'=>'0'])->first(['id']);
            if(isset($check)){                 
                $user_update = DB::table('users')->where('id',$check->id)->update(['is_email'=>'1','status'=>'1']);
                if(isset($user_update)){
                    session(['signedUp_user' => $check->id]);
                    return array('success'=>1);
                }else{
                    return array('success'=>404);
                }                                                  
            }else{
                return array('success'=>0);
            }                                        
        }
    }

    public static function total_bitcoin($user_id){
        if(isset($user_id) && !empty($user_id)){
            $bitcoin_transactions = DB::select("SELECT 
                                                    @total_deposit := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = ".$user_id." AND status = 1),0) as total_deposit,
                                                    @total_withdrawal := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = ".$user_id." AND (status = 5 or status = 1)),0) as total_withdrawal,
                                                    @total_spent := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = ".$user_id." AND (status = 1 OR status=2 OR status=0)),0) as total_spent,
                                                    IFNULL((@total_deposit - (@total_withdrawal + @total_spent)),0) as total_btc");
            if(isset($bitcoin_transactions)){ 
                return $bitcoin_transactions;               
            }                                        
        }
    }


    public static function balance_bitcoin($user_id){
        if(isset($user_id) && !empty($user_id)){
            $bitcoin_transactions = DB::select("SELECT 
                                                    @total_deposit := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = ".$user_id." AND status = 1),0) as total_deposit,
                                                    @total_withdrawal := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = ".$user_id." AND (status = 5 or status = 1)),0) as total_withdrawal,
                                                    @total_spent := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = ".$user_id." AND (status = 1 )),0) as total_spent,
                                                    IFNULL((@total_deposit - (@total_withdrawal + @total_spent)),0) as balance_btc");
            if(isset($bitcoin_transactions)){ 
                return $bitcoin_transactions;               
            }                                        
        }
    }

    public static function total_usd($user_id){
        if(isset($user_id) && !empty($user_id)){
            $bank_transactions = DB::select("SELECT 
                                                    @total_deposit := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = ".$user_id." AND status = 1 ),0) as total_deposit,
                                                    @total_withdrawal := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = ".$user_id." AND (status = 5 or status = 1) ),0) as total_withdrawal,
                                                    @total_spent := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = ".$user_id." AND (status=0 OR status=1)),0) as total_spent,
                                                    IFNULL((@total_deposit - (@total_withdrawal + @total_spent)),0) as total_usd");
            if(isset($bank_transactions)){ 
                return $bank_transactions;               
            }                                         
        }
    }

    public static function balance_usd($user_id){
      if(isset($user_id) && !empty($user_id)){
            $bank_transactions = DB::select("SELECT 
                                                    @total_deposit := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = ".$user_id." AND status = 1 ),0) as total_deposit,
                                                    @total_withdrawal := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = ".$user_id." AND (status = 5 or status = 1) ),0) as total_withdrawal,
                                                    @total_spent := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = ".$user_id." AND (status=1)),0) as total_spent,
                                                    IFNULL((@total_deposit - (@total_withdrawal + @total_spent)),0) as balance_usd");
            if(isset($bank_transactions)){ 
                return $bank_transactions;               
            }                                         
        }
    }

    public static function userdetails($data){

        if(isset($data)){
            $check = DB::table('users')->where('id',$data['id'])->first(['username','email','UDF']);
            if(isset($check)){
                if($check->UDF=='0'){
                    $dob = date("Y-m-d", strtotime($data['dob']));
                    $last_name = !empty($data['last_name'])?$data['last_name']:"";
                    $update_user = DB::table('users')->where('id',$data['id'])
                                                    ->update(['first_name'=>$data['first_name'],'last_name'=>$last_name,'dob'=>$dob,'address'=>$data['address'],'city'=>$data['city'],'state'=>$data['state'],'country'=>$data['country'],'zip_code'=>$data['zipcode'],'mobile_no'=>$data['mobileNo'],'country_code'=>$data['country_code'],'UDF'=>'1']);

                    if($update_user){
                        $link = env('USER_CONFIRM_URL').'/login'; 
                        $mail = Mail::send('emails.welcome_mail',array('name'=>$check->username,'link'=>$link),function($message) use ($check){ $message->to($check->email,$check->username)->subject('Your PerfektPay Registration is Successful');
                             });
                        Session::forget('signedUp_user');
                        return array('success'=>1);
                    }else{
                        return array('success'=>404);
                    }
                }else if($check->UDF=='1'){                    
                    return array('success'=>1);
                }
            }else{
                return array('success'=>404);
            }
        }else{
             return array('success'=>404);
        }
    }


    public static function kyc_data($user_id,$filename,$kyc_name,$chko){
        $check_exist = DB::table('user_kyc_details')->where(["user_id"=>$user_id,'kyc_name'=>$kyc_name])->first(['image_id']);

        if(isset($check_exist) && !empty($check_exist)){
            $data = DB::table('images')->where('id',$check_exist->image_id)->update(['image'=>$filename,'modified_by'=>$user_id]);
        }else{
            $image_id = DB::table('images')->insertGetId(array('image'=>$filename,'created_by'=>$user_id,'modified_by'=>$user_id));             
            $data = DB::table('user_kyc_details')->insertGetId(array(
                                                            'user_id' => $user_id,
                                                            'kyc_name'   => $kyc_name,
                                                            'image_id'     => $image_id,                                        
                                                            'created_by'     => $user_id,                                        
                                                            'modified_by'     => $user_id,                                        
                                                            ));             
        } 


        if(isset($data)){    
            if($chko==1){      
                $datachk= DB::table('users')->where('id',$user_id)->first();
                User::mail_send($datachk,6);
            }
            return array('success'=>1);
        }     
        
    }

    public static function dep_bank_trans($user_id,$amount,$filename){        
        $image_id = DB::table('images')->insertGetId(array('image'=>$filename,'created_by'=>$user_id,'modified_by'=>$user_id));             
        $data = DB::table('bank_transactions')->insertGetId(array(
                                                        'user_id' => $user_id,
                                                        'amount'   => $amount,
                                                        'receipt'     => $image_id,                               
                                                        'created_by'     => $user_id,                                        
                                                        'updated_by'     => $user_id,                                        
                                                        ));             
        
        if(isset($data)){
            return array('success'=>1);
        }     
        
    }

    public static function checkusername($username){
        $rules      = user::$username_rule;
        $validation = validator::make($username,$rules);
        if($validation->passes()){
            return 1;
        }else{
            return 0;
        }
    }

   public static function user_authent($data){
        if(isset($data)){
            $update_user = DB::table('users')->where('id',$data)
                                            ->update(['KYCF_skip'=>'1']);
            if(isset($update_user)){
                return array('success'=>1);
            }else{
                 return array('success'=>404);
            } 
        }
    }

    public static function user_authenticat($data){
        if(isset($data)){
            $update_user = DB::table('users')->where('id',$data)
                                            ->update(['KYCF'=>'1','KYCF_skip'=>'0']);
            if(isset($update_user)){
                // session(['kycf' => 1]);
                return array('success'=>1);
            }else{
                 return array('success'=>404);
            } 
        }
    }


   public static function user_authent_skip($data){
        if(isset($data)){

            $update_user = DB::table('users')->where('id',$data)
                                            ->update(['AUTH_skip'=>'1']);
            if(isset($update_user)){
                return array('success'=>1);
            }else{
                 return array('success'=>404);
            } 
        }
    }

    public static function cancel_with($id){
        $user_id = Session::get("user_id");
        return $userdata = DB::table('bank_transactions')->where('id',base64_decode($id['id']))
                                                         ->update(['withdrawal_status'=>3,'updated_by'=>$user_id]);
    }

    public static function funding_history($user_id="",$page=""){
        if(isset($user_id) && !empty($user_id)){
            $first = DB::table('bitcoin_transactions')->select("id", DB::raw('("BTC") as currency'),'address','user_id',"withdrawal_status","amount","created_by", "updated_at as created_at","status","type")            
                    ->where(['user_id'=>$user_id])->where(function ($query) {
                            $query->where('status', 1)
                                  ->orWhere('status',5); 
                        })->where(function ($query) {
                            $query->where('type', 0)
                                  ->orWhere('type', 1)
                                  ->orWhere('type',4);
                        });

                     
     
            return $data = DB::table('bank_transactions')
                ->select("id",DB::raw('("USD") as currency'),DB::raw('(select bank_name from bank_details where bank_details.id= bank_address)as address'),'user_id',"withdrawal_status" ,"amount",'created_by', "updated_at as created_at","status","type")
                ->union($first)
                ->where(['user_id'=>$user_id])->where(function ($query) {
                            $query->where('status', 1)
                                  ->orWhere('status',5); 
                        })->where(function ($query) {
                            $query->where('type', 0)
                                  ->orWhere('type', 1)
                                  ->orWhere('type',4); 
                        })
                ->orderBy('created_at','desc')
                ->get();
        }else{
             $first = DB::table('bitcoin_transactions')->select("id", DB::raw('("Bitcoin") as currency'),'address','user_id',"withdrawal_status","amount","created_by", "updated_at as created_at","status","type")            
                    ->where(function ($query) {
                            $query->where('status', 1)
                                  ->orWhere('status',5); 
                        })->where(function ($query) {
                            $query->where('type', 0)
                                  ->orWhere('type', 1);
                        });

                     
     
            return $data = DB::table('bank_transactions')
                ->select("id",DB::raw('("US Dollars") as currency'),DB::raw('(select bank_name from bank_details where bank_details.id= bank_address)as address'),'user_id',"withdrawal_status" ,"amount","created_by", "updated_at as created_at","status","type")
                ->union($first)
                ->where(['status'=>1,'created_by'=>0])->where(function ($query) {
                            $query->where('type', 0)
                                  ->orWhere('type', 1);
                        })
                ->orderBy('created_at','desc')
                ->get();
        }
    }

    public static function skipped_notification($user_id){
        $where = ['id'=>$user_id];  
        return $data = DB::table('users')
            ->where($where)
            ->first([DB::raw('(CASE WHEN KYCF_skip = 1 THEN 1 ELSE 0 END) as kyc_skipped'), DB::raw('(CASE WHEN AUTH_skip = 1 THEN 1 ELSE 0 END) as auth_skipped')]);
    }
    public static function profile($user_id){
      return   $userData = DB::table('users as u')
                               ->leftJoin('user_kyc_details as uk','uk.user_id','=','u.id')
                               ->leftJoin('images as img','img.id','=','uk.image_id')
                               ->where(['u.role'=>2,'u.id'=>$user_id])
                               ->get(['u.id as user_id','u.username',DB::raw("(case when (AUTH_skip=1 AND is_gAuth=0 AND G_AUTH =0) then '0' else '1' end )as g_auth_flag"),'u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.address','u.city','u.state','zip_code','country_code','u.country','u.created_at','uk.kyc_name','uk.id as kyc_id','uk.status','img.image',]);
   }
    public static function update_profile($data){
        $user_id = Crypt::decrypt($data['enc_id']);
        unset($data['_token']);
        unset($data['enc_id']);
        unset($data['submit']);
        unset($data['profile']);
        unset($data['settings']);
        $update_user = DB::table('users')->where('id',$user_id)->update($data);
        if(isset($update_user)){
            return array('success'=>1);
        }else{
             return array('success'=>404);
        } 
    }

    public static function get_perfektpay_meta($meta_key){
        $data = DB::table('perfektpay_meta')->where(["meta_key"=>$meta_key])->first(["meta_value"]);  
        return  $data->meta_value;
    }

    public static function get_commission($user_id){
        $data = DB::table('users')->select('trading_sell','trading_buy')->where('id',$user_id)->first();  
        return  $data;
    }

    public static function create_new_order($data){
        return $data = DB::table('orders')->insertGetId($data); 
    }

    public static function get_orders($user_id="",$page="",$type=0){
        if(isset($user_id) && !empty($user_id)){
            if(isset($page) && !empty($page) && $page == "trading"){
                return $data = DB::table('orders')->where(["user_id"=>$user_id])->orderBy('id','desc')->limit(5)->get(); 
            }elseif (isset($page) && !empty($page) && $page == "trading_history_down") {
                if($type!=0){
                    return $data = DB::table('orders')->where("user_id",$user_id)->WhereRaw("created_at BETWEEN '".date_format(date_create($type['start_d']),"Y/m/d H:i:s")."' AND '".date_format(date_create($type['end_d']),"Y/m/d H:i:s")."'")->where("status","1")->orderBy('id','desc')->get();      
                }
                return $data = DB::table('orders')->where(["user_id"=>$user_id])->where("status","1")->orderBy('id','desc')->get();
            }
            else{
                if($type!=0){
                    return $data = DB::table('orders')->where("user_id",$user_id)->WhereRaw("created_at BETWEEN '".date_format(date_create($type['start_d']),"Y/m/d H:i:s")."' AND '".date_format(date_create($type['end_d']),"Y/m/d H:i:s")."'")->where("status","1")->orderBy('id','desc')->paginate(10);      
                }
                return $data = DB::table('orders')->where(["user_id"=>$user_id])->where("status","1")->orderBy('id','desc')->paginate(10); 
            
            }
        }else{
            return $data = DB::table('orders')->where(["status"=>0])->orderBy('id','desc')->get(); 
        }
    }

    public static function update_order($data,$id){
        if($data->status == "filled"){
            $status = 1;
        }else{$status = 2;}
        $update = array(
                        "avg_price"=>$data->volumeWeightedAveragePrice,
                        "filled"=>$data->amountFilled,
                        "status"=>$status
                    );
        return $data = DB::table('orders')->where(["id"=>$id])->update($update);         
    }

    public static function check_rejected($user_id){
        $data = DB::table('user_kyc_details')->where(["user_id"=>$user_id,"status"=>2])->get(["kyc_name"]); 
        if(isset($data) && !empty($data)){
            return $data;
        }else{
            return false;
        } 
    }

    public static function get_bank($user_id,$bank_id=""){
        if(isset($bank_id) && !empty($bank_id)){
            return $data = json_encode(DB::table('bank_details')->where('flag',0)->where(["user_id"=>$user_id,"id"=>$bank_id])->first()); 
        }else{
            return $data = json_decode(DB::table('bank_details')->where('flag',0)->where(["user_id"=>$user_id])->orderBy('id','desc')->get(["id","bank_name","beneficiary_name","beneficiary_account_no","swift_code"]),true); 
        }
    }
    public static function add_bank($data){
        $rules      = user::$add_bank_rule;
        $validation = validator::make($data,$rules);
        if($validation->passes()){
            unset($data['_token']);
            unset($data['bank']);
            $user_id = Session::get("user_id");
            $data["user_id"] = $user_id;
            $data["created_by"] = $user_id;
            $data["updated_by"] = $user_id;
            $bank_det_id = DB::table('bank_details')->insertGetId($data);
            return json_encode(array("id"=>$bank_det_id,"bank_name"=>$data['bank_name'])); 
        }else{
            return 'false';
        } 
    }

    public static function delete_bank($bank_id)
    {
        return DB::table('bank_details')->where('id',$bank_id)->update(["flag"=>1]);
    }
    public static function update_bank($data,$bank_id)
    {
        return $data = DB::table('bank_details')->where(["id"=>$bank_id])->update($data);
    }

    public static function check_checked($user_id){
        try{
          $data = DB::table('users')->where('id',$user_id)->WhereRaw('AUTH_skip=1 AND is_gAuth=0 AND G_AUTH =0')->first();
          if($data){
            return array('success'=>1,'msg'=>'Please add auth');
          }           
          return array('success'=>0,'msg'=>'allreay added auth');
        }
    catch(\Exception $e) {
            return array('success' => 0, 'msg' => $e->getMessage());
        }
    }
public static function check_unchecked($user_id){
        try{
          $data = DB::table('users')->where('id',$user_id)->update(['AUTH_skip'=>1 , 'is_gAuth'=>0 , 'G_AUTH' =>0]);
          if($data){
            return array('success'=>1,'msg'=>'Google auth added');
          }           
          return array('success'=>0,'msg'=>'allreay added auth');
        }
    catch(\Exception $e) {
            return array('success' => 0, 'msg' => $e->getMessage());
        }
    }

    public static function forgot_password_post($data){
    try{
        $rules = User::$forgot_password_post_rule;
          $validation = validator::make($data,$rules);
          if($validation->passes())
          {
             $check = DB::table('users')->where('email',$data['email'])->select('username')->first();
             $data['username'] = $check->username;
              $forgettoken=str_random(50);
            DB::table('users')->where('email',$data['email'])->update(array(
                                    'forgotpass_token'=>$forgettoken,
                                    'updated_at'    =>Carbon::now() 
                                    )); 
            $link = env('USER_CONFIRM_URL').'/forgot_pass/'.$forgettoken; 
            

            $mail = Mail::send('emails.forgot_mail',array('name'=>$data['username'],'link'=>$link),function($message) use ($data){ $message->to($data['email'], $data['username'])->subject('Forgot Password Mail');
                             });
            Session::flash('message','Reset link sent to your email');
            return back();//array('success' => 1, 'msg'=>'msg send successfully');

          }
          else
          {
            Session::flash('error',$validation->getMessageBag()->first());
            return back();
              //return array('success' => 0, 'msg'=> $validation->getMessageBag()->first());
          }
    }
    catch(\Illuminate\Databas\QueryException $e) {
             Session::flash('error', $e->getMessage());
            return back();
            //return array('success' => 0, 'msg' => $e->getMessage());
        }
 }

public static function adminmatchtoken($data)  
 {  
    try{
          $check = DB::table('users')->where('forgotpass_token',$data)->first();
          if(isset($check)){
            return 1;
          }
          return 0;
        }
    catch(\Illuminate\Databas\QueryException $e) {
            return Response::json(array('success' => 0, 'msg' => $e->getMessage()),200);
        }
 }

public static function reset_password_post($data)  
 {  
    try{
          $rules = User::$reset_password_post_rule;
          $validation = validator::make($data,$rules);
          if($validation->passes())
          {
            $check =DB::table('users')->where('forgotpass_token',$data['token'])
                                      ->update(['password' => Hash:: make( $data['password']),'encrypted'=>$data['password'], 'forgotpass_token' =>'' , 'updated_at'=> Carbon::now() ]);             
            return array('success' => 1);
          }
          else
          {
              return array('success' => 0, 'msg'=> $validation->getMessageBag()->first());
          }
          return 1;
        }
    catch(\Illuminate\Databas\QueryException $e) {
            return array('success' => 0, 'msg' => $e->getMessage());
        }
 }

public static function contact_us_p($data)  
 {  
    try{
          $rules = User::$contact_us_p_rule;
          $validation = validator::make($data,$rules);
          if($validation->passes())
          {
            
            $user_update = DB::table('contact_us')->insertGetId(['name'     => $data['name'],
                                                                        'email'    => $data['email'],
                                                                        'phn_no'   => $data['ph_num'],
                                                                        'inquiry'  => $data['nature_inq'],
                                                                        'subject'  => $data['subject'],
                                                                        'message'  => $data['message'],
                                                                                 ]);

           $mail = Mail::send('emails.contact_mail',array('data'=>$data),function($message){ $message->to('support@perfektpay.com','admin')->subject('Contact Mail');
                             });  
                 Session::flash('message','mail sent');
            return back();                        
           
          }
          else
          {
              Session::flash('error',$validation->getMessageBag()->first());
            return back();
        }
    }
    catch(\Exception $e) {
        //Session::flash('error',$e->getMessage());
        Session::flash('error','Server not responding please try again later');
            return back();
        }
 }

 public static function check_per($user_id){
    try{
          return DB::table('users')->where('id',$user_id)->first();
        }
    catch(\Exception $e) {
        //Session::flash('error',$e->getMessage());
        Session::flash('error','Server not responding please try again later');
            return back();
        }
 }

 public static function bank_sub($data){
    try{
        $user_id = Session::get("user_id");
        $user_update = DB::table('bank_transactions')->insertGetId(['user_id'            => $user_id,
                                                               'status'             => '5',
                                                               'amount'             => $data['amount'],
                                                               'type'               => '4',
                                                               'withdrawal_status'  => 1,
                                                               'bank_address'       => $data['bank_id'],
                                                               'created_by'         => $user_id,

                                                                                 ]);
        Session::flash('message','Withrawal request submitted');
        $data12= DB::table('users')->where('id',$user_id)->first();
        $data12->amount=$data['amount'];
        // dd($data12->email);
        User::mail_send($data12,4);
          return 1;
        }
    catch(\Exception $e) {
        //Session::flash('error',$e->getMessage());
        Session::flash('error','Server not responding please try again later');
            return back();
        }
 }

 public static function btc_sub($data){
    try{

        $user_id = Session::get("user_id");
        $user_update = DB::table('bitcoin_transactions')->insertGetId(['user_id'            => $user_id,
                                                                       'status'             => '5',
                                                                       'amount'             => $data['amount'],
                                                                       'type'               => '4',
                                                                       'withdrawal_status'  => 1,
                                                                       'address'            => $data['bct_add'],
                                                                       'created_by'         => $user_id,

                                                                                 ]);
        Session::flash('message','Withrawal request submitted');
        $data12= DB::table('users')->where('id',$user_id)->first();
        $data12->amount=$data['amount'];
        $data12->address=$data['bct_add'];
        // dd($data12->email);
        User::mail_send($data12,5);
          return 1;
        }
    catch(\Illuminate\Databas\QueryException $e) {
        //Session::flash('error',$e->getMessage());
        dd($e->getMessage());
        Session::flash('error','Server not responding please try again later');
            return back();
        }
 }

}
