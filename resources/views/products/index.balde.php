@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Productos</h1>
        <a href="{{ route('products.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
           Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="bg-blue-100 text-blue-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">Nombre</th>
                <th class="border px-2 py-1">Precio</th>
                <th class="border px-2 py-1">Stock</th>
                <th class="border px-2 py-1">Imagen</th>
                <th class="border px-2 py-1">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
            <tr>
                <td class="border px-2 py-1">{{ $p->id }}</td>
                <td class="border px-2 py-1">{{ $p->name }}</td>
                <td class="border px-2 py-1">${{ number_format($p->price,2) }}</td>
                <td class="border px-2 py-1">{{ $p->stock }}</td>
                <td class="border px-2 py-1">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="h-12" alt="">
                    @else
                        —
                    @endif
                </td>
                <td class="border px-2 py-1 space-x-2">
                    <a href="{{ route('products.edit', $p) }}"
                       class="text-blue-600 hover:underline">Editar</a>
                    <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('¿Eliminar este producto?')"
                                class="text-red-600 hover:underline">
                          Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">No hay productos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
