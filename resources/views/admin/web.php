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
	Route::get('/cancel_with','UserController@cancel_with')->name('cancel_with');
	Route::get('/accepted-documents','UserController@accepted_documents')->name('accepted-documents');
	Route::get('/required-documents','UserController@required_documents')->name('required-documents');
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
	Route::get('/why_are_bitcoin_prices_different','UserController@why_are_bitcoin_prices_different')->name('why_are_bitcoin_prices_different');
	Route::get('/support_bitcoin_forks',"UserController@support_bitcoin_forks")->name('support_bitcoin_forks');
	Route::get('/why_can_t_my_onboarding_be_completed',"UserController@why_can_t_my_onboarding_be_completed")->name('why_can_t_my_onboarding_be_completed');
	Route::get('/i_didn_t_receive_my_verification_email',"UserController@i_didn_t_receive_my_verification_email")->name('i_didn_t_receive_my_verification_email');
	Route::get('/i_haven_t_received_my_bitcoin_withdrawal',"UserController@i_haven_t_received_my_bitcoin_withdrawal")->name('i_haven_t_received_my_bitcoin_withdrawal');
	Route::get('/my_deposit_hasn_t_been_applied_to_my_account',"UserController@my_deposit_hasn_t_been_applied_to_my_account")->name('my_deposit_hasn_t_been_applied_to_my_account');

	Route::get('/my_2fa_is_not_syncing',"UserController@my_2fa_is_not_syncing")->name('my_2fa_is_not_syncing');
	Route::get('/how_to_report_an_perfekt',"UserController@how_to_report_an_perfekt")->name('how_to_report_an_perfekt');
	Route::get('/get_access_to_the_perfektpay_api',"UserController@get_access_to_the_perfektpay_api")->name('get_access_to_the_perfektpay_api');
	Route::get('/what_is_rest_api',"UserController@what_is_rest_api")->name('what_is_rest_api');
	Route::get('/what_is_fix_api',"UserController@what_is_fix_api")->name('what_is_fix_api');
	Route::get('/s_security_unique',"UserController@s_security_unique")->name('s_security_unique');
	Route::get('/recaptcha_isn_t_appearing',"UserController@recaptcha_isn_t_appearing")->name('recaptcha_isn_t_appearing');
	Route::get('/website_isn_t_loading_correctly',"UserController@website_isn_t_loading_correctly")->name('website_isn_t_loading_correctly');
	Route::get('/have_a_market_data_api',"UserController@have_a_market_data_api")->name('have_a_market_data_api');
	Route::get('/why_is_it_important',"UserController@why_is_it_important")->name('why_is_it_important');
	Route::get('/move_any_funds',"UserController@move_any_funds")->name('move_any_funds');
	Route::get('/need_to_file',"UserController@need_to_file")->name('need_to_file');
	Route::get('/file_bitcoin_income',"UserController@file_bitcoin_income")->name('file_bitcoin_income');
	Route::get('/kept_private_and_secure',"UserController@kept_private_and_secure")->name('kept_private_and_secure');
	Route::get('/why_do_i_need_it',"UserController@why_do_i_need_it")->name('why_do_i_need_it');
	Route::get('/how_to_add_2fa',"UserController@how_to_add_2fa")->name('how_to_add_2fa');
	Route::get('/how_to_reset_2fa',"UserController@how_to_reset_2fa")->name('how_to_reset_2fa');
	Route::get('/weekly_client',"UserController@weekly_client")->name('weekly_client');
	Route::get('/industry_alert',"UserController@industry_alert")->name('industry_alert');
	Route::get('/apis_perfektpay_support',"UserController@apis_perfektpay_support")->name('apis_perfektpay_support');


	Route::get('/order-support','UserController@order_support')->name('order-support');
	Route::get('/recover-username','UserController@recover_username')->name('recover-username');
	Route::get('/start-Trading','UserController@start_Trading')->name('start-Trading');
	Route::get('/trade-with','UserController@trade_with')->name('trade-with');
	Route::get('/trading-desk','UserController@trading_desk')->name('trading-desk');
	Route::get('/verification','UserController@verification')->name('verification');
	Route::get('/withdrawal-limits','UserController@withdrawal_limits')->name('withdrawal-limits');
	Route::post('/bank_sub','UserController@bank_sub')->name('bank_sub');
	Route::post('/btc_sub','UserController@btc_sub')->name('btc_sub');
	Route::get('/down_csv','UserController@down_csv')->name('down_csv');

	Route::post('/trading', 'UserController@trading_order'); 
	Route::get('/trading_history', 'UserController@trading_history')->name('trading_history');
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
Route::get('/forgot-password','UserController@forgot_password')->name('forgot_password');
Route::post('/forgot-password','UserController@forgot_password_post')->name('forgot_password_post');
Route::any('/check_username','UserController@check_username');
Route::get('forgot_pass/{token}',['uses'=>'UserController@reset_password_get','as'=>'forgot_pass']);
Route::post('forgot_pass/{token}',['uses'=>'UserController@reset_password_post','as'=>'forgot_pass_post']);
Route::get('/confirm/{rem_token}', 'UserController@confirmUser');
Route::get('/contact-us','UserController@contact_us')->name('contact_us');
Route::post('/contact-us','UserController@contact_us_p')->name('contact_usp');
Route::get('/user_details','UserController@user_detailspage')->name('user_details');
Route::post('/user_details','UserController@user_details');
Route::get('/verify_kyc','UserController@kyc_detailspage')->name('verify_kyc');
Route::post('/verify_kyc','UserController@kyc_details');
Route::get('/kyc_skip','UserController@kyc_skip')->name('kyc_skip');
Route::get('/user_authent','UserController@user_authentpage')->name('user_authentpage');
Route::get('/user_authent_skip','UserController@user_authent_skip')->name('user_authent_skip');
Route::post('/validate2fa', 'UserController@gValidateToken');
Route::post('/my_noti',"UserController@my_noti")->name('my_noti');
Route::get('/validateemail','UserController@validateemail');
Route::get('/user_authenticat','UserController@user_authenticat')->name('user_authenticat'); 
Route::post('/fetch-country-code', 'UserController@fetchCountryCode');
Route::get('/bitcoin-exchange',[ 'uses' => 'UserController@exchange' ,'as' => 'exchange']);
Route::get('/legal',['uses'=>'UserController@legal','as'=>'legal']);
Route::get('/terms-of-use',['uses'=>'UserController@legal','as'=>'legal']);
Route::get('/privacy-policy',['uses'=>'UserController@legal','as'=>'legal']);
Route::get('/about-bitcoin','UserController@aboutbitcoin');
Route::get('/how-it-works','UserController@howitworks');
Route::get('/about-us', 'UserController@about');
Route::get('/security', 'UserController@security');
Route::get('/support', 'UserController@support');
Route::get('/logout', 'UserController@logout');
Route::post('/market_price', 'UserController@market_price')->name("market_price");


