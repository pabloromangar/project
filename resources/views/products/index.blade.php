@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos</h1>
    
    <div class="mb-3">
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
                <th>Añadir stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="align-middle">{{ $product->id }}</td>
                <td class="align-middle">{{ $product->name }}</td>
                <td class="align-middle">{{ $product->price }}</td>
                <td class="align-middle">{{ $product->stock }}</td>
                <td class="align-middle">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">Ver</a>
                </td>
                <td>
                    <form action="{{ route('products.addStock', $product->id) }}" method="POST" class="d-flex flex-column">
                        @csrf
                        <label for="quantity" class="form-label">Cantidad a añadir:</label>
                        <input type="number" name="quantity" id="quantity" min="1" class="form-control" required>
                        <button type="submit" class="btn btn-success mt-2">Añadir Stock</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row d-flex justify-content-center">
        <div class="col text-center">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Crear Producto</a>
            </div>
    </div>
</div>
@endsection
