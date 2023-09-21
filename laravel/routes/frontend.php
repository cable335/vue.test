<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'home'])->name('home');

Route::middleware('auth')->post('/addCarts', [FrontController::class, 'addCart'])->name('product.addCart');

Route::middleware('auth')->get('/shopping-cart', [CartController::class, 'shopping_cart'])->name('user.cart');
