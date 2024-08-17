<?php

use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/customers', CustomerController::class);
Route::apiResource('/suppliers', SupplierController::class);
