<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['check-loggedin','check-gauth']], function () {
	Route::get('/funding','UserController@funding')->name('funding');
	Route::get('/kyc','UserController@reverify_kyc')->name('kyc');
	Route::post('/kyc','UserController@kyc_details');
	Route::any('/generate_address', 'UserController@generate_address');
	Route::post('/itbit', 'UserController@itbit');
	Route::post('/check_checked','UserController@check_checked')->name('check_checked');
	Route::post('/check_unchecked','UserController@check_unchecked')->name('check_unchecked');
	Route::get('/check_bitcoin', 'UserController@check_bitcoin_payment');
	Route::post('/check_bitcoin', 'UserController@check_bitcoin_payment_ajax');
	Route::post('/bank_details', 'UserController@bank_details');
	Route::get('/g-security', 'UserController@g_security')->name('g_security');
	Route::get('/profile', 'UserController@profile');
	Route::post('/profile', 'UserController@update_profile');
	Route::get('/settings', 'UserController@profile');
	Route::post('/settings', 'UserController@update_profile');
	Route::get('/trading', 'UserController@trading'); 
	Route::post('/support','UserController@support')->name('support_us');
	Route::get('/faq','UserController@faq')->name('faq');
	Route::get('/accepted-documents','UserController@accepted_documents')->name('accepted-documents');
	Route::get('/compliance','UserController@compliance')->name('compliance');
	Route::get('/deposit-id','UserController@deposit_id')->name('deposit-id');
	Route::get('/faq-bitcoin','UserController@faq_bitcoin')->name('faq-bitcoin');
	Route::get('/faq-open','UserController@faq_open')->name('faq-open');
	Route::get('/faq-overview','UserController@faq_overview')->name('faq-overview');
	Route::get('/faq-trade-history','UserController@faq_trade_history')->name('faq-trade-history');
	Route::get('/faq-why','UserController@faq_why')->name('faq-why');
	Route::get('/fee-structure','UserController@fee_structure')->name('fee-structure');
	Route::get('/holidays','UserController@holidays')->name('holidays');
	Route::get('/deposit-schedule-us','UserController@deposit_schedule_us')->name('deposit_schedule_us');
	Route::get('/fund-my-account','UserController@fund_my_account')->name('fund_my_account');
	Route::get('/withdraw-my-funds','UserController@withdraw_my_funds')->name('withdraw_my_funds');
	Route::get('/fiat-withdrawal-processing','UserController@fiat_withdrawal_processing')->name('fiat_withdrawal_processing');
	Route::get('/how-long-verify','UserController@how_long_verify')->name('how-long-verify');
	Route::get('/how-to-close-account','UserController@how_to_close_account')->name('how-to-close-account');
	Route::get('/how-to-create-account','UserController@how_to_create_account')->name('how-to-create-account');
	Route::get('/manage-account','UserController@manage_account')->name('manage-account');
	Route::get('/order-support','UserController@order_support')->name('order-support');
	Route::get('/recover-username','UserController@recover_username')->name('recover-username');
	Route::get('/start-Trading','UserController@start_Trading')->name('start-Trading');
	Route::get('/trade-with','UserController@trade_with')->name('trade-with');
	Route::get('/trading-desk','UserController@trading_desk')->name('trading-desk');
	Route::get('/verification','UserController@verification')->name('verification');
	Route::get('/withdrawal-limits','UserController@withdrawal_limits')->name('withdrawal-limits');



	Route::post('/trading', 'UserController@trading_order'); 
	Route::get('/trading_history', 'UserController@trading_history');
	Route::post('/thpdata', 'UserController@thpdata'); 
	Route::post('/current_btc_price', 'UserController@current_btc_price'); 
	Route::post('/order_book', 'UserController@order_book'); 
	// Route::get('/orders_status', 'UserController@check_orders'); 
	Route::get('/cancel_order/{txn?}', 'UserController@cancel_order'); 
	Route::get('/withdraw', 'UserController@withdraw_amount'); 
	Route::post('/bank', 'UserController@addbank'); 
	Route::post('/bank_det', 'UserController@getbank'); 
	Route::post('/ubank', 'UserController@updatebank'); 
	Route::get('/dbank/{bid?}', 'UserController@deletebank'); 
}); 

