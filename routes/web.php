<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageProductController;
use App\Http\Controllers\WebHookController;
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

Route::get('/',[LoginController::class,'getAcessStore']);
Route::match(['get', 'post'], '/install', [LoginController::class,'login']);
Route::get('welcome',function(){
    echo "welcome page";
    dd(Session::get('store_id'));
});




Route::prefix('admin')->group(function () {
    Route::get('dashboard', [LoginController::class,"dashboard"]);
    Route::prefix('webhook')->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('access-permission', [WebHookController::class,'accessPermission']);

        });
    });


    Route::resource('products', ManageProductController::class);
    Route::get('list-product', [ManageProductController::class,"getListProduct"]);
});



