<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvestmentController;

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

Route::get('investments/{status?}', [InvestmentController::class, 'index']);
Route::post('investments/', [InvestmentController::class, 'store']);
Route::put('investments/{id}', [InvestmentController::class, 'update']);
Route::delete('investments/{id}', [InvestmentController::class, 'destroy']);
