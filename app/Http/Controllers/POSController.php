<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Operation;
use App\Models\OperationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock.');
        }

        DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);
            $product->stock_quantity -= $request->quantity;
            $product->save();

            Operation::create([
                'product_id' => $request->product_id,
                'operation_type_id' => OperationType::where('name', 'sale')->first()->id,
                'quantity' => $request->quantity,
                'operation_date' => now()->toDateString(),
            ]);
        });

        return redirect()->route('pos.index')->with('success', 'Sale recorded.');
    }
}