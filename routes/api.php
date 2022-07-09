<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('bond/payouts/{id}', [App\Http\Controllers\BondController::class, 'index']);


Route::post('bond/orden/{id}', [App\Http\Controllers\OrderController::class, 'store']);
Route::post('bond/order/{order_id}', [App\Http\Controllers\OrderController::class, 'storePercent']);

