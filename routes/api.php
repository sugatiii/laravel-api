<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

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


    //students
    Route::get('students',[StudentController::class,'getAllStudent']);
    Route::get('students/{id}',[StudentController::class,'getByid']);
    Route::post('students',[StudentController::class,'student']);
    Route::post('students/{id}',[StudentController::class,'update']);
    Route::delete('students/{id}',[StudentController::class,'delete']);


    Route::post('login', [AuthController::class,'login']);
    Route::group(['middleware'=>'api'],function(){
        Route::post('logout', [AuthController::class,'logout']);
        Route::post('refresh', [AuthController::class,'refresh']);
        Route::post('me', [AuthController::class,'me']);

    });

    

