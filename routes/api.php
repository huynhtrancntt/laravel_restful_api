<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('customers/bulk', 'CustomerController@bulkStore');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('users', App\Http\Controllers\UserController::class);

Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/profile', [App\Http\Controllers\AuthController::class, 'profile'])->middleware('auth:sanctum');

Route::group(['middleware' => 'api'], function () {
    // Route để đăng nhập
    Route::post('/auth/login_jwt', [App\Http\Controllers\AuthController::class, 'login_jwt']);

    // Route để đăng xuất
    Route::post('/auth/logout_jwt', [App\Http\Controllers\AuthController::class, 'logout_jwt']);

    // Route để lấy thông tin profile người dùng, yêu cầu quyền 'update1'
    Route::get('/auth/profile_jwt', [App\Http\Controllers\AuthController::class, 'profile_jwt'])
    ->middleware(['auth.jwt', 'permission:edit']);
});



