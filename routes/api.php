<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);
Route::post('recover', [AuthController::class, 'recover']);
Route::post('reset', [AuthController::class, 'restore_password']);
Route::get('me', [AuthController::class, 'me']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/movements', [MovementController::class, 'index']);
    Route::post('/movements/records', [MovementController::class, 'getMovements']);
    Route::put('/movements', [MovementController::class, 'store']);
    Route::post('/movements/update/{id}', [MovementController::class, 'update']);
    Route::delete('/movements/{id}', [MovementController::class, 'destroy']);

    Route::put('/categories', [CategoryController::class, 'store']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});




