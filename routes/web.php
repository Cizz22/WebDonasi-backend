<?php

use App\Http\Controllers\admin\CampaignController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DonationController;
use App\Http\Controllers\admin\DonaturController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\SliderController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::prefix('admin')->group(function () {

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function() {

        //route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::resource('category', CategoryController::class,['as' => 'admin']);
        Route::resource('campaign', CampaignController::class,['as' => 'admin']);
        Route::resource('donatur',DonaturController::class,['as' => 'admin']);
        Route::get('/donation', [DonationController::class, 'index'])->name('admin.donation.index');
        Route::get('/donation/filter', [DonationController::class, 'filter'])->name('admin.donation.filter');
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::resource('slider', SliderController::class, ['as' => 'admin']);
    });
});
