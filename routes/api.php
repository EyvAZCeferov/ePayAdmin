<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignsController;
use App\Http\Controllers\Api\CardsController;
use App\Http\Controllers\Api\ContactusController;
use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\PartnersController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\ShopBagController;
use App\Http\Controllers\NotificationsController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post("register", [AuthController::class, 'register'])->name('api.register');
    Route::post("forgetpass", [AuthController::class, 'forgetpass'])->name('api.forgetpass');
    Route::post("login", [AuthController::class, 'login'])->name('api.login');
    Route::get("logout", [AuthController::class, 'logout'])->name('api.logout')->middleware('auth:api');
    Route::get("user", [AuthController::class, 'user'])->name('api.user')->middleware('auth:api');
});

Route::resource('campaigns', CampaignsController::class);
Route::resource('customers', CustomersController::class);
Route::resource('locations', LocationsController::class);
Route::resource('contactus', ContactusController::class);
Route::resource('partners', PartnersController::class);
Route::resource('products', ProductsController::class);

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('cards', CardsController::class);
    Route::resource('shopp_bag', ShopBagController::class);
    Route::resource('notifications', NotificationsController::class);
    Route::get('notification_view/{id}', [NotificationsController::class, 'notification_view']);
});
