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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/brand', [App\Http\Controllers\BrandController::class, 'index']);
Route::get('/brand/{id}/edit', [App\Http\Controllers\BrandController::class, 'edit']);
Route::post('/brand/add', [App\Http\Controllers\BrandController::class, 'store']);
Route::put('/brand/{id}', [App\Http\Controllers\BrandController::class, 'update']);
Route::delete('/brand/delete/{id}', [App\Http\Controllers\BrandController::class, 'destroy']);


Route::get('/shipping',[App\Http\Controllers\ShippingController::class,'index']);
Route::get('/shipping/{id}/edit',[App\Http\Controllers\ShippingController::class,'edit']);
Route::post('shipping/add',[App\Http\Controllers\ShippingController::class,'store']);
Route::put('/shipping/{id}',[App\Http\Controllers\ShippingController::class,'update']);
Route::delete('/shipping/delete/{id}',[App\Http\Controllers\ShippingController::class,'destroy']);


Route::get('/payment',[App\Http\Controllers\PaymentController::class,'index']);
Route::get('/payment/{id}/edit',[App\Http\Controllers\PaymentController::class,'edit']);
Route::post('payment/add',[App\Http\Controllers\PaymentController::class,'store']);
Route::put('/payment/{id}',[App\Http\Controllers\PaymentController::class,'update']);
Route::delete('/payment/delete/{id}',[App\Http\Controllers\PaymentController::class,'destroy']);