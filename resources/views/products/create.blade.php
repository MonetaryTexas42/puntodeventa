@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Crear Producto</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block">Nombre</label>
            <input type="text" name="name" class="w-full border rounded px-2 py-1" required>
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Precio</label>
            <input type="number" name="price" step="0.01" class="w-full border rounded px-2 py-1" required>
            @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Stock</label>
            <input type="number" name="stock" class="w-full border rounded px-2 py-1" value="0" required>
            @error('stock') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Imagen</label>
            <input type="file" name="image" accept="image/*" class="w-full">
            @error('image') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar
        </button>
    </form>
</div>
@endsection
