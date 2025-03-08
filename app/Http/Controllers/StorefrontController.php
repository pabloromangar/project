<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StorefrontController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Obtener todos los productos
        return view('store.storefront', compact('products'));
    }
}
