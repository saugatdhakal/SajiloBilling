<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SupplierController;

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



    Route::controller(AccountController::class)
    ->prefix('account')
    ->group(function () {
        Route::post('/createAccount',  'createAccount');
        Route::get('/getAccounts',  'getAccounts');
        Route::delete('/softDelete/{id}',  'softDeleteAccount');
        Route::get('/getAccountDetails/{id}',  'getAccountDetails');
        Route::post('/updateAccount/{id}',  'updateAccount');
        Route::get('/softDeletes',  'getSoftDeleteAccounts');
        Route::delete('/forceDeleteAccount/{id}',  'forceDeleteAccount');
    });

    Route::controller(SupplierController::class)
    ->prefix('supplier')
    ->group(function () {
            Route::post('/supplierCreate','create');
            Route::get('/supplierDeatils','getSupplierDeatils');

    });

});
