<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class StorefrontController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('home'); // Redirigir si el usuario no está autenticado
        }    
        $products = Product::all(); // Obtener todos los productos
        return view('store.storefront', compact('products'));
    }
}
