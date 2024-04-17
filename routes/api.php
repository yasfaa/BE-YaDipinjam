<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::prefix('/auth')->group(function () {
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
    Route::post('/get',[AuthController::class,'getUser'])->middleware('auth:sanctum');
});

Route::prefix('/book')->group(function () {
    Route::post('/get-by-ISBN',[BookController::class,'fetchBook']);
    Route::post('/store',[BookController::class,'createBook']);
    Route::post('/upload',[BookController::class,'upload'])->middleware('auth:sanctum');
    Route::post('/upload-picture',[BookController::class,'storeCirculatedPicture']);
    Route::get('/get-by-title', [BookController::class,'getByTitle']);
    Route::get('/get-by-isbn', [BookController::class,'getByISBN']);
    Route::get('/picture/{filename}', [BookController::class,'showPicture']);
    Route::post('/get-picture', [BookController::class,'getPicture']);


});

Route::prefix('/publisher')->group(function () {
    Route::post('/store',[PublisherController::class,'create']);
    Route::get('/get', [PublisherController::class,'get']);
    Route::get('/gets', [PublisherController::class,'getID']);
});

Route::prefix('/author')->group(function () {
    Route::post('/store',[AuthorController::class,'create']);
    Route::get('/get', [AuthorController::class,'get']);
});

Route::prefix('/rent')->group(function () {
    Route::post('/borrow',[AuthorController::class,'create']);
    Route::get('/get', [AuthorController::class,'get']);
})->middleware('auth:sanctum');
