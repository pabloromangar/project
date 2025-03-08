@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles del Producto</h1>
        <p><strong>ID:</strong> {{ $product->id }}</p>
        <p><strong>Nombre:</strong> {{ $product->name }}</p>
        <p><strong>Precio:</strong> {{ $product->price }}</p>
        <p><strong>Descripción:</strong> {{$product->description}}</p>
        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen del producto">
        <p><strong>Stock:</strong> {{$product->stock}}</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Volver a la lista</a>
    </div>
@endsection
