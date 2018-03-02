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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout/{code}', 'CheckoutController@view');

Auth::routes();

Route::namespace('Panel')
    ->middleware('auth')
    ->prefix('panel')
    ->group(function () {
    
    Route::get('/', 'InvoiceController@index');
    Route::get('/transaction/{code}', 'InvoiceController@view');

    Route::get('/withdrawal', 'WithdrawalController@index');

    Route::get('/account', 'UserController@view');
    Route::get('/settings', 'UserController@edit');
    Route::put('/settings', 'UserController@update');
    Route::put('/settings/token', 'UserController@updateToken');
    Route::post('/settings/token/send', 'UserController@sendToken');
});