Route::get('/', 'UserController@index');
Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@loginpost')->name('loginpost');
Route::get('/signup', 'UserController@signup');
Route::post('/signup', 'UserController@signuppost')->name('signuppost');
Route::get('/forgot_password','UserController@forgot_password')->name('forgot_password');
Route::post('/forgot_password','UserController@forgot_password_post')->name('forgot_password_post');
Route::any('/check_username','UserController@check_username');
Route::get('forgot_pass/{token}',['uses'=>'UserController@reset_password_get','as'=>'forgot_pass']);
Route::post('forgot_pass/{token}',['uses'=>'UserController@reset_password_post','as'=>'forgot_pass_post']);
Route::get('/confirm/{rem_token}', 'UserController@confirmUser');
Route::get('/contact_us','UserController@contact_us')->name('contact_us');
Route::post('/contact_us','UserController@contact_us_p')->name('contact_usp');
Route::get('/user_details','UserController@user_detailspage')->name('user_details');
Route::post('/user_details','UserController@user_details');
Route::get('/verify_kyc','UserController@kyc_detailspage')->name('verify_kyc');
Route::post('/verify_kyc','UserController@kyc_details');
Route::get('/kyc_skip','UserController@kyc_skip')->name('kyc_skip');
Route::get('/user_authent','UserController@user_authentpage')->name('user_authentpage');
Route::get('/user_authent_skip','UserController@user_authent_skip')->name('user_authent_skip');
Route::post('/validate2fa', 'UserController@gValidateToken');
Route::get('/validateemail','UserController@validateemail');
Route::get('/user_authenticat','UserController@user_authenticat')->name('user_authenticat'); 
Route::post('/fetch-country-code', 'UserController@fetchCountryCode');
Route::get('/exchange',[ 'uses' => 'UserController@exchange' ,'as' => 'exchange']);
Route::get('/legal',['uses'=>'UserController@legal','as'=>'legal']);
Route::get('/about-bitcoin','UserController@aboutbitcoin');
Route::get('/how-it-works','UserController@howitworks');
Route::get('/about', 'UserController@about');
Route::get('/security', 'UserController@security');
Route::get('/support', 'UserController@support');
Route::get('/logout', 'UserController@logout');


Route::group(array('prefix'=>'organize'),function(){
	    Route::get('/',['uses'=>'admincontroller@login', 'as'=>'login12']);
	    Route::get('login',['uses'=>'admincontroller@login', 'as'=>'login']);    
	    Route::post('loginprocess',['uses'=>'admincontroller@loginprocess', 'as'=>'loginprocess']);     
	    Route::group(array('middleware'=>'is_admin'),function(){
	        Route::get('dashboard',['uses'=>'admincontroller@dashboard', 'as'=>'dashboard']);
	        Route::get('logout',['uses'=>'admincontroller@logout', 'as'=>'logout']);
	        Route::any('manage_user',['uses'=>'admincontroller@manageUser','as'=>'manage_user']);
			Route::get('admin-edit-user/{userId}',['uses'=>'admincontroller@adminEditUser','as'=>'admin-edit-user']);
			Route::post('update-userinfo',['uses'=>'admincontroller@updateUserinfo','as'=>'update-userinfo']);
			Route::post('update-userkycinfo',['uses'=>'admincontroller@updateUserkycinfo','as'=>'update-userkycinfo']);
        	Route::post('update_userstatus',['uses'=>'admincontroller@updateUserStatus','as'=>'update_userstatus']);
        	// Route::get('manage-deposit',['uses'=>'admincontroller@manageDeposit','as'=>'manage-deposit']);
        	Route::get('bank-transactions',['uses'=>'admincontroller@bankTransactionList','as'=>'bank-transactions']);
        	Route::get('manage-deposits',['uses'=>'admincontroller@manageDeposits','as'=>'manage-deposits']);
        	Route::post('update_user_action_status',['uses'=>'admincontroller@updateUserActionStatus','as'=>'update_user_action_status']);

        	Route::get('bankTransactionListdownload/{datetimepicker1}/{datetimepicker2}/{column}/{param}',['uses'=>'admincontroller@bankTransactionListdownload','as'=>'bankTransactionListdownload']);
			Route::get('manageDepositsDownload/{datetimepicker1}/{datetimepicker2}/{type}/{column}/{param}',['uses'=>'admincontroller@manageDepositsDownload','as'=>'manageDepositsDownload']); 
			Route::post('select_user',['uses'=>'admincontroller@select_user','as'=>'select_user']);

	        Route::post('select_ref_amt',['uses'=>'admincontroller@select_ref_amt','as'=>'select_ref_amt']);
	        Route::post('user_wallet',['uses'=>'admincontroller@user_wallet','as'=>'user_wallet']);
	        Route::any('manage-wallet',['uses'=>'admincontroller@manageWallet','as'=>'manage-wallet']);



	        Route::get('manageWalletDownload/{datetimepicker1}/{datetimepicker2}/{type}/{column}/{param}',['uses'=>'admincontroller@manageWalletDownload','as'=>'manageWalletDownload']);
        
        Route::any('settings',['uses'=>'admincontroller@manageSettings','as'=>'settings']);    
        Route::any('update_auth',['uses'=>'admincontroller@updateAuth','as'=>'update_auth']);    
        Route::any('update_rate',['uses'=>'admincontroller@updateRate','as'=>'update_rate']);
        Route::get('manageSettingDownload/{param}/{column}',['uses'=>'admincontroller@manageSettingDownload','as'=>'manageSettingDownload']);

	    });    
	});
