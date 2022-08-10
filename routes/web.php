<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('blog', BlogController::class);

Route::resource('adminkelolaakun', AdminkelolaakunController::class);
Route::get('adminkelolaakun/update', 'AdminKelolaakunController@update')->name('adminkelolaakunupdate');

// PRODUCT
Route::get('product', [ProductController::class,'index'])->name('product-index');
Route::post('product/store', [ProductController::class,'store'])->name('product-store');
Route::get('product/create', [ProductController::class,'create'])->name('product-create');
Route::delete('product/{id}', [ProductController::class,'destroy'])->name('product-destroy');
// Route::get('product/{id}', [ProductController::class,'update'])->name('product-update');
// Route::get('product/{id}', [ProductController::class,'show'])->name('product-show');
Route::get('product/{id}/edit', [ProductController::class,'edit'])->name('product-edit');
// END PRODUCT
