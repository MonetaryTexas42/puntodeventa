<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($data['product_id']);

    $sale = Sale::create([
        'user_id' => Auth::id(),
        'total'   => $product->price * $data['quantity'],
    ]);

    $saleItem = SaleItem::create([
        'sale_id'    => $sale->id,
        'product_id' => $product->id,
        'quantity'   => $data['quantity'],
        'price'      => $product->price,
    ]);

    $product->decrement('stock', $data['quantity']);

    return response()->json([
        'product_id'   => $product->id,
        'new_stock'    => $product->stock,
        'quantity'     => $data['quantity'],
        'product_name' => $product->name,
    ]);
}

}
