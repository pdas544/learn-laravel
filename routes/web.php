<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// User related routes

Route::get('/', [UserController::class,'showCorrectHomePage']);

Route::post('/register',[UserController::class,'register']) ;

Route::post('/login',[UserController::class,'login']) ;

Route::post('/logout',[UserController::class,'logout']) ;

//Post related routes
Route::post('/create-post',[PostController::class,'createNewPost']) ;
Route::get('/create-post',[PostController::class,'showForm']) ;
