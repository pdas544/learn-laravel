<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[UserController::class,'loginApi']);

//create a new post
Route::post('/create-post',[PostController::class,'createPostApi'])->middleware('auth:sanctum');

//delete a post
Route::delete('/delete-post/{post}',[PostController::class,'deletePostApi'])->middleware('auth:sanctum', 'can:delete,post');
