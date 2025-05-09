<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Muestra el listado de productos.
     */
    public function index()
    {
        // Obtiene todos los productos
        $products = Product::all();
        // Retorna la vista con la colección
        return view('products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Almacena un producto recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los datos entrantes
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // opcional, max 2MB
        ]);

        // Si hay imagen, la guarda en storage/app/public/products
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Crea el producto
        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra un producto específico.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualiza el producto en la base de datos.
     */
    public function update(Request $request, Product $product)
    {
        // Valida los datos entrantes
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Si suben nueva imagen, reemplaza la anterior
        if ($request->hasFile('image')) {
            // Opcional: eliminar la imagen vieja con Storage::delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Actualiza el producto
        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(Product $product)
    {
        // Opcional: eliminar la imagen asociada con Storage::delete($product->image);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
