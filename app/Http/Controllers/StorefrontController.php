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
            return redirect()->route('home'); 
        }    
        $products = Product::all();
        return view('store.storefront', compact('products'));
    }
}
