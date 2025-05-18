<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Product;
use App\Models\OperationType;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    public function index()
    {
        $operations = Operation::with(['product', 'operationType', 'supplier'])->get();
        return view('operations.index', compact('operations'));
    }

    public function create()
    {
        $products = Product::all();
        $operationTypes = OperationType::all();
        $suppliers = Supplier::all();
        return view('operations.create', compact('products', 'operationTypes', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'operation_type_id' => 'required|exists:operation_types,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'operation_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $operationType = OperationType::find($request->operation_type_id);
            $product = Product::find($request->product_id);

            if ($operationType->name === 'purchase') {
                $product->stock_quantity += $request->quantity;
            } elseif ($operationType->name === 'sale') {
                $product->stock_quantity -= $request->quantity;
            } elseif ($operationType->name === 'adjustment') {
                $product->stock_quantity = $request->quantity;
            }

            $product->save();
            Operation::create($request->all());
        });

        return redirect()->route('operations.index')->with('success', 'Operation recorded.');
    }

    public function edit(Operation $operation)
    {
        $products = Product::all();
        $operationTypes = OperationType::all();
        $suppliers = Supplier::all();
        return view('operations.edit', compact('operation', 'products', 'operationTypes', 'suppliers'));
    }

    public function update(Request $request, Operation $operation)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'operation_type_id' => 'required|exists:operation_types,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'operation_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $operation) {
            $oldOperationType = OperationType::find($operation->operation_type_id);
            $product = Product::find($operation->product_id);

            if ($oldOperationType->name === 'purchase') {
                $product->stock_quantity -= $operation->quantity;
            } elseif ($oldOperationType->name === 'sale') {
                $product->stock_quantity += $operation->quantity;
            }

            $newOperationType = OperationType::find($request->operation_type_id);
            if ($newOperationType->name === 'purchase') {
                $product->stock_quantity += $request->quantity;
            } elseif ($newOperationType->name === 'sale') {
                $product->stock_quantity -= $request->quantity;
            } elseif ($newOperationType->name === 'adjustment') {
                $product->stock_quantity = $request->quantity;
            }

            $product->save();
            $operation->update($request->all());
        });

        return redirect()->route('operations.index')->with('success', 'Operation updated.');
    }

    public function destroy(Operation $operation)
    {
        DB::transaction(function () use ($operation) {
            $operationType = OperationType::find($operation->operation_type_id);
            $product = Product::find($operation->product_id);

            if ($operationType->name === 'purchase') {
                $product->stock_quantity -= $operation->quantity;
            } elseif ($operationType->name === 'sale') {
                $product->stock_quantity += $operation->quantity;
            }

            $product->save();
            $operation->delete();
        });

        return redirect()->route('operations.index')->with('success', 'Operation deleted.');
    }
}