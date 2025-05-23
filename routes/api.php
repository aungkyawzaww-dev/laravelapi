<?php

use App\Http\Controllers\Api\BlogsController;
use App\Http\Controllers\Api\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get("/blogs",[BlogsController::class,"index"]);
Route::get("/blogs/search",[BlogsController::class,"search"]);
Route::get("/blogs/{id}",[BlogsController::class,"show"]);
Route::post("/blogs",[BlogsController::class,"store"]);
Route::put("/blogs/{id}",[BlogsController::class,"update"]);
Route::delete("/blogs/{id}",[BlogsController::class,"destroy"]);


Route::apiResource("/categories", CategoriesController::class);