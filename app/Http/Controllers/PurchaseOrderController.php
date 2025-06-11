<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->paginate(10);
        return view('admin.purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.purchase_orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0'
        ]);

        $totalAmount = 0;
        $productsData = [];

        foreach ($request->products as $product) {
            $productModel = Product::findOrFail($product['id']);
            $unitCost = $product['unit_cost'] > 0 ? $product['unit_cost'] : $productModel->price;
            $totalAmount += $product['quantity'] * $unitCost;
            $productsData[] = [
                'id' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_cost' => $unitCost, 
                'product_price' => $productModel->price 
            ];
        }

        Log::info('Creating purchase order', [
            'supplier_id' => $request->supplier_id,
            'products' => $productsData,
            'total_amount' => $totalAmount,
            'raw_products' => $request->products 
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'status' => 'pending',
            'total_amount' => $totalAmount
        ]);

        foreach ($productsData as $product) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_cost' => $product['unit_cost'] 
            ]);
        }

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order created.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'items.product');
        return view('admin.purchase_orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase_orders.index')->with('error', 'Only pending purchase orders can be edited.');
        }
        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseOrder->load('items.product');
        return view('admin.purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase_orders.index')->with('error', 'Only pending purchase orders can be edited.');
        }

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0'
        ]);

        $totalAmount = 0;
        $productsData = [];

        foreach ($request->products as $product) {
            $productModel = Product::findOrFail($product['id']);
            $unitCost = $product['unit_cost'] > 0 ? $product['unit_cost'] : $productModel->price;
            $totalAmount += $product['quantity'] * $unitCost;
            $productsData[] = [
                'id' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_cost' => $unitCost, 
                'product_price' => $productModel->price 
            ];
        }

        Log::info('Updating purchase order', [
            'purchase_order_id' => $purchaseOrder->id,
            'supplier_id' => $request->supplier_id,
            'products' => $productsData,
            'total_amount' => $totalAmount,
            'raw_products' => $request->products 
        ]);

        $purchaseOrder->update([
            'supplier_id' => $request->supplier_id,
            'total_amount' => $totalAmount
        ]);

        $purchaseOrder->items()->delete();
        foreach ($productsData as $product) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_cost' => $product['unit_cost'] 
            ]);
        }

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order updated.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->items()->delete();
        $purchaseOrder->delete();
        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order deleted.');
    }

    public function receive(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase_orders.index')->with('error', 'Purchase Order is not pending.');
        }

        $operationType = OperationType::where('name', 'stock-in')->firstOrFail();

        foreach ($purchaseOrder->items as $item) {
            $product = $item->product;
            $product->stock_quantity += $item->quantity;
            $product->save();

            Operation::create([
                'product_id' => $item->product_id,
                'operation_type_id' => $operationType->id,
                'supplier_id' => $purchaseOrder->supplier_id,
                'quantity' => $item->quantity,
                'operation_date' => now()->toDateString()
            ]);
        }

        $purchaseOrder->update(['status' => 'received']);
        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order received.');
    }

    public function cancel(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase_orders.index')->with('error', 'Purchase Order is not pending.');
        }

        $purchaseOrder->update(['status' => 'canceled']);
        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order canceled.');
    }
}