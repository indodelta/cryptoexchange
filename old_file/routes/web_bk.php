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

Route::get('/', 'UserController@index');
Route::get('/about-bitcoin','UserController@aboutbitcoin');
Route::get('/how-it-works','UserController@howitworks');
Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@loginpost')->name('loginpost');
Route::get('/signup', 'UserController@signup');
Route::post('/signup', 'UserController@signuppost')->name('signuppost');
Route::get('/about', 'UserController@about');
Route::get('/security', 'UserController@security');
Route::get('/support', 'UserController@support');
Route::get('/confir', 'UserController@confirmUser');
Route::post('/user/user_details','UserController@user_details');

Route::get('/validateemail','UserController@validateemail');

//Route::get('/verify_kyc','UserController@verify_kyc')->name('verify_kyc');

Route::get('/test',function(){

	return View('user.verify_kyc');
});