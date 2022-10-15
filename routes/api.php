<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\ResultController;

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

Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware'=>'api', 'prefix'=>'auth'], function($router){

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::group(['middleware'=>'api', 'prefix'=>'create'], function($router){

    Route::post('/location', [CreateController::class, 'location']);

    Route::post('/category', [CreateController::class, 'category']);

    Route::post('/subcategory', [CreateController::class, 'subcategory']);

    Route::post('/item', [CreateController::class, 'item']);

    Route::post('/file', [CreateController::class, 'file']);

    Route::post('/product', [CreateController::class, 'product']);

});


Route::get('/results', [ResultController::class, 'results']);