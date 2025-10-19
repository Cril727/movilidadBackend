<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiciletaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/loginAdmin', [AuthController::class, 'loginAdmin']);
Route::post('/loginUsuario', [AuthController::class, 'loginUsuario']);


Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);


    //User routes
    Route::post('/addUser', [UserController::class, 'store']);
    Route::get('/userByRolAdmin', [UserController::class, 'userByRolAdmin']);
    Route::get('/userById/{id}', [UserController::class, 'userById']);
    Route::put('/updateUser/{id}', [UserController::class, 'update']);
    Route::delete('/deleteUser/{id}', [UserController::class, 'delete']);
    Route::get('/users', [UserController::class, 'index']);

    //bicycle routes
    Route::post('/addBicycle', [BiciletaController::class, 'store']);
    Route::get('/BicycleById/{id}', [BiciletaController::class, 'userById']);
    Route::put('/updateBicycle/{id}', [BiciletaController::class, 'update']);
    Route::delete('/deleteBicycle/{id}', [BiciletaController::class, 'delete']);
    Route::get('/Bicycles', [BiciletaController::class, 'index']);

    //loan rotes
    Route::post('/addB', [BiciletaController::class, 'store']);
    Route::get('/BicycleById/{id}', [BiciletaController::class, 'userById']);
    Route::put('/updateBicycle/{id}', [BiciletaController::class, 'update']);
    Route::delete('/deleteBicycle/{id}', [BiciletaController::class, 'delete']);
    Route::get('/Bicycles', [BiciletaController::class, 'index']);

});
