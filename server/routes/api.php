<?php

use App\Http\Controllers\api\v1\userController;
use App\Http\Controllers\api\v1\videoController;
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
Route::prefix('v1')->group(function(){
    Route::middleware('auth:api')->group(function(){
        Route::prefix('video')->group(function(){
            Route::post('/',[videoController::class,'store']);
            Route::put('/{id}',[videoController::class,'update']);
            Route::delete('/{id}',[videoController::class,'delete']);
        });
        Route::prefix('user')->group(function(){
            Route::post('/user-profile',[userController::class,'userProfile']);
            Route::get('/video',[userController::class,'userVideo']);
        });
        
    });

    Route::prefix('video')->group(function(){
        Route::get('/',[videoController::class,'index']);
        Route::get('/{id}',[videoController::class,'show']);
        Route::post('/searchResult',[videoController::class,'searchResult']);
    });
    Route::prefix('user')->group(function(){
        Route::post('/',[userController::class,'register']);
        Route::post('/login',[userController::class,'login']);
    });
});
