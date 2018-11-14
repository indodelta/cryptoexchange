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
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname') 
                                    ->where('u.role',2)  
                                    ->orderBy('u.created_at','DESC')
                                    ->paginate(10);
    }

    public static function fetchUserManagementSearchResult($data){
        return  $userData = DB::table('users as u')
                                    ->leftJoin('countries as co','co.id','=','u.country')
                                    ->select('u.id','u.username','u.first_name','u.last_name','u.email','u.country_code','u.mobile_no','u.country','u.status','u.created_at','u.user_kyc_status','u.UDF','u.KYCF_skip','co.name as countryname')
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
                                                  ->update(['G_AUTH'=>0,'is_gAuth'=>0,'AUTH_skip'=>1,'updated_by'=>0]);
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
}
              