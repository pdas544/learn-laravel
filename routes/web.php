<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// User related routes

Route::get('/', [UserController::class,'showCorrectHomePage'])->name('login');

Route::post('/register',[UserController::class,'register'])->middleware('guest');

Route::post('/login',[UserController::class,'login'])->middleware('guest');

Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

Route::get( '/manage-avatar',[UserController::class,'showAvatar']);
Route::post( '/manage-avatar',[UserController::class,'storeAvatar']);

//Post related routes
Route::post('/create-post',[PostController::class,'createNewPost'])->middleware('auth');
Route::get('/create-post',[PostController::class,'showForm'])->middleware('auth');
Route::get('/post/{post}',[PostController::class,'showSinglePost']) ;
Route::delete('/post/{post}',[PostController::class,'deletePost'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class,'updatePost'])->middleware('can:update,post');

//Profile related routes
Route::get('/profile/{user:username}',[UserController::class,'showProfile']);
