<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0', // Validar stock como entero no negativo
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar imagen (opcional)
        ]);

        //Manejar si se ha enviado una foto
            $imagePath = $request->file('image')->store('products', 'public'); // Guardar imagen en el disco público

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imagePath, // Guardar la ruta de la imagen
        ]);
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required|string', // Añade validación para la descripción si es opcional
        ]);


        $product = Product::find($id);
        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function storefront()
{
    $products = Product::where('stock', '>', 0)->get();
    return view('storefront', compact('products'));
}


}
