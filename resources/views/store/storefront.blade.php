@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Catálogo de Productos</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="align-middle">{{ $product->name }}</td>
                <td class="align-middle">{{ $product->price }} €</td>
                <td class="align-middle">{{ $product->stock }}</td>
                <td class="align-middle">
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen" width="100" class="img-thumbnail">
                    </a>
                </td>
                <td class="align-middle">
                    @auth
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                    </form>
                    @else
                    <p class="text-danger">Inicia sesión para comprar</p>
                    @endauth
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection