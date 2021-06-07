<?php

use App\Http\Controllers\api\CampaignController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\DonationController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\RegisterController;
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

Route::get('/donation', [DonationController::class, 'index'])->middleware('auth:api');
Route::post('/donation', [DonationController::class, 'store'])->middleware('auth:api');
Route::post('/donation/notification', [DonationController::class, 'notificationHandler']);


Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth:api');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth:api');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('auth:api');


Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/categoryHome', [CategoryController::class, 'categoryHome']);


Route::get('/campaign', [CampaignController::class,'index']);
Route::get('/campaign/{slug}', [CampaignController::class, 'show']);


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
