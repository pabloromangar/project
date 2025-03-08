@extends('layouts.app')

@section('content')
    <h1>Catálogo de Productos</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Imagen</th>
            <th>Acción</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }} €</td>
            <td>{{ $product->stock }}</td>
            <td><img src="{{ asset('storage/' . $product->image) }}" alt="Imagen" width="50"></td>
            <td>
                @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit">Añadir al carrito</button>
                </form>
                @else
                <p>Inicia sesión para comprar</p>
                @endauth
            </td>
        </tr>
        @endforeach
    </table>
@endsection
