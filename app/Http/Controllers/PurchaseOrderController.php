<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'status' => 'pending'
        ]);

        foreach ($request->products as $product) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
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
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        $purchaseOrder->update([
            'supplier_id' => $request->supplier_id,
        ]);

        $purchaseOrder->items()->delete();
        foreach ($request->products as $product) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);
        }

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order updated.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Delete associated items to avoid foreign key constraint
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
                'operation_date' => now()
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