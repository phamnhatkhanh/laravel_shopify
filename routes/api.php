<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\WebHookController;


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



Route::prefix('webhook')->group(function () {
        Route::prefix('products')->group(function () {
        // Route::get('/access-permission', [WebHookController::class,'accessPermission']);
            Route::any('/create', [WebHookController::class,'createProduct']);
            Route::any('/update', [WebHookController::class,'updateProduct']);
            Route::any('/delete', [WebHookController::class,'deleteProduct']);
        });

        Route::prefix('app')->group(function () {
            Route::any('/uninstalled', [WebHookController::class,'deleteApp']);
        });
    });
// Route::prefix('admin')->group(function () {


//     Route::resource('product', ManageProductController::class);
// });
