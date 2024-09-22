<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\TransactionController;
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

Route::apiResource('/products',ProductsController::class);
Route::apiResource('/categories',CategoriesController::class);
Route::get('/productsData',[ProductsController::class,'datatable']);
Route::get('/categoriesTable',[CategoriesController::class,'datatable'])->name('categories.table');

Route::get('get-products/{categoryId}', [ProductsController::class, 'getProductsByCategory'])->name('get.products');

Route::apiResource('/transactions',TransactionController::class);
Route::get('/transactionTable',[TransactionController::class,'datatable'])->name('transaction.table');
Route::get('/reportTable',[TransactionController::class,'reportTable'])->name('report.table');