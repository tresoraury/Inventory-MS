<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $sales = Sale::with('product')->latest()->take(10)->get();
        return view('pos', compact('products', 'sales'));
    }

    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);

    if ($product->stock_quantity < $request->quantity) {
        return redirect()->route('pos.index')->with('error', 'Insufficient stock for ' . $product->name);
    }

    $totalPrice = $product->price * $request->quantity;

    if ($totalPrice > 99999999.99) {
        return redirect()->route('pos.index')->with('error', 'Total price exceeds maximum allowed value.');
    }

    Sale::create([
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'price' => $totalPrice,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Update product stock
    $product->stock_quantity -= $request->quantity;
    $product->save();

    return redirect()->route('pos.index')->with('success', 'Sale recorded successfully.');
}
}