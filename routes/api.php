<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;

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

Route::post('banner', [BannerController::class, 'create']);
Route::get('banner/{id}', [BannerController::class, 'showBanner']);
Route::get('all/banners', [BannerController::class, 'show']);
Route::post('banner/{banner}', [BannerController::class, 'update']);
Route::delete('banner/{banner}', [BannerController::class, 'destroy']);