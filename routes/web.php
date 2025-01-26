<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// User related routes

Route::get('/', [UserController::class,'showCorrectHomePage'])->name('login');

Route::post('/register',[UserController::class,'register'])->middleware('guest');

Route::post('/login',[UserController::class,'login'])->middleware('guest');

Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//Post related routes
Route::post('/create-post',[PostController::class,'createNewPost'])->middleware('auth');
Route::get('/create-post',[PostController::class,'showForm'])->middleware('auth');
Route::get('/post/{post}',[PostController::class,'showSinglePost']) ;

//Profiel related routes
Route::get('/profile/{user:username}',[UserController::class,'showProfile']);
