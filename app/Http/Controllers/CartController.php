<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get(); // Obtener artículos del carrito para el usuario
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        // Lógica para añadir un producto al carrito
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index');
    }

    public function destroy(Cart $cart)
{
    // Reponer el stock del producto
    $product = $cart->product;
    $product->increment('stock', $cart->quantity);
    
    // Eliminar el artículo del carrito
    $cart->delete();

    return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
}


    public function update(Request $request, Cart $cart)
{
    // Validar que la cantidad no supere el stock disponible
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    if ($request->quantity > $cart->product->stock + $cart->quantity) {
        return redirect()->route('cart.index')->with('error', 'Stock insuficiente para actualizar la cantidad.');
    }

    // Actualizar la cantidad del carrito
    $cart->update(['quantity' => $request->quantity]);

    return redirect()->route('cart.index')->with('success', 'Cantidad actualizada.');
}

// En CartController.php
public function addToCart(Product $product)
{
    if (auth()->user()->role === 'admin') {
        // Redirigir a la página de productos si es un administrador
        return redirect()->route('products.index')->with('error', 'Los administradores no pueden comprar.');
    }

   if($product->stock > 0) {
    $cartItem = Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first();

    if($cartItem) {
        $cartItem->increment('quantity');
        $product->decrement('stock');
    }else{
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $product->decrement('stock');

        return redirect()->route('storefront')->with('success', 'Producto añadido al carrito');
    }
    return redirect() ->route('storefront')->with('error', 'Stock insuficiente');
   }

}



// App\Http\Controllers\CartController.php

public function checkout()
{
    $cartItems = Cart::where('user_id', auth()->id())->get();

    // Generar la factura en un archivo de texto
    $invoiceData = "Factura\n\n";
    $total = 0;

    foreach ($cartItems as $item) {
        $subtotal = $item->product->price * $item->quantity;
        $invoiceData .= "{$item->product->name} - {$item->quantity} x {$item->product->price} € = {$subtotal} €\n";
        $total += $subtotal;
    }
    $invoiceData .= "\nTotal: {$total} €\n";

    // Guardar la factura en un archivo
    $invoiceFile = storage_path('invoices/invoice_' . auth()->id() . '_' . time() . '.txt');
    file_put_contents($invoiceFile, $invoiceData);

    // Vaciar el carrito
    Cart::where('user_id', auth()->id())->delete();

    return redirect()->route('cart.index')->with('success', 'Compra realizada con éxito. Factura generada.');
}

}
