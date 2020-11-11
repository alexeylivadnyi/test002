<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RevenueEmailController;
use App\Http\Controllers\RevenueSummaryController;
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

Route::resource('/revenues/summary', RevenueSummaryController::class)->only('index');
Route::resource('/revenues', RevenueController::class);
Route::resource('/revenues/email', RevenueEmailController::class)->only('store');
Route::resource('/products', ProductController::class)->only('index');
Route::resource('/clients', ClientController::class)->only('index');

