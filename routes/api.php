<?php

use App\Http\Controllers\API\V1\EmployeesController;
use App\Http\Controllers\Api\V1\InventoryPrController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/products', [ProductController::class,'index']);
Route::post('/products_store', [ProductController::class,'store']);
Route::post('/products_update/{id}', [ProductController::class,'update']);
Route::post('/products_delete/{id}', [ProductController::class,'destroy']);
Route::post('/employees', [EmployeesController::class,'index']);
Route::post('/employees_store', [EmployeesController::class,'store']);
Route::post('/employees_update/{id}', [EmployeesController::class,'update']);
Route::post('/employees_delete/{id}', [EmployeesController::class,'destroy']);
Route::post('/inventory_pr_store', [InventoryPrController::class,'store']);
