<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtherServicesController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('otherService', [OtherServicesController::class, 'create']);
Route::get('otherService/{otherServices}', [OtherServicesController::class, 'show']);
Route::get('otherServices', [OtherServicesController::class, 'index']);
Route::post('otherService/{otherServices}', [OtherServicesController::class, 'update']);
Route::delete('otherService/{otherServices}', [OtherServicesController::class, 'destroy']);

