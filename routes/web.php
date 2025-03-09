<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Auth;

// Ruta raíz
Route::get('/', function () {
    // Verifica si el usuario está autenticado
    if (Auth::check()) {
        // Verifica si el usuario es un administrador
        if (Auth::user()->role === 'admin') {
            return redirect()->route('products.index'); // Redirige a la página de productos
        }
        return redirect()->route('storefront'); // Redirige al storefront si es cliente
    }

    return redirect()->route('login'); // Redirige al login si no está autenticado
})->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rutas para el carrito
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// Rutas de productos
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // Agregar esta línea
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Ruta para almacenar el producto
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/add-stock', [ProductController::class, 'addStock'])->name('products.addStock');
});

// Ruta para el storefront
Route::get('/storefront', [StorefrontController::class, 'index'])->name('storefront');



// Otras rutas
require __DIR__.'/auth.php';
