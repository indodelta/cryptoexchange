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

class Admin extends Model
{
	public static function loginprocess($data){
 		if(isset($data)){
            $check = DB::table('admin')->where('email',$data['email'])->first(); 
            if(isset($check)){
                $check_data = Hash::Check($data['password'],$check->password); 
                if($check_data){
                    if($check->status == '1'){   
                        Session::push('id',$check->id);  
                        Session::push('email',$check->email);                       
                    	return array('success'=>1);            
                    }else{
                         return array('success'=>0);
                    }
                }else{
                    return array('success'=>0);
                }
            }else{
                return array('success'=>0);
            }    
        }else{
        	return array('success'=>0);
        }
	}

    public static function fetchUserManagementList(){
        return $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname',DB::raw('IF((select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id),"1","0") as kyc_img'),DB::raw("(SELECT   IFNULL(IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = u.id AND status = 1 ),0) -(
                                                    IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1) ),0) +
                                                     IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = u.id AND (status=0 OR status=1)),0)),0))as total_usd"),DB::raw("(SELECT IFNULL(IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = u.id AND status = 1),0) -
                                                   (IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1)),0) +
                                                    IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = u.id AND (status = 1 OR status=2 OR status=0)),0)),0) )as total_btc"))
                                    ->where('u.role',2)  
                                    ->orderBy('u.created_at','DESC')
                                    ->paginate(10);

    }

    public static function fetchUserManagementSearchResult($data){
        if($data['column']=='activate'||$data['column']=='deactivate'||$data['column']=='kyc_pending'){

            return $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname',DB::raw('IF((select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id),"1","0") as kyc_img'),DB::raw("(SELECT   IFNULL(IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = u.id AND status = 1 ),0) -(
                                                    IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1) ),0) +
                                                     IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = u.id AND (status=0 OR status=1)),0)),0))as total_usd"),DB::raw("(SELECT IFNULL(IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = u.id AND status = 1),0) -
                                                   (IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1)),0) +
                                                    IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = u.id AND (status = 1 OR status=2 OR status=0)),0)),0) )as total_btc"))
                                    ->where('u.role',2)
                                    ->whereRaw(($data['column']!='kyc_pending'?("status=".($data['column']=='activate'?'1':'0')):"user_kyc_status=0 and (select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id)>=1"))
                                    ->orderBy('u.created_at','DESC')
                                    ->paginate(10); 
        }
        return  $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname',DB::raw('IF((select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id),"1","0") as kyc_img'),DB::raw("(SELECT   IFNULL(IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = u.id AND status = 1 ),0) -(
                                                    IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1) ),0) +
                                                     IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = u.id AND (status=0 OR status=1)),0)),0))as total_usd"),DB::raw("(SELECT IFNULL(IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = u.id AND status = 1),0) -
                                                   (IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1)),0) +
                                                    IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = u.id AND (status = 1 OR status=2 OR status=0)),0)),0) )as total_btc"))
                                    ->where('u.role',2)
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->orderBy('u.created_at','DESC')
                                    ->paginate(10);                           
    }

   public static function fetchManageUserData($userId){
       return   $userData = DB::table('users as u')
                                ->leftJoin('user_kyc_details as uk','uk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','uk.image_id')
                                ->where(['u.role'=>2,'u.id'=>$userId])
                                ->get(['u.id','u.username','u.first_name','u.last_name','u.dob','u.email','u.country_code','u.mobile_no','u.address','u.city','u.state','zip_code','u.country_code','u.country','u.created_at','uk.kyc_name','uk.id as kyc_id','uk.status','img.image',]);
    }    


    public static function updateUserinfo($data){
        return $user_update = DB::table('users')->where('id',$data['id'])
                                         ->update(['first_name'=>$data['first_name'],'last_name'=>$data['last_name'],'mobile_no'=>$data['mobile_no'],'address'=>$data['address'],'city'=>$data['city'],'state'=>$data['state'],'country'=>$data['country'],'zip_code'=>$data['zip_code'],'updated_by'=>$data['updated_by']]);
    }


    public static function updateUserkycinfo($data){
       //dd($data);
        if(isset($data['nationradio'])){
            $user_update = DB::table('user_kyc_details')->where(['user_id'=>$data['id'],'id'=>$data['nation_kyc_id']])
                                            ->update(['status'=> $data['nationradio'],'modified_by' =>0]);
        }
        if(isset($data['addradio'])){
            $user_update1 = DB::table('user_kyc_details')->where(['user_id'=>$data['id'],'id'=>$data['address_kyc_id']])
                                            ->update(['status'=> $data['addradio'],'modified_by' =>0]);
        }

        if($data['addradio']==1 && $data['nationradio']==1){
            $user_update = DB::table('users')->where(['id'=>$data['id']])
                                            ->update(['user_kyc_status'=> 1]);
            $user_da =  DB::table('users')->where(['id'=>$data['id']])->first();                         
           $mail = Mail::send('admin.email.account_verified',array('name'=>$user_da),function($message) use ($user_da){ $message->to($user_da->email, $user_da->username)->subject('Your PerfektPay account has been verified for trading');
                             });                                 
        }
        if($data['addradio']!=$data['nationradio']){
            $user_update = DB::table('users')->where(['id'=>$data['id']])
                                            ->update(['user_kyc_status'=> 2]);
        }
        return 1;     
    }

    public static function updateUserStatus($data){
        if(isset($data)){
            $user_status = DB::table($data['tbl'])->where(['id'=>$data['id']])
                                            ->update(['status'=> $data['status']]);
            return $user_status;      
        }
    }


    public static function bankTransactionList(){ 
            //All data
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })                                
                                ->orderBy('bk.created_at','DESC')      
                                ->paginate(10); 
    }

    public static function searchBankTransactionList($data){ 
        if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] !='' && $data['column'] !=''){    
            //with date + param 
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->where('bk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('bk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('bk.created_at','DESC')      
                                ->paginate(10); 
         
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['param'] !='' && $data['column'] !=''){
            //only param 
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->orderBy('bk.created_at','DESC')      
                                ->paginate(10);   

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] =='' && $data['column'] ==''){
            //only date
             return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->where('bk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('bk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('bk.created_at','DESC')      
                                ->paginate(10);  
        }                        
    }   

    public static function searchuserListExcel($data){
         if($data['column']=='activate'||$data['column']=='deactivate'||$data['column']=='kyc_pending'){

            return $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname',DB::raw('IF((select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id),"1","0") as kyc_img'),DB::raw("(SELECT   IFNULL(IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = u.id AND status = 1 ),0) -(
                                                    IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1) ),0) +
                                                     IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = u.id AND (status=0 OR status=1)),0)),0))as total_usd"),DB::raw("(SELECT IFNULL(IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = u.id AND status = 1),0) -
                                                   (IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1)),0) +
                                                    IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = u.id AND (status = 1 OR status=2 OR status=0)),0)),0) )as total_btc"))
                                    ->where('u.role',2)
                                    ->whereRaw(($data['column']!='kyc_pending'?("status=".($data['column']=='activate'?'1':'0')):"user_kyc_status=0 and (select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id)>=1"))
                                    ->orderBy('u.created_at','DESC')
                                    ->get(); 
        }elseif ($data['column']==''&&$data['param']=='') {
            return $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname',DB::raw('IF((select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id),"1","0") as kyc_img'),DB::raw("(SELECT   IFNULL(IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = u.id AND status = 1 ),0) -(
                                                    IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1) ),0) +
                                                     IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = u.id AND (status=0 OR status=1)),0)),0))as total_usd"),DB::raw("(SELECT IFNULL(IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = u.id AND status = 1),0) -
                                                   (IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1)),0) +
                                                    IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = u.id AND (status = 1 OR status=2 OR status=0)),0)),0) )as total_btc"))
                                    ->where('u.role',2)  
                                    ->orderBy('u.created_at','DESC')
                                    ->get();
        }
        return  $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname',DB::raw('IF((select count(ukd.id) from user_kyc_details as ukd where ukd.user_id = u.id),"1","0") as kyc_img'),DB::raw("(SELECT   IFNULL(IFNULL((SELECT sum(amount) FROM bank_transactions WHERE ((type=0 AND created_by=0)or(type=3)) AND user_id = u.id AND status = 1 ),0) -(
                                                    IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1) ),0) +
                                                     IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = u.id AND (status=0 OR status=1)),0)),0))as total_usd"),DB::raw("(SELECT IFNULL(IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=2) AND user_id = u.id AND status = 1),0) -
                                                   (IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=4 or type = 1) AND withdrawal_status !=3 AND user_id = u.id AND (status = 5 or status = 1)),0) +
                                                    IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE type=3 AND user_id = u.id AND (status = 1 OR status=2 OR status=0)),0)),0) )as total_btc"))
                                    ->where('u.role',2)
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->orderBy('u.created_at','DESC')
                                    ->get(); 
    } 

    public static function searchBankTransactionListExcel($data){ 
        if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] !='' && $data['column'] !=''){    
            //with date + param 
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->where('bk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('bk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('bk.created_at','DESC')->get();;
         
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['param'] !='' && $data['column'] !=''){
            //only param
            return  $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->orderBy('bk.created_at','DESC')->get(); 

 

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] =='' && $data['column'] ==''){
            //only date
             return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->where('bk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('bk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('bk.created_at','DESC')->get(); 
        }else{
            //All data
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','bk.amount','bk.id as transactionsId','bk.status','bk.created_at','img.image as recepit')
                                ->leftJoin('bank_transactions as bk','bk.user_id','=','u.id')
                                ->leftJoin('images as img','img.id','=','bk.receipt')
                                ->where(['bk.ref_id'=>0,'bk.type'=>0])
                                ->where(function ($query) {
                                               $query->where('bk.status', 0)
                                                     ->orWhere('bk.status', 3);
                                           })
                                ->orderBy('bk.created_at','DESC')->get();  
        }                        
    }

    public static function updateUserActionStatus($data){
        if(isset($data)){
            $user_status = DB::table('bank_transactions')->where(['id'=>$data['id']])
                                            ->update(['status'=> 3,'updated_by'=> 0]);
            return $user_status;      
        }
    }
    public static function updateUserActionStatus_bit($data){
        if(isset($data)){
            $user_status = DB::table('bitcoin_transactions')->where(['id'=>$data['id']])
                                            ->update(['status'=> 1,'updated_by'=> 0]);
            return $user_status;      
        }
    }


    public static function manageDeposits(){ 
        $query1 = DB::table('bitcoin_transactions as btc') 
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')  
                                ->join('users as u','u.id','=','btc.user_id');

        return $userData = DB::table('bank_transactions as bnk')
                                ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                ->join('users as u','u.id','=','bnk.user_id')
                                ->leftJoin('images as img','img.id','=','bnk.receipt')
                                ->union($query1)
                                ->orderBy('created_at','DESC') 
                                ->get();
   }   



    public static function searchManageDepositsList($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            if($data['type'] == 1){
                return $userData = DB::table('bitcoin_transactions as btc') 
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->orderBy('created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                    ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                    ->join('users as u','u.id','=','bnk.user_id')
                                    ->leftJoin('images as img','img.id','=','bnk.receipt')    
                                    ->orderBy('created_at','DESC')    
                                    ->get(); 
            }        
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam      
            $query1 = DB::table('bitcoin_transactions as btc') 
                            ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at') 
                            ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                            ->join('users as u','u.id','=','btc.user_id');

            return $userData = DB::table('bank_transactions as bnk')
                                ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                ->join('users as u','u.id','=','bnk.user_id')
                                ->leftJoin('images as img','img.id','=','bnk.receipt')
                                ->union($query1)
                                ->orderBy('created_at','DESC') 
                                ->get();                       

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
             $query1 = DB::table('bitcoin_transactions as btc') 
                            ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')
                            ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                            ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')  
                            ->join('users as u','u.id','=','btc.user_id');

            return $userData = DB::table('bank_transactions as bnk')
                                ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                ->join('users as u','u.id','=','bnk.user_id')
                                ->leftJoin('images as img','img.id','=','bnk.receipt')
                                ->union($query1)
                                ->orderBy('created_at','DESC') 
                                ->get();

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
             $query1 = DB::table('bitcoin_transactions as btc') 
                            ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')
                            ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                            ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                            ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')  
                            ->join('users as u','u.id','=','btc.user_id');

            return $userData = DB::table('bank_transactions as bnk')
                                ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                ->join('users as u','u.id','=','bnk.user_id')
                                ->leftJoin('images as img','img.id','=','bnk.receipt')
                                ->union($query1)
                                ->orderBy('created_at','DESC') 
                                ->get();

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='0' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
             if($data['type'] == 1){
                return $userData = DB::table('bitcoin_transactions as btc') 
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')
                                    ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->orderBy('created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
                return $userData = DB::table('bank_transactions as bnk')
                                    ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                    ->join('users as u','u.id','=','bnk.user_id')
                                    ->leftJoin('images as img','img.id','=','bnk.receipt')    
                                    ->orderBy('created_at','DESC')    
                                    ->get(); 
            }
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='0' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
             if($data['type'] == 1){
                return $userData = DB::table('bitcoin_transactions as btc') 
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->orderBy('created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
                return $userData = DB::table('bank_transactions as bnk')
                                    ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                    ->join('users as u','u.id','=','bnk.user_id')
                                    ->leftJoin('images as img','img.id','=','bnk.receipt')    
                                    ->orderBy('created_at','DESC')    
                                    ->get(); 
            }
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='0' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date

             if($data['type'] == 1){
                return $userData = DB::table('bitcoin_transactions as btc') 
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->orderBy('created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
                return $userData = DB::table('bank_transactions as bnk')
                                    ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->join('users as u','u.id','=','bnk.user_id')
                                    ->leftJoin('images as img','img.id','=','bnk.receipt')    
                                    ->orderBy('created_at','DESC')    
                                    ->get(); 
            }
        }else{
            $query1 = DB::table('bitcoin_transactions as btc') 
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'btc.id as transaction_id', 'btc.amount', 'btc.status',DB::raw('"" as receipt'),DB::raw('"1" as modetype'),'btc.created_at')  
                                ->join('users as u','u.id','=','btc.user_id');

            return $userData = DB::table('bank_transactions as bnk')
                                ->select('u.id as user_id', 'u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'), 'u.email', 'bnk.id as transaction_id', 'bnk.amount','bnk.status', 'img.image as receipt',DB::raw('"2" as modetype'), 'bnk.created_at')
                                ->where(function ($query) {
                                               $query->where('bnk.status', 0)
                                                     ->orWhere('bnk.status', 3);
                                           })
                                ->join('users as u','u.id','=','bnk.user_id')
                                ->leftJoin('images as img','img.id','=','bnk.receipt')
                                ->union($query1)
                                ->orderBy('created_at','DESC') 
                                ->get();
        }  

    }    


    public static function select_user(){ 
         return $userData = DB::table('users as u') 
                         ->select('u.id as user_id','u.username')  
                         ->where('u.status','=',1)
                         ->get();
    }

    public static function select_ref_amt($data){ 
        return $userData = DB::table('bank_transactions as bnk')  
                         ->select('bnk.id as refamtid','bnk.amount')  
                         ->where('bnk.user_id','=',$data['user_token'])
                         ->where('bnk.status','=',3)
                         ->whereNOTIn('bnk.id',function($query){
                                        $query->select('ref_amount_id')->from('bank_transactions');
                                    })
                         ->get(); 
    }

            
    public static function user_wallet($data){

        if($data['ref_amount_id']==''){$data['ref_amount_id'] = 0;}

        if($data['userName']!='' && $data['add_amount']!='' && $data['remark']!='' && $data['type']=='0' || $data['type']=='1'){

            if($data['type']=='1'){
                $bank_transactions = DB::select("SELECT 
                                                    @total_deposit := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=0 OR type=3) AND user_id = ".$data['userName']." AND status = 1 AND created_by = 0),0) as total_deposit,
                                                    @total_withdrawal := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=1 AND user_id = ".$data['userName']." AND status = 1),0) as total_withdrawal,
                                                    @total_spent := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE type=2 AND user_id = ".$data['userName']." AND (status=0 OR status=1)),0) as total_spent,
                                                    IFNULL((@total_deposit - (@total_withdrawal + @total_spent)),0) as total_usd");

                $final_amt = (($bank_transactions[0]->total_usd) - $data['add_amount']);
                if($final_amt<0){
                    return '2';
                }
            }

            $userData = DB::table('bank_transactions')->insertGetId(array(
                                                                'ref_amount_id'=>$data['ref_amount_id'],
                                                                'user_id'=>$data['userName'],
                                                                'amount'=>$data['add_amount'],
                                                                'remark'=>$data['remark'],
                                                                'type'=>$data['type'],
                                                                'status'=>1,
                                                                'created_by'=>0,
                                                                'updated_by'=>0
                                                                ));
            return '1';
        }else{
            return 'error';
        }
    }


    public static function fetchUsersWalletDataList(){
      return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);
    }


    public static function fetchUsersWalletDataListsearch($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            if($data['type'] == 1){
                //type 1 for credit
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0]) 
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);

            }else if($data['type'] == 2){ 
               //type 2 for debit
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1])
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);
            }        
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam      
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);                                     

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);                       

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1])
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);


        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='0' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
             if($data['type'] == 1){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0]) 
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);

            }else if($data['type'] == 2){ 
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1]) 
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10); 
            }
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='0' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
             if($data['type'] == 1){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0]) 
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);

            }else if($data['type'] == 2){ 
                 return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1]) 
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10); 
            }
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='0' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date

             if($data['type'] == 1){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0])
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);

            }else if($data['type'] == 2){ 
                                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1])
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10); 
            }
        }else{
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->paginate(10);
        }  

    }    


    public static function fetchUsersWalletDataListExcel(){
        return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();
    }

    public static function fetchUsersWalletDataListsearchExcel($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            if($data['type'] == 1){
                //type 1 for credit
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0]) 
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
               //type 2 for debit
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1])
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();
            }        
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam      
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();                                     

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();                      

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1])
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();


        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='0' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
             if($data['type'] == 1){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0]) 
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1]) 
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();
            }
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='0' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
             if($data['type'] == 1){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0]) 
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
                 return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1]) 
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();
            }
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='0' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date

             if($data['type'] == 1){
                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>0])
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();

            }else if($data['type'] == 2){ 
                                return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1,'bnk.type'=>1])
                                    ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                    ->where('bnk.created_at','>=',''.$data['start_date'].' 00:00:00')
                                    ->Where('bnk.created_at','<=',''.$data['end_date'].' 23:59:59')
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get(); 
            }
        }else{
            return $userData = DB::table('bank_transactions as bnk')
                                    ->leftJoin('users as u','u.id','=','bnk.user_id')
                                    ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no','u.email',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'bnk.ref_amount_id','bnk.amount','bnk.remark','bnk.type','bnk.created_at',DB::raw('(select bk.amount from bank_transactions as bk where bnk.ref_amount_id = bk.id) as ref_amount')) 
                                    ->where(['bnk.updated_by'=>0,'bnk.status'=>1]) 
                                    ->where(function ($query) {
                                               $query->where('bnk.type', 0)
                                                     ->orWhere('bnk.type', 1);
                                           })
                                    ->orderBy('bnk.created_at','DESC')
                                    ->get();
        }  
    }



    public static function manageSettings(){
         return $userData = DB::table('users as u')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','u.G_AUTH','u.is_gAuth','u.AUTH_skip','u.trading_buy','u.trading_sell','u.ticker_paid','u.ticker_ask') 
                                    ->where('u.role',2)  
                                    ->orderBy('u.created_at','DESC')
                                    ->paginate(10);


    }

    public static function manageSettingsSearchResult($data){
        return $userData = DB::table('users as u')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','u.G_AUTH','u.is_gAuth','u.AUTH_skip','u.trading_buy','u.trading_sell','u.ticker_paid','u.ticker_ask') 
                                    ->where('u.role',2)  
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->orderBy('u.created_at','DESC')
                                    ->paginate(10);                         
    }


    public static function manageSettingsExcelDownload($data){

        if($data['param']!='null' && $data['column']!='null'){ 
            return $userData = DB::table('users as u')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','u.G_AUTH','u.is_gAuth','u.AUTH_skip','u.trading_buy','u.trading_sell','u.ticker_paid','u.ticker_ask') 
                                    ->where('u.role',2)  
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->orderBy('u.created_at','DESC')
                                    ->get();
        }else{
            return $userData = DB::table('users as u')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','u.G_AUTH','u.is_gAuth','u.AUTH_skip','u.trading_buy','u.trading_sell','u.ticker_paid','u.ticker_ask') 
                                    ->where('u.role',2)  
                                    ->orderBy('u.created_at','DESC')
                                    ->get();
        }       
    }



    public static function updateAuth($data){
        $data['data_key'] = Crypt::decrypt($data['data_key']);
        return $userData = DB::table('users as u')->where('u.id',$data['data_key'])
                                                  ->update(['G_AUTH'=>0,'is_gAuth'=>0,'AUTH_skip'=>0,'updated_by'=>0]);
    }


    public static function updateRate($data){
        $data['data_key'] = Crypt::decrypt($data['data_key']);
        //create Log table
        DB::table('update_rate_log')->insertGetId(array(
                                                        'user_id'=>$data['data_key'],
                                                        'trading_buy'=>$data['tb'],
                                                        'trading_sell'=>$data['ts'],
                                                        'ticker_paid'=>$data['tp'],
                                                        'ticker_ask'=>$data['ta'],
                                                        'created_by'=>0,
                                                        'updated_by'=>0
                                                        ));

        return $userData = DB::table('users as u')->where('u.id',$data['data_key'])
                                                  ->update(['trading_buy'=>$data['tb'],'trading_sell'=>$data['ts'],'ticker_paid'=>$data['tp'],'ticker_ask'=>$data['ta'],'updated_by'=>0]);
    }


    public static function manageWithdrawalRequest($data){
        if($data['param']!='null' && $data['column']!='null'){ 

            $userData1 = DB::table('bank_transactions as bnk')
                                    ->select('bnk.id','bnk.user_id','bnk.amount','bnk.withdrawal_status',DB::raw('(select bn.bank_name from bank_details as bn where bnk.bank_address = bn.id) as bank_name'),DB::raw('(select bn.beneficiary_account_no from bank_details as bn where bnk.bank_address = bn.id) as account_no'),DB::raw('(select bn.beneficiary_name from bank_details as bn where bnk.bank_address = bn.id) as beneficiary_name'),DB::raw('(select bn.swift_code from bank_details as bn where bnk.bank_address = bn.id) as swift_code'),'bnk.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"1" as modetype'))
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->where(['bnk.withdrawal_status'=>1,'bnk.type'=>4,'bnk.status'=>5,])
                                    ->join('users as u','u.id','=','bnk.user_id');

            return $userData = DB::table('bitcoin_transactions as btc')
                                    ->select('btc.id','btc.user_id','btc.amount','btc.withdrawal_status',DB::raw('"x" as bank_name'),'btc.address as account_no',DB::raw('"x" as beneficiary_name'),DB::raw('"x" as swift_code'),'btc.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"2" as modetype'))
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->where(['btc.withdrawal_status'=>1,'btc.type'=>4,'btc.status'=>5])
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->union($userData1)
                                    ->orderBy('created_at','DESC')
                                    ->get();
        }else{

            $userData1 = DB::table('bank_transactions as bnk')
                                    ->select('bnk.id','bnk.user_id','bnk.amount','bnk.withdrawal_status',DB::raw('(select bn.bank_name from bank_details as bn where bnk.bank_address = bn.id) as bank_name'),DB::raw('(select bn.beneficiary_account_no from bank_details as bn where bnk.bank_address = bn.id) as account_no'),DB::raw('(select bn.beneficiary_name from bank_details as bn where bnk.bank_address = bn.id) as beneficiary_name'),DB::raw('(select bn.swift_code from bank_details as bn where bnk.bank_address = bn.id) as swift_code'),'bnk.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"1" as modetype'))
                                    ->where(['bnk.withdrawal_status'=>1,'bnk.type'=>4,'bnk.status'=>5,])
                                    ->join('users as u','u.id','=','bnk.user_id');

            return $userData = DB::table('bitcoin_transactions as btc')
                                    ->select('btc.id','btc.user_id','btc.amount','btc.withdrawal_status',DB::raw('"x" as bank_name'),'btc.address as account_no',DB::raw('"x" as beneficiary_name'),DB::raw('"x" as swift_code'),'btc.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"2" as modetype')) 
                                    ->where(['btc.withdrawal_status'=>1,'btc.type'=>4,'btc.status'=>5])
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->union($userData1)
                                    ->orderBy('created_at','DESC')
                                    ->get();                         

        }       
    }


    public static function updateWithdrawalRequest($data){
        $data['data_mode']  = Crypt::decrypt($data['data_mode']);
        $data['data_key']   = Crypt::decrypt($data['data_key']);
        // data_mode->1 for bank and data_mode->2 for bitcoin  and data_action->
        if($data['data_mode'] == 1){
            if($data['data_action'] ==1){     
                //accept
                $mail_data = DB::table('bank_transactions as bk')
                                            ->leftJoin('users as u','u.id','=','bk.user_id')
                                            ->leftJoin('bank_details as bkd','bkd.id','=','bk.bank_address')
                                            ->select('bk.amount','bk.created_at','u.email','u.username','u.first_name','bkd.bank_name','bkd.beneficiary_account_no','bkd.beneficiary_name','bkd.swift_code','u.last_name')
                                            ->where('bk.id',$data['data_key'])                           
                                            ->first();

                $mail = Mail::send('admin.email.confirm_withdrawal_usd',array('data'=>$mail_data,'currency'=>'USD'),function($message) use ($mail_data){ $message->to($mail_data->email, $mail_data->username)->subject('Withdrawal Request Confirm');
                             });
                return $userdata = DB::table('bank_transactions')->where('id',$data['data_key'])
                                                         ->update(['withdrawal_status'=>2,'updated_by'=>0]);

            }else if($data['data_action'] ==2){
                //canceled
                $mail_data = DB::table('bank_transactions as bk')
                                            ->leftJoin('users as u','u.id','=','bk.user_id')
                                            ->leftJoin('bank_details as bkd','bkd.id','=','bk.bank_address')
                                            ->select('bk.amount','bk.updated_at','u.email','u.username','u.first_name','bkd.bank_name','bkd.beneficiary_account_no','bkd.beneficiary_name','bkd.swift_code','u.last_name')
                                            ->where('bk.id',$data['data_key'])                           
                                            ->first();

                $mail = Mail::send('admin.email.cancaled_withdrawal_usd',array('data'=>$mail_data,'currency'=>'USD'),function($message) use ($mail_data){ $message->to($mail_data->email, $mail_data->username)->subject('Withdrawal Request Canceled');
                             });    
                                         
                return $userdata = DB::table('bank_transactions')->where('id',$data['data_key'])
                                                          ->update(['withdrawal_status'=>3,'updated_by'=>0]);
            }
        }else if($data['data_mode'] == 2){
            if($data['data_action'] ==1){
                //accept
                $mail_data = DB::table('bitcoin_transactions as btc')
                                            ->leftJoin('users as u','u.id','=','btc.user_id')
                                            ->select('btc.amount','btc.address','btc.created_at','u.email','u.username','u.first_name','u.last_name')
                                            ->where('btc.id',$data['data_key'])                           
                                            ->first();

                $mail = Mail::send('admin.email.confirm_withdrawal_btc',array('data'=>$mail_data,'currency'=>'Bitcoin'),function($message) use ($mail_data){ $message->to($mail_data->email, $mail_data->username)->subject('Withdrawal Request Confirm');
                             });
                return $userdata = DB::table('bitcoin_transactions')->where('id',$data['data_key'])
                                                          ->update(['withdrawal_status'=>2,'updated_by'=>0]);
            }else if($data['data_action'] ==2){
                //cancel
                $mail_data = DB::table('bitcoin_transactions as btc')
                                            ->leftJoin('users as u','u.id','=','btc.user_id')
                                            ->select('btc.amount','btc.address','btc.updated_at','u.email','u.username','u.first_name','u.last_name')
                                            ->where('btc.id',$data['data_key'])                           
                                            ->first();

                $mail = Mail::send('admin.email.cancaled_withdrawal_btc',array('data'=>$mail_data,'currency'=>'Bitcoin'),function($message) use ($mail_data){ $message->to($mail_data->email, $mail_data->username)->subject('Withdrawal Request Canceled');
                             });

                return $userdata = DB::table('bitcoin_transactions')->where('id',$data['data_key'])
                                                          ->update(['withdrawal_status'=>3,'updated_by'=>0]);
            }
        }
    }


    public static function manageWithdrawalPaid($data){
        if($data['param']!='null' && $data['column']!='null'){ 

            $userData1 = DB::table('bank_transactions as bnk')
                                    ->select('bnk.id','bnk.user_id','bnk.amount','bnk.withdrawal_status',DB::raw('(select bn.bank_name from bank_details as bn where bnk.bank_address = bn.id) as bank_name'),DB::raw('(select bn.beneficiary_account_no from bank_details as bn where bnk.bank_address = bn.id) as account_no'),DB::raw('(select bn.beneficiary_name from bank_details as bn where bnk.bank_address = bn.id) as beneficiary_name'),DB::raw('(select bn.swift_code from bank_details as bn where bnk.bank_address = bn.id) as swift_code'),'bnk.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"1" as modetype'),'bnk.updated_at','bnk.withdrawal_status')
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->where(['bnk.withdrawal_status'=>2,'bnk.type'=>4,'bnk.status'=>5,])
                                    ->join('users as u','u.id','=','bnk.user_id');

            return $userData = DB::table('bitcoin_transactions as btc')
                                    ->select('btc.id','btc.user_id','btc.amount','btc.withdrawal_status',DB::raw('"x" as bank_name'),'btc.address as account_no',DB::raw('"x" as beneficiary_name'),DB::raw('"x" as swift_code'),'btc.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"2" as modetype'),'btc.updated_at','btc.withdrawal_status') 
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->where(['btc.withdrawal_status'=>2,'btc.type'=>4,'btc.status'=>5])
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->union($userData1)
                                    ->orderBy('created_at','DESC')
                                    ->get();
        }else{

            $userData1 = DB::table('bank_transactions as bnk')
                                    ->select('bnk.id','bnk.user_id','bnk.amount','bnk.withdrawal_status',DB::raw('(select bn.bank_name from bank_details as bn where bnk.bank_address = bn.id) as bank_name'),DB::raw('(select bn.beneficiary_account_no from bank_details as bn where bnk.bank_address = bn.id) as account_no'),DB::raw('(select bn.beneficiary_name from bank_details as bn where bnk.bank_address = bn.id) as beneficiary_name'),DB::raw('(select bn.swift_code from bank_details as bn where bnk.bank_address = bn.id) as swift_code'),'bnk.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"1" as modetype'),'bnk.updated_at','bnk.withdrawal_status')
                                    ->where(['bnk.withdrawal_status'=>2,'bnk.type'=>4,'bnk.status'=>5,])
                                    ->join('users as u','u.id','=','bnk.user_id');

            return $userData = DB::table('bitcoin_transactions as btc')
                                    ->select('btc.id','btc.user_id','btc.amount','btc.withdrawal_status',DB::raw('"x" as bank_name'),'btc.address as account_no',DB::raw('"x" as beneficiary_name'),DB::raw('"x" as swift_code'),'btc.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"2" as modetype'),'btc.updated_at','btc.withdrawal_status') 
                                    ->where(['btc.withdrawal_status'=>2,'btc.type'=>4,'btc.status'=>5])
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->union($userData1)
                                    ->orderBy('created_at','DESC')
                                    ->get();                         
        }       
    }

    public static function manageWithdrawalCancel($data){
        if($data['param']!='null' && $data['column']!='null'){ 

            $userData1 = DB::table('bank_transactions as bnk')
                                    ->select('bnk.id','bnk.user_id','bnk.amount','bnk.withdrawal_status',DB::raw('(select bn.bank_name from bank_details as bn where bnk.bank_address = bn.id) as bank_name'),DB::raw('(select bn.beneficiary_account_no from bank_details as bn where bnk.bank_address = bn.id) as account_no'),DB::raw('(select bn.beneficiary_name from bank_details as bn where bnk.bank_address = bn.id) as beneficiary_name'),DB::raw('(select bn.swift_code from bank_details as bn where bnk.bank_address = bn.id) as swift_code'),'bnk.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"1" as modetype'),'bnk.updated_at','bnk.withdrawal_status')
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->where(['bnk.withdrawal_status'=>3,'bnk.type'=>4,'bnk.status'=>5,])
                                    ->join('users as u','u.id','=','bnk.user_id');

            return $userData = DB::table('bitcoin_transactions as btc')
                                    ->select('btc.id','btc.user_id','btc.amount','btc.withdrawal_status',DB::raw('"x" as bank_name'),'btc.address as account_no',DB::raw('"x" as beneficiary_name'),DB::raw('"x" as swift_code'),'btc.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"2" as modetype'),'btc.updated_at','btc.withdrawal_status') 
                                    ->where($data['column'], 'like', '%'.$data['param'].'%')
                                    ->where(['btc.withdrawal_status'=>3,'btc.type'=>4,'btc.status'=>5])
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->union($userData1)
                                    ->orderBy('created_at','DESC')
                                    ->get();
        }else{

            $userData1 = DB::table('bank_transactions as bnk')
                                    ->select('bnk.id','bnk.user_id','bnk.amount','bnk.withdrawal_status',DB::raw('(select bn.bank_name from bank_details as bn where bnk.bank_address = bn.id) as bank_name'),DB::raw('(select bn.beneficiary_account_no from bank_details as bn where bnk.bank_address = bn.id) as account_no'),DB::raw('(select bn.beneficiary_name from bank_details as bn where bnk.bank_address = bn.id) as beneficiary_name'),DB::raw('(select bn.swift_code from bank_details as bn where bnk.bank_address = bn.id) as swift_code'),'bnk.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"1" as modetype'),'bnk.updated_at','bnk.withdrawal_status')
                                    ->where(['bnk.withdrawal_status'=>3,'bnk.type'=>4,'bnk.status'=>5,])
                                    ->join('users as u','u.id','=','bnk.user_id');

            return $userData = DB::table('bitcoin_transactions as btc')
                                    ->select('btc.id','btc.user_id','btc.amount','btc.withdrawal_status',DB::raw('"x" as bank_name'),'btc.address as account_no',DB::raw('"x" as beneficiary_name'),DB::raw('"x" as swift_code'),'btc.created_at','u.first_name','u.last_name','u.username','u.email','u.country_code','u.mobile_no',DB::raw('"2" as modetype'),'btc.updated_at','btc.withdrawal_status') 
                                    ->where(['btc.withdrawal_status'=>3,'btc.type'=>4,'btc.status'=>5])
                                    ->join('users as u','u.id','=','btc.user_id')
                                    ->union($userData1)
                                    ->orderBy('created_at','DESC')
                                    ->get();                        
        }       
    }

    public static function manageOrderBuy($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10); 

        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam              
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);    

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10); 
             
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);     

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);  
             
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10); 

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])                              
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);
            
        }else{
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);
        }  
    }


    public static function manageOrderBuyDownload($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.status'=>$data['type']])
                                ->where(['or.side'=>1])
                                ->orderBy('or.created_at','DESC') 
                                ->get();

        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam              
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->get();  

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->get(); 
             
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->get();    

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->get();  
             
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->get();

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->where(['or.status'=>$data['type']])                              
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->get();
            
        }else{
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>1])
                                ->orderBy('or.created_at','DESC') 
                                ->get();
        }  
    }


    public static function manageOrderSell($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.status'=>$data['type']])
                                ->where(['or.side'=>2])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10); 

        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam              
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);    

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10); 
             
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);     

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where(['or.status'=>$data['type']])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);  
             
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where(['or.status'=>$data['type']])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10); 

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where(['or.status'=>$data['type']])                              
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);
            
        }else{
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);
        }  
    }

    public static function manageOrderSellDownload($data){   
        if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] ==''){
            //only modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.status'=>$data['type']])
                                ->where(['or.side'=>2])
                                ->orderBy('or.created_at','DESC') 
                                ->get();

        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam              
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->get();  

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] ==''){
            //only date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->get(); 
             
        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] =='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only date + searchparam
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->get();    

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] =='' && $data['searchcolumn'] ==''){
            //only date + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where(['or.status'=>$data['type']])
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->orderBy('or.created_at','DESC') 
                                ->get();  
             
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type)
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where(['or.status'=>$data['type']])
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->get();

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['type'] !='' && $data['searchparam'] !='' && $data['searchcolumn'] !=''){
            //only searchparam + modetype(type) + date
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->where(['or.status'=>$data['type']])                              
                                ->where('or.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('or.created_at','<=',''.$data['end_date'].' 23:59:59') 
                                ->where($data['searchcolumn'], 'like', '%'.$data['searchparam'].'%')
                                ->orderBy('or.created_at','DESC') 
                                ->get();
            
        }else{
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at')
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>2])
                                ->orderBy('or.created_at','DESC') 
                                ->get();
        }  
    }




    public static function manageProfit($data){

        if($data['param']!='null' && $data['column']!='null'){
            //both     
            $id = intval(substr($data['param'], 3,4));  
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>$data['column'],'or.id'=>$id])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);

        }else if($data['param']!='null' && $data['column']=='null'){   
            //order id  
            $id = intval(substr($data['param'], 3,4));  
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.id'=>$id])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);

        }else if($data['param']=='null' && $data['column']!='null'){   
            //order side  
            $id = intval(substr($data['param'], 3,4));  
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>$data['column']])
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);

        }else{
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->orderBy('or.created_at','DESC') 
                                ->paginate(10);
        }       
    }


    public static function manageProfitDownload($data){

        if($data['param']!='null' && $data['column']!='null'){
            //both     
            $id = intval(substr($data['param'], 3,4));  
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>$data['column'],'or.id'=>$id])
                                ->orderBy('or.created_at','DESC') 
                                ->get();

        }else if($data['param']!='null' && $data['column']=='null'){   
            //order id  
            $id = intval(substr($data['param'], 3,4));  
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.id'=>$id])
                                ->orderBy('or.created_at','DESC') 
                                ->get();

        }else if($data['param']=='null' && $data['column']!='null'){   
            //order side  
            $id = intval(substr($data['param'], 3,4));  
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->where(['or.side'=>$data['column']])
                                ->orderBy('or.created_at','DESC') 
                                ->get();
        }else{
            return $userData = DB::table('orders as or')
                                ->select('or.id','or.user_id','or.side','or.quantity','or.limit_price','or.filled','or.remaining','or.avg_price','or.status','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'or.created_at','or.updated_at','or.quantity','or.limit_price','or.total_paid','or.pc_calculated_amount','or.itbit_calculated_amount','or.usd_conversion','or.perfektpay_comm',DB::raw('(select sum((case when (side = 1) then (total_paid - pc_calculated_amount) - (limit_price * quantity) else (quantity * limit_price) - (total_paid) end)) as totalProfit from orders) as totalProfit'))
                                ->leftJoin('users as u','or.user_id','=','u.id')
                                ->orderBy('or.created_at','DESC') 
                                ->get();
        }       
    }


    public static function get_data(){
        $current_date = date("Y-m-d");
        return $userData = DB::select("SELECT 
            @total_deposit := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=0 OR type=3) AND status = 1 AND created_by = 0),0) as total_deposit,
            @total_withdrawal := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE withdrawal_status =2 AND created_by = 0),0) as total_withdrawal,
            @today_withdrawal := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE withdrawal_status =2 AND created_by = 0 AND updated_at like '".$current_date."%'),0) as today_withdrawal,
            @today_deposit := IFNULL((SELECT sum(amount) FROM bank_transactions WHERE (type=0 OR type=3) AND status = 1 AND created_by = 0 AND updated_at like '".$current_date."%'),0) as today_deposit,
            @today_deposit_btc := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=3) AND status = 1 AND updated_at like '".$current_date."%'),0) as today_deposit_btc,
            @total_deposit_btc := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE (type=0 OR type=3) AND status = 1),0) as total_deposit_btc,
            @today_withdrawal_btc := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE withdrawal_status =2 AND created_by = 0 AND updated_at like '".$current_date."%'),0) as today_withdrawal_btc,
            @total_withdrawal_btc := IFNULL((SELECT sum(amount) FROM bitcoin_transactions WHERE withdrawal_status =2 AND created_by = 0),0) as total_withdrawal_btc");
    }


    public static function contact_mail(){
        return $userData = DB::table('contact_us as cu')
                                ->select('cu.id','cu.name','cu.email','cu.phn_no','cu.inquiry','cu.subject','cu.message','cu.created_at')
                                ->orderBy('cu.created_at','DESC') 
                                ->paginate(10); 
    }  



    public static function bitcoinTransactionList(){ 
            //All data
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 6)
                                                     ->orWhere('btc.status', 2);
                                           })                                
                                ->orderBy('btc.created_at','DESC')      
                                ->paginate(10); 
    }

    public static function searchbitcoinTransactionList($data){ 
        if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] !='' && $data['column'] !=''){    
            //with date + param 
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('btc.created_at','DESC')      
                                ->paginate(10); 
         
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['param'] !='' && $data['column'] !=''){
            //only param 
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->orderBy('btc.created_at','DESC')      
                                ->paginate(10);   

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] =='' && $data['column'] ==''){
            //only date
             return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })                                
                                ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('btc.created_at','DESC')      
                                ->paginate(10);  
        }                        
    }


    public static function bitcoinTransactionListdownload($data){ 
        if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] !='' && $data['column'] !=''){    
            //with date + param 
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('btc.created_at','DESC')      
                                ->get();
         
        }else if($data['start_date'] =='' && $data['end_date'] =='' && $data['param'] !='' && $data['column'] !=''){
            //only param
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })
                                ->where($data['column'], 'like', '%'.$data['param'].'%')
                                ->orderBy('btc.created_at','DESC')      
                                ->get();  
 

        }else if($data['start_date'] !='' && $data['end_date'] !='' && $data['param'] =='' && $data['column'] ==''){
            //only date
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })                                
                                ->where('btc.created_at','>=',''.$data['start_date'].' 00:00:00')
                                ->Where('btc.created_at','<=',''.$data['end_date'].' 23:59:59')
                                ->orderBy('btc.created_at','DESC')      
                                ->get();  
        }else{
            //All data
            return $userData = DB::table('users as u')
                                ->select('u.id as user_id','u.username','u.first_name','u.last_name','u.country_code','u.mobile_no',DB::raw('(select ct.name from countries as ct where u.country = ct.id) as country'),'u.email','btc.amount','btc.id as transactionsId','btc.status','btc.created_at')
                                ->leftJoin('bitcoin_transactions as btc','btc.user_id','=','u.id')
                                ->where(['btc.ref_id'=>0,'btc.type'=>0])
                                ->where(function ($query) {
                                               $query->where('btc.status', 1)
                                                     ->orWhere('btc.status', 2);
                                           })                                
                                ->orderBy('btc.created_at','DESC')      
                                ->get();  
        }                        
    }



   public static function tradingPrice($data){

        echo $userData = DB::table('users as u')->update(['trading_buy'=>$data['buy'],'trading_sell'=>$data['sell'],'updated_by'=>0]);
            Admin::insert_rate_log($data,1);
    }

    public static function tickerPrice($data){
        echo $userData = DB::table('users as u')->update(['ticker_paid'=>$data['bid'],'ticker_ask'=>$data['ask'],'updated_by'=>0]);        
            Admin::insert_rate_log($data,2);
    }

    public static function insert_rate_log($data,$type){
        $user = DB::table('users')->select('id')->get();
        if($type==1){//for trading price
            foreach ($user as $key => $value) {
                    DB::table('update_rate_log')->insertGetId(array(
                                                                'user_id'=>$value->id,
                                                                'trading_buy'=>$data['buy'],
                                                                'trading_sell'=>$data['sell'],
                                                                'created_by'=>0,
                                                                'updated_by'=>0
                                                                ));
            }    
        }
        elseif ($type==2) {//ticker price
            foreach ($user as $key => $value) {
                    DB::table('update_rate_log')->insertGetId(array(
                                                                'user_id'=>$value->id,
                                                                'ticker_paid'=>$data['bid'],
                                                                'ticker_ask'=>$data['ask'],
                                                                'created_by'=>0,
                                                                'updated_by'=>0
                                                                ));

            }    
        }
    }



}
               