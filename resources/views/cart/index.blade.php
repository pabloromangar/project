@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mi Carrito</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->price }} €</td>
                    <td>{{ $item->product->price * $item->quantity }} €</td>
                    <td>
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @php $total += $item->product->price * $item->quantity; @endphp
            @endforeach
        </tbody>
    </table>

    <h3>Total: {{ $total }} €</h3>

    <form action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <button class="btn btn-success">Comprar</button>
    </form>
</div>
@endsection
