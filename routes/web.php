<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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

Route::controller(CategoryController::class)
    ->prefix("categories")
    ->name("categories.")
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("create", "create")->name("create");
        Route::post("save", "save")->name("save");
    });

Route::controller(ProductController::class)
    ->prefix("products")
    ->name("products.")
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("create", "create")->name("create");
        Route::post("save", "save")->name("save");
    });
