<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\Api\TransactionController;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
})->name('dashboard');
Route::get('/products',function(){
    $data['categories'] = Categories::all();
    return view('pages.products',$data);
})->name('products');
Route::get('/categories',[CategoriesController::class,'index'])->name('categories');
Route::get('/transactions',[TransactionController::class,'index'])->name('transaction');
Route::get('/reports',[TransactionController::class,'report'])->name('reports');