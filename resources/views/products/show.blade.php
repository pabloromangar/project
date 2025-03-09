@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Detalles del Producto</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> <span class="text-muted">{{ $product->id }}</span></p>
            <p><strong>Nombre:</strong> <span class="text-primary">{{ $product->name }}</span></p>
            <p><strong>Precio:</strong> <span class="text-success">{{ $product->price }} €</span></p>
            <p><strong>Descripción:</strong> <span class="text-muted">{{ $product->description }}</span></p>
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen del producto" class="img-fluid" style="max-width: 300px;">
            </div>
            <p><strong>Stock:</strong> <span class="badge bg-info">{{ $product->stock }}</span></p>
            <div class="text-center mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
                @auth
                @if (auth()->user()->role === 'admin')
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Editar</a>
                @else
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                </form>
                @endif
                @endauth
                
            </div>
        </div>
    </div>
</div>
@endsection