<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->middleware('token')->group(function () {
    Route::post('/checkout', 'InvoiceController@checkout');
    Route::get('/notification/{code}', 'NotificationController@check');
    Route::get('/transaction/{code}', 'InvoiceController@transaction');
    Route::get('/transactions', 'InvoiceController@transactions');
});
