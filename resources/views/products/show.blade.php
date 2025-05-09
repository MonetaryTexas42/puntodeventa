@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
    <p><strong>Precio:</strong> ${{ number_format($product->price,2) }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" class="h-32 mt-4" alt="">
    @endif
    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">
            ← Volver al listado
        </a>
    </div>
</div>
@endsection
