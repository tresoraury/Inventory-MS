<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $sales = Sale::with('product', 'customer')->latest()->take(10)->get();
        return view('pos.index', compact('products', 'sales'));
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('pos.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'nullable|exists:customers,id',
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
            'customer_id' => $request->customer_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update product stock
        $product->stock_quantity -= $request->quantity;
        $product->save();

        // Record operation
        $operationType = OperationType::where('name', 'stock-out')->firstOrFail();
        Operation::create([
            'product_id' => $product->id,
            'operation_type_id' => $operationType->id,
            'quantity' => $request->quantity,
            'operation_date' => now(),
        ]);

        return redirect()->route('pos.index')->with('success', 'Sale recorded successfully.');
    }

    public function edit(Sale $sale)
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('pos.edit', compact('sale', 'products', 'customers'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Revert old quantity to stock
        $oldProduct = $sale->product;
        $oldProduct->stock_quantity += $sale->quantity;
        $oldProduct->save();

        // Check new stock availability
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->route('pos.index')->with('error', 'Insufficient stock for ' . $product->name);
        }

        $totalPrice = $product->price * $request->quantity;

        if ($totalPrice > 99999999.99) {
            return redirect()->route('pos.index')->with('error', 'Total price exceeds maximum allowed value.');
        }

        $sale->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $totalPrice,
            'customer_id' => $request->customer_id,
            'updated_at' => now(),
        ]);

        // Update product stock
        $product->stock_quantity -= $request->quantity;
        $product->save();

        // Update operation
        $operationType = OperationType::where('name', 'stock-out')->firstOrFail();
        Operation::where('product_id', $sale->product_id)
            ->where('operation_type_id', $operationType->id)
            ->where('quantity', $sale->quantity)
            ->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'operation_date' => now(),
            ]);

        return redirect()->route('pos.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $product = $sale->product;
        $product->stock_quantity += $sale->quantity;
        $product->save();

        $sale->delete();

        return redirect()->route('pos.index')->with('success', 'Sale deleted successfully.');
    }
}