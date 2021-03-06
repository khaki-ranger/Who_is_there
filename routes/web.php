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

// 基本設定 vendor\laravel\framework\src\Illuminate\Routing\Router.php  ->auth()
// Auth::routes();

// Authentication Routes...
Route::get(env("LOGIN_PATH"), 'Auth\LoginController@showLoginForm')->name('login');
Route::post(env("LOGIN_PATH"), 'Auth\LoginController@login');
Route::post("logout", 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get(env("REGISTER_PATH"), 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post(env("REGISTER_PATH"), 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get(env("PASSWORD_PATH").'/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post(env("PASSWORD_PATH").'/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get(env("PASSWORD_PATH").'/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post(env("PASSWORD_PATH").'/reset', 'Auth\ResetPasswordController@reset');

// ホーム画面タイトル表示のみで非ログインは遷移無し
Route::get('/', 'IndexController@welcome');
// メイン画面 滞在者一覧 or home画面
Route::get(env("INDEX_PATH"), 'IndexController@index')->name('index');

// 管理画面 認証済みuserのみ表示
Route::get('/admin_user', 'AdminUserController@index')->middleware('auth');
Route::get('/admin_user/edit{id?}', 'AdminUserController@edit')->middleware('auth');
Route::post('/admin_user/update', 'AdminUserController@update')->middleware('auth');

Route::get('/admin_user/add', 'AdminUserController@add')->middleware('auth');
Route::post('/admin_user/create', 'AdminUserController@create')->middleware('auth');

Route::get('/admin_mac_address', 'AdminMacAddressController@index')->middleware('auth');
Route::get('/admin_mac_address/edit{id?}', 'AdminMacAddressController@edit')->middleware('auth');
Route::post('/admin_mac_address/update', 'AdminMacAddressController@update')->middleware('auth');

// 外部からのPOST受け取り先 csrf off
Route::post('/inport_post/mac_address', 'InportPostController@MacAddress');

// 外部へのPOST送信 route必要?
Route::post('/push_ifttt_arraival', 'ExportPostController@push_ifttt_arraival');
