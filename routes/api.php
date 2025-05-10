<?php

use App\Http\Controllers\Api\BlogsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get("/blogs",[BlogsController::class,"index"]);
Route::get("/blogs/{id}",[BlogsController::class,"show"]);
