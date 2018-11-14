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
            if($request->isMethod('get')  && $request->input('column') != ""){
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
                // dd($userData);
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

    public function manageuserDownload($column,$param){ 
 
        if($param != "null" && $column != "null"){
                //filter search data(only param)
                $data['param'] = $param; 
                $data['column'] = $column;
                $userData = Admin::searchuserListExcel($data);
                               
        }else if($param == "null" && $column != "null"){
                //filter search data(only date)
                
                $data['param'] = '';
                $data['column'] = $column;
                $userData = Admin::searchuserListExcel($data);    
        }else{                
                //full data
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::searchuserListExcel($data);              
            }    
            // dd($userData);
        //download excel        
        if($userData!=''){
            Excel::create('User_details', function($excel) use ($userData){
                $excel->sheet('User_details', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.User_detailsListExcel',['userList'=>$userData]);
                });
            })->download('xls');
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
            return redirect('/organize/admin-edit-user/'.Crypt::encrypt($data['id']).'');
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
            return redirect('/organize/admin-edit-user/'.Crypt::encrypt($data['id']).'');
        }else{
            $data['id'] = Crypt::decrypt($request->input('id'));
            return redirect('/organize/admin-edit-user/'.Crypt::encrypt($data['id']).'');
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
            return redirect('/organize/bank-transactions');
    }
    public function updateUserActionStatus_bit(Request $request){
            $data['id'] = Crypt::decrypt($request->input('data_key'));
            $userData = Admin::updateUserActionStatus_bit($data);
            Session::flash('message','User Payment successfull.');
            return redirect('/organize/bitcoin-transactions');
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
            $userData->setPath(route('manage-deposits'));
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
        return redirect('/organize/manage-wallet');
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




    public function manageWalletDownload($datetimepicker1,$datetimepicker2,$type,$searchcolumn,$searchparam){
        $userData='';    
        if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 0){
            // //filter search data(type)
            $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
            $data['type'] = $type;
            $userData = Admin::fetchUsersWalletDataListsearchExcel($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type == 0){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data);

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 0){
                //filter search data(only date)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data); 

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 0){
                //filter search data(date + searchparam)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $data['type'] = ''; 
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data);   

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 0){                
                //filter search data(date + type)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $type; 
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 0){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 0){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data); 
        }else{   
                //full data
                $data['searchparam'] = ''; 
                $data['searchcolumn'] = '';                             
                $data['type'] = '';
                $data['start_date'] = ''; 
                $data['end_date']   = '';
                $userData = Admin::fetchUsersWalletDataListsearchExcel($data);                            
        }        

        //download excel        
        if($userData!=''){
            Excel::create('manage_wallet_excel', function($excel) use ($userData){
                $excel->sheet('manage_wallet_excel', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.manage_walletListExcel',['userList'=>$userData]);
                });
            })->download('xls');
        }  
    }



    public function manageSettings(Request $request){
        if (!$request->isMethod('post')){
            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = $request->input('column');
                $userData = Admin::manageSettingsSearchResult($data);
                return view('admin.settings')->with('userList',$userData); 
            }else{
                //full data
                $userData = Admin::manageSettings();
                return view('admin.settings')->with('userList',$userData); 
            }
        }else{
            //filter search data
            $data['param'] = $request->input('param');
            $data['column'] = $request->input('column');
            //dd($data);
            $user = new Admin;
            $userData = $user->manageSettingsSearchResult($data);
            return view('admin.settings')->with('userList',$userData);
        }
    }

    public function manageSettingDownload($param,$column){

        if($param != "" && $column != ""){
            //filter search data
            $data['param']  = $param;
            $data['column'] = $column;
            $userData = Admin::manageSettingsExcelDownload($data);
        }else{            
            $data['param']  = $param;
            $data['column'] = $column;
            $userData = Admin::manageSettingsExcelDownload($data);
        }
        //download excel        
        if($userData!=''){
            Excel::create('user_setting_excel', function($excel) use ($userData){
                $excel->sheet('user_setting_excel', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.user_setting_excel',['userList'=>$userData]);
                });
            })->download('xls');
        } 
    }


    public function updateAuth(){
        $input = Input::all();
        $value = Admin::updateAuth($input);
        return $value;
    }


    public function updateRate(){
        $input = Input::all();
        $value = Admin::updateRate($input);       
        Session::flash('success','Update successfully.');        
        return $value;
    }

    public function manageWithdrawalRequest(Request $request){

            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = $request->input('column');
                $userData = Admin::manageWithdrawalRequest($data);
            }else{
                //full data
                $data['param'] = 'null';
                $data['column'] = 'null';
                $userData = Admin::manageWithdrawalRequest($data);
            }

            //create pagination 
            if($userData!=''){
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $col = new Collection($userData);    
                $perPage = 10;
                $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
                $userData->setPath(route('manage-withdrawal-request'));
            }
            return view('admin.manage_withdrawal_request')->with('userList',$userData);
    }


    public function updateWithdrawalRequest(){
        $input = Input::All();
        $value = Admin::updateWithdrawalRequest($input);
        Session::flash('message','Withdrawal Request Processed.');
        return $value;
    }


    public function manageWithdrawalPaid(Request $request){

            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = $request->input('column');
                $userData = Admin::manageWithdrawalPaid($data);
            }else{
                //full data
                $data['param'] = 'null';
                $data['column'] = 'null';
                $userData = Admin::manageWithdrawalPaid($data);
            }
            //create pagination 
            if($userData!=''){
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $col = new Collection($userData);    
                $perPage = 10;
                $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
                $userData->setPath(route('manage-withdrawal-paid'));
            }
            return view('admin.manage_withdrawal_paid')->with('userList',$userData);
    }


    public function manageWithdrawalPaidDownload($param,$column){

        if($param != "" && $column != ""){
            //filter search data
            $data['param']  = $param;
            $data['column'] = $column;
            $userData = Admin::manageWithdrawalPaid($data);
        }else{            
            $data['param']  = $param;
            $data['column'] = $column;
            $userData = Admin::manageWithdrawalPaid($data);
        }
        //download excel        
        if($userData!=''){
            Excel::create('Approve_Withdrawals', function($excel) use ($userData){
                $excel->sheet('Approve_Withdrawals', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.manage_withdrawal_paidExcel',['userList'=>$userData]);
                });
            })->download('xls');
        } 
    }


    public function manageWithdrawalCancel(Request $request){

            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = $request->input('column');
                $userData = Admin::manageWithdrawalCancel($data);
            }else{
                //full data
                $data['param'] = 'null';
                $data['column'] = 'null';
                $userData = Admin::manageWithdrawalCancel($data);
            }
            //create pagination 
            if($userData!=''){
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $col = new Collection($userData);    
                $perPage = 10;
                $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
                $userData->setPath(route('manage-withdrawal-cancel'));
            }
            return view('admin.manage_withdrawal_cancel')->with('userList',$userData);
    }


    public function manageWithdrawalCancelDownload($param,$column){

        if($param != "" && $column != ""){
            //filter search data
            $data['param']  = $param;
            $data['column'] = $column;
            $userData = Admin::manageWithdrawalCancel($data);
        }else{            
            $data['param']  = $param;
            $data['column'] = $column;
            $userData = Admin::manageWithdrawalCancel($data);
        }
        //download excel        
        if($userData!=''){
            Excel::create('Cancel_Withdrawals', function($excel) use ($userData){
                $excel->sheet('Cancel_Withdrawals', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.manage_withdrawal_cancelExcel',['userList'=>$userData]);
                });
            })->download('xls');
        } 
    }


    public function manageOrderBuy(Request $request){ 
        $userData='';
        if($request->isMethod('get') && $request->input('searchparam') == ""  && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') != ''){
                //filter search data(type)
                $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
                $data['type'] = $request->input('type');
                $userData = Admin::manageOrderBuy($data);  

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') == ''){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $userData = Admin::manageOrderBuy($data);

            }else if($request->isMethod('get') && $request->input('searchparam') == "" && $request->input('type') == '' && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::manageOrderBuy($data); 

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('type') == '' && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(date + searchparam)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $data['type'] = ''; 
                $userData = Admin::manageOrderBuy($data);  

            }else if($request->isMethod('get')  && $request->input('type') != '' && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != "" && $request->input('searchparam') == "" && $request->input('searchcolumn') != ""){  
                //filter search data(date + type)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $request->input('type'); 
                $userData = Admin::manageOrderBuy($data);  

            }else if($request->isMethod('get')  && $request->input('type') != '' && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('searchparam') != "" && $request->input('searchcolumn') != ""){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                           
                $data['type'] = $request->input('type');
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::manageOrderBuy($data);  

            }else if($request->isMethod('get')  && $request->input('type') != '' && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){              
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                           
                $data['type'] = $request->input('type');
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $userData = Admin::manageOrderBuy($data); 
            }else{   
                //full data
                $data['start_date'] = $data['end_date'] = $data['searchparam'] = $data['type']= '';
                $userData = Admin::manageOrderBuy($data);                            
        }
        return view('admin.manage_order_buy')->with('userList',$userData);          
    }

    public function manageOrderBuyDownload($datetimepicker1,$datetimepicker2,$type,$searchcolumn,$searchparam){
        $userData='';
        if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 'null'){
            // //filter search data(type)
            $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
            $data['type'] = $type;
            $userData = Admin::manageOrderBuyDownload($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type == 'null'){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $userData = Admin::manageOrderBuyDownload($data);

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 'null'){
                //filter search data(only date)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::manageOrderBuyDownload($data); 

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 'null'){
                //filter search data(date + searchparam)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $data['type'] = ''; 
                $userData = Admin::manageOrderBuyDownload($data);   

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 'null'){                
                //filter search data(date + type)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $type; 
                $userData = Admin::manageOrderBuyDownload($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 'null'){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::manageOrderBuyDownload($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 'null'){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $userData = Admin::manageOrderBuyDownload($data); 
        }else{   
                //full data
                $data['searchparam'] = ''; 
                $data['searchcolumn'] = '';                             
                $data['type'] = '';
                $data['start_date'] = ''; 
                $data['end_date']   = '';
                $userData = Admin::manageOrderBuyDownload($data);                            
        }        

        //download excel        
        if($userData!=''){
            Excel::create('Manage_order_Buy', function($excel) use ($userData){
                $excel->sheet('Manage_order_Buy', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.manage_order_buyExcel',['userList'=>$userData]);
                });
            })->download('xls');
        }   
    }

    public function manageOrderSell(Request $request){ 
        $userData='';
        if($request->isMethod('get') && $request->input('searchparam') == ""  && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') != ''){
                //filter search data(type)
                $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
                $data['type'] = $request->input('type');
                $userData = Admin::manageOrderSell($data);  

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('type') == ''){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $userData = Admin::manageOrderSell($data);

            }else if($request->isMethod('get') && $request->input('searchparam') == "" && $request->input('type') == '' && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::manageOrderSell($data); 

            }else if($request->isMethod('get') && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('type') == '' && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(date + searchparam)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');
                $data['type'] = ''; 
                $userData = Admin::manageOrderSell($data);  

            }else if($request->isMethod('get')  && $request->input('type') != '' && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != "" && $request->input('searchparam') == "" && $request->input('searchcolumn') != ""){  
                //filter search data(date + type)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $request->input('type'); 
                $userData = Admin::manageOrderSell($data);  

            }else if($request->isMethod('get')  && $request->input('type') != '' && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == "" && $request->input('searchparam') != "" && $request->input('searchcolumn') != ""){              
                //filter search data(searchparam + type)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                           
                $data['type'] = $request->input('type');
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::manageOrderSell($data);  

            }else if($request->isMethod('get')  && $request->input('type') != '' && $request->input('searchparam') != "" && $request->input('searchcolumn') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $request->input('searchparam'); 
                $data['searchcolumn'] = $request->input('searchcolumn');                           
                $data['type'] = $request->input('type');
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1')));
                $data['end_date']   = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $userData = Admin::manageOrderSell($data); 
            }else{   
                //full data
                $data['start_date'] = $data['end_date'] = $data['searchparam'] = $data['type']= '';
                $userData = Admin::manageOrderSell($data);                            
        }
        return view('admin.manage_order_sell')->with('userList',$userData);          
    }

    public function manageOrderSellDownload($datetimepicker1,$datetimepicker2,$type,$searchcolumn,$searchparam){
        $userData='';
        if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 'null'){
            // //filter search data(type)
            $data['start_date'] = $data['end_date'] = $data['searchparam'] = '';   
            $data['type'] = $type;
            $userData = Admin::manageOrderSellDownload($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type == 'null'){
                //filter search data(only param)
                $data['start_date'] = $data['end_date'] = $data['type'] = '';                
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $userData = Admin::manageOrderSellDownload($data);

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 'null'){
                //filter search data(only date)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['type'] = $data['searchparam'] = '';                 
                $userData = Admin::manageOrderSellDownload($data); 

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type == 'null'){
                //filter search data(date + searchparam)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;
                $data['type'] = ''; 
                $userData = Admin::manageOrderSellDownload($data);   

        }else if($searchparam == "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 'null'){                
                //filter search data(date + type)
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $data['searchparam'] = $data['searchcolumn'] = '';                
                $data['type'] = $type; 
                $userData = Admin::manageOrderSellDownload($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null" && $type != 'null'){                
                //filter search data(searchparam + type)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $data['end_date'] = ''; 
                $userData = Admin::manageOrderSellDownload($data);  

        }else if($searchparam != "null" && $searchcolumn != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null" && $type != 'null'){                
                //filter search data(searchparam + type + date)
                $data['searchparam'] = $searchparam; 
                $data['searchcolumn'] = $searchcolumn;                             
                $data['type'] = $type;
                $data['start_date'] = $datetimepicker1; 
                $data['end_date']   = $datetimepicker2;
                $userData = Admin::manageOrderSellDownload($data); 
        }else{   
                //full data
                $data['searchparam'] = ''; 
                $data['searchcolumn'] = '';                             
                $data['type'] = '';
                $data['start_date'] = ''; 
                $data['end_date']   = '';
                $userData = Admin::manageOrderSellDownload($data);                            
        }        

        //download excel        
        if($userData!=''){
            Excel::create('Manage_order_Sell', function($excel) use ($userData){
                $excel->sheet('Manage_order_Sell', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.manage_order_sellExcel',['userList'=>$userData]);
                });
            })->download('xls');
        }   
    }



    public function manageProfit(Request $request){

            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = $request->input('column');
                $userData = Admin::manageProfit($data);
            }else if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') == ""){
                //filter search data
                $data['param'] = $request->input('param');
                $data['column'] = 'null';
                $userData = Admin::manageProfit($data);
            }else if($request->isMethod('get') && $request->input('param') == "" && $request->input('column') != ""){
                //filter search data
                $data['param'] = 'null';
                $data['column'] = $request->input('column');
                $userData = Admin::manageProfit($data);
            }else{
                //full data
                $data['param'] = 'null';
                $data['column'] = 'null';
                $userData = Admin::manageProfit($data);
            }
            //create pagination 
            return view('admin.manage_profit')->with('userList',$userData);
    }


    public function manageProfitDownload($param,$column){

            if($param != "null" && $column != "null"){
                $data['param'] = $param;
                $data['column'] = $column;
                $userData = Admin::manageProfitDownload($data);
            }else if($param != "null" && $column == "null"){
                $data['param'] = $param;
                $data['column'] = 'null';
                $userData = Admin::manageProfitDownload($data);
            }else if($param == "null" && $column != "null" ){
                $data['param'] = 'null';
                $data['column'] = $column;
                $userData = Admin::manageProfitDownload($data);
            }else{
                //full data
                $data['param'] = 'null';
                $data['column'] = 'null';
                $userData = Admin::manageProfitDownload($data);
            }

            //download excel        
            if($userData!=''){
                Excel::create('Manage_profit', function($excel) use ($userData){
                    $excel->sheet('Profit', function($sheet) use ($userData)
                    {
                        $sheet->loadView('admin.excel_layout.manage_profitExcel',['userList'=>$userData]);
                    });
                })->download('xls');
            }
    }

    public function get_data(){
        return $userData = Admin::get_data();        
    }

    public function contact_mail(){
        $userData = Admin::contact_mail();
        return view('admin.contact_mail')->with('userList',$userData);;
    }    


    public function bitcoinTransactionList(Request $request){ //dd($request);
        if (!$request->isMethod('post')){
            if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != "" && $request->input('datetimepicker1') == "" && $request->input('datetimepicker2') == ""){
                //filter search data(only param)
                $data['start_date']='';
                $data['end_date']='';
                $data['param'] = $request->input('param'); 
                $data['column'] = $request->input('column');
                $userData = Admin::searchbitcoinTransactionList($data);
                return view('admin.bitcoin_transactions')->with('userList',$userData);   
            
            }else if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(param + date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date'] = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['param'] = $request->input('param'); 
                $data['column'] = $request->input('column');
                $userData = Admin::searchbitcoinTransactionList($data);              
                return view('admin.bitcoin_transactions')->with('userList',$userData);
            
            }else if($request->isMethod('get') && $request->input('param') == "" && $request->input('column') != "" && $request->input('datetimepicker1') != "" && $request->input('datetimepicker2') != ""){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($request->input('datetimepicker1'))); 
                $data['end_date'] = date("Y-m-d", strtotime($request->input('datetimepicker2')));
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::searchbitcoinTransactionList($data);              
                return view('admin.bitcoin_transactions')->with('userList',$userData);
                
            }else{                
                //full data
                $userData = Admin::bitcoinTransactionList();
                return view('admin.bitcoin_transactions')->with('userList',$userData);               
            }
        }else{
            //filter search data
            $data['param'] = $request->input('param');
            $data['column'] = $request->input('column');
            //dd($data);
            $userData = Admin::searchbitcoinTransactionList($data);
            return view('admin.bitcoin_transactions')->with('userList',$userData); 
        } 
    }


    public function bitcoinTransactionListdownload($datetimepicker1,$datetimepicker2,$column,$param){ 
    // dd('here');
        if($param != "null" && $column != "null" && $datetimepicker1 == "null" && $datetimepicker2 == "null"){
                //filter search data(only param)
                $data['start_date']='';
                $data['end_date']='';
                $data['param'] = $param; 
                $data['column'] = $column;
                $userData = Admin::bitcoinTransactionListdownload($data);
                               
        }else if($param != "null" && $column != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null"){
                //filter search data(param + date)
                $data['start_date'] = date("Y-m-d", strtotime($datetimepicker1)); 
                $data['end_date']   = date("Y-m-d", strtotime($datetimepicker2));
                $data['param']      = $param; 
                $data['column']     = $column;
                $userData           = Admin::bitcoinTransactionListdownload($data);       
            
        }else if($param == "null" && $column != "null" && $datetimepicker1 != "null" && $datetimepicker2 != "null"){
                //filter search data(only date)
                $data['start_date'] = date("Y-m-d", strtotime($datetimepicker1)); 
                $data['end_date']   = date("Y-m-d", strtotime($datetimepicker2));
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::bitcoinTransactionListdownload($data);    
        }else{                
                //full data
                $data['start_date'] = ''; 
                $data['end_date'] = '';
                $data['param'] = ''; 
                $data['column'] = '';
                $userData = Admin::bitcoinTransactionListdownload($data);              
            }    
// dd($userData);
        //download excel        
        if($userData!=''){
            Excel::create('bitcoin_transactions', function($excel) use ($userData){
                $excel->sheet('bitcoin_transactions', function($sheet) use ($userData)
                {
                    $sheet->loadView('admin.excel_layout.bitcoinTransactionListExcel',['userList'=>$userData]);
                });
            })->download('xls');
        }   
    }  

    public function tradingPrice(){
        $input= Input::all();
        $value= Admin::tradingPrice($input);
        return $value;
    }

    public function tickerPrice(){
        $input = Input::all();
        $value = Admin::tickerPrice($input);
        return $value;
    }


    // public function userStatement(Request $request){       

    //         if($request->isMethod('get') && $request->input('param') != "" && $request->input('column') != ""){
    //             //filter search data
    //            /* $data['param'] = $request->input('param');
    //             $data['column'] = $request->input('column');
    //             $userData = Admin::manageWithdrawalCancel($data);*/
    //         }else{
    //             //full data
    //             $data['param'] = 'null';
    //             $data['column'] = 'null';
    //             $userData = Admin::userStatement($data);
    //         }            
 
    //         //create pagination 
    //         if($userData!=''){
    //             $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //             $col = new Collection($userData);    
    //             $perPage = 10;
    //             $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    //             $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
    //             $userData->setPath(route('user-statement'));
    //         }
    //         return view('admin.user_statement')->with('userList',$userData); 
    // }



    public function userStatement_show($userId,$sh_type){

        $user=$userId;
        $userId = Crypt::decrypt($userId); 
        $data['userId'] = $userId;
        $data['param']  = 'null';
        $data['column'] = 'null';
        $data['sh_type'] = $sh_type;
        // dd($data);
        $userData = Admin::userStatement($data);
        // dd($userData);
        if($userData!=''){
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $col = new Collection($userData);    
                $perPage = 10;
                $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
                $userData->setPath(route('user-statement-show',['userId'=>$user,'sh_type'=>$sh_type]));
                // dd($userData);

            }
        return view('admin.user_statement')->with('userList',$userData); 

    }

    
    // public function userStatement_show($userId,$sh_type){
    //     $user=$userId;
    //     $userId = Crypt::decrypt($userId); 
    //     $data['userId'] = $userId;
    //     $data['param']  = 'null';
    //     $data['column'] = 'null';
    //     $data['sh_type'] = $sh_type;
    //     $userData = Admin::userStatement($data);
    //     if($userData!=''){
    //             $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //             $col = new Collection($userData);    
    //             $perPage = 10;
    //             $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    //             $userData = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
    //             // dd(route('user-statement-show',['userId'=>$user,'sh_type'=>$sh_type]));
    //             $userData->setPath(route('user-statement-show',['userId'=>$user,'sh_type'=>$sh_type]));
    //             //
    //         }
    //     return view('admin.user_statement')->with('userList',$userData); 

    // }


}
