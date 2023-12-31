<?php

use App\Http\Controllers\ProductController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Backend/Dashboard');
    })->name('dashboard');
    Route::get('/Product',[ProductController::class,'index'])->name('product.list');
    Route::get('/Product/Create',[ProductController::class,'create'])->name('product.create');
    Route::post('/Product/Store',[ProductController::class,'store'])->name('product.store');
    Route::delete('/Product/Delete',[ProductController::class,'delete'])->name('product.delete');
    Route::get('/Product/Edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::put('/Product/update',[ProductController::class,'update'])->name('product.update');
});
