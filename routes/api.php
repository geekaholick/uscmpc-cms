<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumerStoreController;

use App\Models\ConsumerStore;

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

Route::get('/consumer_stores/{status?}', [ConsumerStoreController::class,'index']);
Route::post('/consumer_store', [ConsumerStoreController::class,'store']);
Route::put('/consumer_stores/{id}', [ConsumerStoreController::class,'update']);
Route::delete('/consumer_stores/{id}',[ConsumerStoreController::class,'destroy']);
