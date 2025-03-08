<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Product;
use App\Http\Controllers\StorefrontController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('products', ProductController::class)->middleware('auth');
Route::resource('cart', CartController::class)->middleware('auth');

Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');


Route::get('/storefront', [StorefrontController::class, 'index'])->name('storefront')->middleware('auth');
Route::get('/', [StorefrontController::class, 'index'])->name('storefront')->middleware('auth');


// Rutas para el storefront
Route::get('/', [StorefrontController::class, 'index'])->name('storefront');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Mostrar el carrito
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store'); // Añadir un producto al carrito
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.remove'); // Eliminar un producto del carrito
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Realizar la compra
});
