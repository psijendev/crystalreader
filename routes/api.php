<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DocumentController;
use App\Http\Controllers\Api\V1\BookmarkController;
use App\Http\Controllers\Api\V1\CatalogController;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('/documents', DocumentController::class);
    Route::apiResource('/catalogs',  CatalogController::class);
    Route::apiResource('/bookmarks', BookmarkController::class);//->middleware(['auth:sanctum']);

    Route::get('/showDocumentsOfCatalog/{id}', [CatalogController::class, 'showDocumentsOfCatalog'])->where('id', '[0-9]+');


    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);


    // Route::get('/bookmarks', [BookmarkController::class,'index'])->middleware(['auth:sanctum']);
    // Route::get('/bookmarks/{id}', [BookmarkController::class,'show'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
    // Route::post('/bookmarks', [BookmarkController::class,'store'])->middleware(['auth:sanctum']);
});

