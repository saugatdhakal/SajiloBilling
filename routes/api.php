<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;



//Public Routes
Route::post('/registeruser', [UserController::class, 'register'])->name('registerUser');
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/createUser', [UserController::class, 'createUser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/getUsers', [UserController::class, 'getUsers']);
    Route::delete('/deleteUser/{id}', [UserController::class, 'deleteUser']);
    Route::get('/getUserDetail', [UserController::class, 'getUserDetail']);
    Route::post('/user/updateUserPasswords/{id}',[UserController::class, 'updateUserPasswords']);
    Route::get('/user/getUserDetails/{id}', [UserController::class, 'getUserDetails']);
    Route::post('/user/UpdateUserDetails/{id}', [UserController::class, 'UpdateUserDetails']);

    Route::post('/account/createAccount', [AccountController::class, 'createAccount']);
    Route::get('/account/getAccounts', [AccountController::class, 'getAccounts']);

});
