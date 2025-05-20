<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'minimum_quantity' => $request->minimum_quantity,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|unique:products,code,' . $product->id,
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'minimum_quantity' => $request->minimum_quantity,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }

    public function lowStock()
    {
        $products = Product::whereColumn('stock_quantity', '<', 'minimum_quantity')->get();
        return view('products.low_stock', compact('products'));
    }
}