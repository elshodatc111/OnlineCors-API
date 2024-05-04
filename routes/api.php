<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\CatigoryController;
use App\Http\Controllers\CoursController;

// Register
Route::post('/register', [ApiAuthController::class,'register']);
Route::post('/login', [ApiAuthController::class,'login']);

Route::get('/catigore', [CatigoryController::class,'index']);
Route::get('/catigore/{id}', [CatigoryController::class,'show']);

Route::get('/cours', [CoursController::class,'index']);
Route::get('/cours/show/{id}', [CoursController::class,'show']);

Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post('/register/admin', [ApiAuthController::class,'registerAdmin']);
    Route::post('/register/techer', [ApiAuthController::class,'registerTecher']);

    Route::post('/cours/create', [CoursController::class,'store']);
    Route::put('/cours/update/{id}', [CoursController::class,'update']);

    Route::get('/student', [ApiAuthController::class,'student']);
    Route::get('/admin', [ApiAuthController::class,'admin']);
    Route::get('/techer', [ApiAuthController::class,'techer']);
    Route::get('/user/{id}', [ApiAuthController::class,'user']);
    Route::delete('/user/delete/{id}', [ApiAuthController::class,'userDelete']);

    Route::get('/profel', [ApiAuthController::class,'profel']);
    Route::get('/logout', [ApiAuthController::class,'logout']);

    Route::post('/catigore/create', [CatigoryController::class,'store']);
    Route::put('/catigore/update/{id}', [CatigoryController::class,'update']);
    Route::delete('/catigore/{id}', [CatigoryController::class,'destroy']);
});