Route::group(array('prefix'=>'organize'),function(){
	    Route::get('/',['uses'=>'admincontroller@login', 'as'=>'login12']);
	    Route::get('login',['uses'=>'admincontroller@login', 'as'=>'login']);    
	    Route::post('loginprocess',['uses'=>'admincontroller@loginprocess', 'as'=>'loginprocess']);     
	    Route::group(array('middleware'=>'is_admin'),function(){
	        Route::get('dashboard',['uses'=>'admincontroller@dashboard', 'as'=>'dashboard']);
	        Route::get('logout',['uses'=>'admincontroller@logout', 'as'=>'logout']);
	        Route::any('manage_user',['uses'=>'admincontroller@manageUser','as'=>'manage_user']);
	        Route::get('manageuserDownload/{column}/{param}',['uses'=>'admincontroller@manageuserDownload','as'=>'manageuserDownload']);
			Route::get('admin-edit-user/{userId}',['uses'=>'admincontroller@adminEditUser','as'=>'admin-edit-user']);
			Route::post('update-userinfo',['uses'=>'admincontroller@updateUserinfo','as'=>'update-userinfo']);
			Route::post('update-userkycinfo',['uses'=>'admincontroller@updateUserkycinfo','as'=>'update-userkycinfo']);
        	Route::post('update_userstatus',['uses'=>'admincontroller@updateUserStatus','as'=>'update_userstatus']);
        	// Route::get('manage-deposit',['uses'=>'admincontroller@manageDeposit','as'=>'manage-deposit']);
        	Route::get('bank-transactions',['uses'=>'admincontroller@bankTransactionList','as'=>'bank-transactions']);
        	Route::get('manage-deposits',['uses'=>'admincontroller@manageDeposits','as'=>'manage-deposits']);
        	Route::post('update_user_action_status',['uses'=>'admincontroller@updateUserActionStatus','as'=>'update_user_action_status']);
        	Route::post('update_user_action_status_bit',['uses'=>'admincontroller@updateUserActionStatus_bit','as'=>'update_user_action_status_bit']);
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
	        Route::get('manage-withdrawal-request',['uses'=>'admincontroller@manageWithdrawalRequest','as'=>'manage-withdrawal-request']);
	        Route::post('update_withdrawal_request',['uses'=>'admincontroller@updateWithdrawalRequest','as'=>'update_withdrawal_request']);    
	        Route::get('manage-withdrawal-paid',['uses'=>'admincontroller@manageWithdrawalPaid','as'=>'manage-withdrawal-paid']);
	        Route::get('manageWithdrawalPaidDownload/{param}/{column}',['uses'=>'admincontroller@manageWithdrawalPaidDownload','as'=>'manageWithdrawalPaidDownload']);
	        Route::get('manage-withdrawal-cancel',['uses'=>'admincontroller@manageWithdrawalCancel','as'=>'manage-withdrawal-cancel']);
	        Route::get('manageWithdrawalCancelDownload/{param}/{column}',['uses'=>'admincontroller@manageWithdrawalCancelDownload','as'=>'manageWithdrawalCancelDownload']);
	        Route::get('manage-order-buy',['uses'=>'admincontroller@manageOrderBuy','as'=>'manage-order-buy']);
			Route::get('manageOrderBuyDownload/{datetimepicker1}/{datetimepicker2}/{type}/{column}/{param}',['uses'=>'admincontroller@manageOrderBuyDownload','as'=>'manageOrderBuyDownload']);
			Route::get('manage-order-sell',['uses'=>'admincontroller@manageOrderSell','as'=>'manage-order-sell']);
			Route::get('manageOrderSellDownload/{datetimepicker1}/{datetimepicker2}/{type}/{column}/{param}',['uses'=>'admincontroller@manageOrderSellDownload','as'=>'manageOrderSellDownload']);
			Route::get('manage-profit',['uses'=>'admincontroller@manageProfit','as'=>'manage-profit']);
			Route::get('manageProfitDownload/{param}/{column}',['uses'=>'admincontroller@manageProfitDownload','as'=>'manageProfitDownload']);			
			Route::post('get_data',['uses'=>'admincontroller@get_data','as'=>'get_data']);
			Route::get('contact-mail',['uses'=>'admincontroller@contact_mail','as'=>'contact-mail']);
			Route::any('bitcoin-transactions',['uses'=>'admincontroller@bitcoinTransactionList','as'=>'bitcoin-transactions']);
			Route::get('bitcoinTransactionListdownload/{datetimepicker1}/{datetimepicker2}/{column}/{param}',['uses'=>'admincontroller@bitcoinTransactionListdownload','as'=>'bitcoinTransactionListdownload']);
 			Route::post('trading_price',['uses'=>'admincontroller@tradingPrice','as'=>'trading_price']);
 			Route::post('ticker_price',['uses'=>'admincontroller@tickerPrice','as'=>'ticker_price']);
 			

 			Route::get('user-statement',['uses'=>'admincontroller@userStatement','as'=>'user-statement']);

 			Route::get('user-statement-show/{userId}',['uses'=>'admincontroller@userStatement_show','as'=>'user-statement-show']);

		    });     
	});
Route::group(array('prefix'=>'api'),function(){
    Route::get('/system-check-bitcoin-payment',['uses'=>'UserController@cron_check_bitcoin_payment', 'as'=>'system-check-bitcoin-payment']);
});
