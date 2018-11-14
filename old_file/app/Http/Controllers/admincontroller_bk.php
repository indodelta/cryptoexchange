<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Admin;
use Respons;
use App\Http\Requests;
use Redirect;
use Validator;
use Session;
use Crypt;
use DB;
use Excel;  
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination;


class admincontroller extends Controller
{

    public function login(){
        if(Session::has('email')){
            return Redirect::route('dashboard');
        }else{
            return \View::make('admin.login');
        }    
    }

    public function loginprocess(){
    	$input= Input::all();    	
    	$value= Admin::loginprocess($input);
    	if($value['success']==1){      		
            return Redirect::route('dashboard');
        }else if($value['success']==0){                   
           	return \View::make('admin.login');
        }
    }

    public function logout(){
        Session::flush();
        return  Redirect::route('login');
    }

    public function dashboard(){
        return View('admin.dashboard');
    }


    public function manageUser(Request $request){
        if (!$request->isMethod('post')){
            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = $request->input('column');
                // dd($data);
                $user = new Admin;
                $userData = $user->fetchUserManagementSearchResult($data);
                return view('admin.manage_user')->with('userList',$userData);
            }else{
                //full data
                $user = new Admin;
                $userData = $user->fetchUserManagementList();
                //dd($userData);
                return view('admin.manage_user')->with('userList',$userData);
            }
        }else{
            //filter search data
            $data['param'] = $request->input('param');
            $data['column'] = $request->input('column');
            //dd($data);
            $user = new Admin;
            $userData = $user->fetchUserManagementSearchResult($data);
            return view('admin.manage_user')->with('userList',$userData);
        }
    }

    public function adminEditUser($userId){
        $userId = Crypt::decrypt($userId);
        $userData['userinfo'] = Admin::fetchManageUserData($userId);
        $userData['country'] = DB::table('countries')->get();
        $userData['kycinfo'] = DB::table('user_kyc_details')->select('user_id','kyc_name','status')->where(['user_id'=>$userId])->get();
//dd($userData['kycinfo']);
        return view('admin.edit_users')->with('userData',$userData);
    }

    public function updateUserinfo(Request $request){
            $data['id'] = Crypt::decrypt($request->input('id'));
            $data['first_name'] = $request->input('first_name');
            $data['last_name'] = $request->input('last_name');
            $data['mobile_no'] = $request->input('mobile_no');
            $data['address'] = $request->input('address');            
            $data['city'] = $request->input('city');
            $data['state'] = $request->input('state');
            $data['country'] = $request->input('country');            
            $data['zip_code'] = $request->input('zip_code');
            $data['updated_by'] = '2'; // 2 for Admin
            // echo "<pre>";
            // dd($data);
            $userData = Admin::updateUserinfo($data);
            Session::flash('message','User details updated successfully.');
            return redirect('/admin/admin-edit-user/'.Crypt::encrypt($data['id']).'');
    }

    public function updateUserkycinfo(Request $request){
       if($request->input('nation_kyc_id')!='' && $request->input('address_kyc_id')!=''){     
            $data['id'] = Crypt::decrypt($request->input('id'));
            $data['nationradio'] = $request->input('nationradio'); 
            $data['addradio'] = $request->input('addradio');
            // kyc table index id for nation
            $data['nation_kyc_id'] = Crypt::decrypt($request->input('nation_kyc_id')); 
            // kyc table index id for address
            $data['address_kyc_id'] = Crypt::decrypt($request->input('address_kyc_id'));

            $userData = Admin::updateUserkycinfo($data);
            Session::flash('message','User KYC details updated successfully.');
            return redirect('/admin/admin-edit-user/'.Crypt::encrypt($data['id']).'');
        }else{
            $data['id'] = Crypt::decrypt($request->input('id'));
            return redirect('/admin/admin-edit-user/'.Crypt::encrypt($data['id']).'');
        }
    }

    public function updateUserStatus(){
        $input= Input::all();
        $value= Admin::updateUserStatus($input);
        return $value;
    }

    public function bankTransactionList(Request $request){ //dd($request);
        if (!$request->isMethod('post')){
            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != "" && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == ""){
                //filter search data(only param)
                $data['start_date']='';
                $data['end_date']='';
                $data['param'] = $request->input('param'); 
                $data['column'] = $request->input('column');
                $userData = Admin::searchBankTransactionList($data);
                return view('admin.bank_transactions')->with('userList',$userData);   
            
            }else if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(param + date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date'] = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['param'] = $request->input('param'); 
                $data['column'] = $request->input('column');
                $userData = Admin::searchBankTransactionList($data);              
                return view('admin.bank_transactions')->with('userList',$userData);
            
            }else if($request->isMethod('get') && $request->input('param') == "" && $request->input('column') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date'] = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::searchBankTransactionList($data);              
                return view('admin.bank_transactions')->with('userList',$userData);
                
            }else{                
                //full data
                $userData = Admin::bankTransactionList();
                return view('admin.bank_transactions')->with('userList',$userData);               
            }
        }else{
            //filter search data
            $data['param'] = $request->input('param');
            $data['column'] = $request->input('column');
            //dd($data);
            $userData = Admin::searchBankTransactionList($data);
            return view('admin.bank_transactions')->with('userList',$userData); 
        } 
    }
  
    public function bankTransactionListdownload($datetimepicker1,$datetimepicker2,$column,$param){ 
 
        if($param != "null" && $column != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null"){
                //filter search data(only param)
                $data['start_date']='';
                $data['end_date']='';
                $data['param'] = $param; 
                $data['column'] = $column;
                $userData = Admin::searchBankTransactionListExcel($data);
                               
        }else if($param != "null" && $column != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null"){
                //filter search data(param + date)
                $data['start_date'] = date("Y-m-d", strtotime($datetimepicker1)); 
                $data['end_date']   = date("Y-m-d", strtotime($datetimepicker2));
                $data['param']      = $param; 
                $data['column']     = $column;
                $userData           = Admin::searchBankTransactionListExcel($data);       
            
        }else if($param == "null" && $column != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null"){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($datetimepicker1)); 
                $data['end_date']   = date("Y-m-d", strtotime($datetimepicker2));
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::searchBankTransactionListExcel($data);    
        }else{                
                //full data
                $data['start_date'] = ''; 
                $data['end_date'] = '';
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::searchBankTransactionListExcel($data);              
            }    

        //download excel        
        if($userData!=''){
            Excel::create('bank_transactions', function($excel) use ($userData){
                $excel->sheet('bank_transactions', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.bankTransactionListExcel',['userList'=>$userData]);
                });
            })->download('xls');
        }   
    }         

    public function updateUserActionStatus(Request $request){
            $data['id'] = Crypt::decrypt($request->input('data_key'));
            $userData = Admin::updateUserActionStatus($data);
            Session::flash('message','User Payment successfull.');
            return redirect('/admin/bank-transactions');
    }

    // public function manageDeposits(Request $request){
    //     $userData = Admin::manageDeposits();
    //     //dd($userData);
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //     $col = new Collection($userData);    
    //     $perPage = 10;
    //     $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    //     $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
    //     $userData->setPath($request->url());
    //     return view('admin.manage_deposits')->with('userList',$userData);   
    // }


    public function manageDeposits(Request $request){
        $userData='';
        //dd($request);
        if (!$request->isMethod('post')){
            if($request->isMethod('get') && $request->input('searchparam') == ""  && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') != 0){
                // //filter search data(type)
                $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
                $data['type'] = $request->input('type');
                $userData = Admin::searchManageDepositsList($data);  

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') == 0){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $userData = Admin::searchManageDepositsList($data);

            }else if($request->isMethod('get') && $request->input('searchparam') == "" && $request->input('type') == 0 && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::searchManageDepositsList($data); 

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('type') == 0 && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(date + searchparam)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $data['type'] = ''; 
                $userData = Admin::searchManageDepositsList($data);   

            }else if($request->isMethod('get')  && $request->input('type') != 0 && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != "" && $request->input('searchparam') == "" && $request->input('searchcolumn') != ""){                
                //filter search data(date + type)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $request->input('type'); 
                $userData = Admin::searchManageDepositsList($data);  

            }else if($request->isMethod('get')  && $request->input('type') != 0 && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('searchparam') != "" && $request->input('searchcolumn') != ""){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                              
                $data['type'] = $request->input('type');
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::searchManageDepositsList($data);  

            }else if($request->isMethod('get')  && $request->input('type') != 0 && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                              
                $data['type'] = $request->input('type');
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $userData = Admin::searchManageDepositsList($data); 
            }else{   
                //full data
                $userData = Admin::manageDeposits();                            
            }
        }else{
            //filter search data
             $userData = Admin::manageDeposits();
        } 

        //create pagination 
        if($userData!=''){
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $col = new Collection($userData);    
            $perPage = 10;
            $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
            $userData->setPath($_SERVER['REQUEST_URI']);
            return view('admin.manage_deposits')->with('userList',$userData);
        }    
    }


    public function manageDepositsDownload($datetimepicker1,$datetimepicker2,$type,$searchcolumn,$searchparam){
        $userData='';
        //dd($request);  $searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 0     
        if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 0){
            // //filter search data(type)
            $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
            $data['type'] = $type;
            $userData = Admin::searchManageDepositsList($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type == 0){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $userData = Admin::searchManageDepositsList($data);

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 0){
                //filter search data(only date)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::searchManageDepositsList($data); 

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 0){
                //filter search data(date + searchparam)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $data['type'] = ''; 
                $userData = Admin::searchManageDepositsList($data);   

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 0){                
                //filter search data(date + type)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $type; 
                $userData = Admin::searchManageDepositsList($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 0){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::searchManageDepositsList($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 0){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $userData = Admin::searchManageDepositsList($data); 
        }else{   
                //full data
                $data['searchparam'] = ''; 
                $data['searchcolumn'] = '';                             
                $data['type'] = '';
                $data['start_date'] = ''; 
                $data['end_date']   = '';
                $userData = Admin::searchManageDepositsList($data);                            
        }        

        //download excel        
        if($userData!=''){
            Excel::create('all_deposits', function($excel) use ($userData){
                $excel->sheet('all_deposits', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.manage_depositsListExcel',['userList'=>$userData]);
                });
            })->download('xls');
        }   
    }
     
    public function select_user(){
       return $userData = Admin::select_user();
    }

    public function select_ref_amt(){
        $input= Input::all();
        return $userData = Admin::select_ref_amt($input);
    }

    public function user_wallet(){
        $input= Input::all();
        if($input['ref_amount_id'] !='' && $input['type']== 1){
            $userData = 'error2';
        }else if($input['ref_amount_id'] !='' && $input['type']== 0 ){
            $userData = Admin::user_wallet($input);
        }else if($input['ref_amount_id'] =='' && $input['type']== 0 || $input['type']== 1){
            $userData = Admin::user_wallet($input);
        }

        //generate message.
        if($userData == 1){
            if($input['type'] == 0){
                Session::flash('message','credit');
            }else if($input['type'] == 1){
                Session::flash('message','debit');
            }
        }else if($userData == 'error'){            
            Session::flash('error','System Error.');
        }else if($userData == 'error2'){
            Session::flash('error2','You can not debit from referred Amount.');
        }else if($userData == '2'){            
            Session::flash('error','User donot have sufficient amount.');
        }
        return redirect('/admin/manage-wallet');
    }


    public function manageWallet(Request $request){


            if($request->isMethod('get') && $request->input('searchparam') == ""  && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') != 0){
                // //filter search data(type)
                $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
                $data['type'] = $request->input('type');
                $userData = Admin::fetchUsersWalletDataListsearch($data);  
 
            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') == 0){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $userData = Admin::fetchUsersWalletDataListsearch($data);

            }else if($request->isMethod('get') && $request->input('searchparam') == "" && $request->input('type') == 0 && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::fetchUsersWalletDataListsearch($data); 

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('type') == 0 && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(date + searchparam)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $data['type'] = ''; 
                $userData = Admin::fetchUsersWalletDataListsearch($data);   

            }else if($request->isMethod('get')  && $request->input('type') != 0 && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != "" && $request->input('searchparam') == "" && $request->input('searchcolumn') != ""){                
                //filter search data(date + type)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $request->input('type'); 
                $userData = Admin::fetchUsersWalletDataListsearch($data);  

            }else if($request->isMethod('get')  && $request->input('type') != 0 && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('searchparam') != "" && $request->input('searchcolumn') != ""){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                              
                $data['type'] = $request->input('type');
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::fetchUsersWalletDataListsearch($data);  

            }else if($request->isMethod('get')  && $request->input('type') != 0 && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                              
                $data['type'] = $request->input('type');
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $userData = Admin::fetchUsersWalletDataListsearch($data); 
            }else{   
                //full data
                $user = new Admin;
                $userData = $user->fetchUsersWalletDataList();
                //dd($userData);                                           
            }
         return view('admin.manage_wallet')->with('userList',$userData);    
    }




}
