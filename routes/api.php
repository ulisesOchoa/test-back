<?php

use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\QualityController;
use App\Http\Controllers\api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/customers/initform', [CustomerController::class, 'initForm']);
Route::get('/customers/export', [CustomerController::class, 'export']);

Route::apiResource('/customers', CustomerController::class);
Route::apiResource('/suppliers', SupplierController::class);
Route::apiResource('/qualities', QualityController::class);

