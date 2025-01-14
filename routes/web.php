<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;

Route::get('/', [UserController::class,'showCorrectHomePage']);

// Route::get('/about',[ExampleController::class,'about']);

Route::post('/register',[UserController::class,'register']) ;

Route::post('/login',[UserController::class,'login']) ;

Route::post('/logout',[UserController::class,'logout']) ;
