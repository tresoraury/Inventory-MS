<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
            'quantity' => 'required|integer|min:1',
            'operation_date' => 'required|date',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        Operation::create($request->all());
        return redirect()->route('operations.index')->with('success', 'Operation created.');
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
            'quantity' => 'required|integer|min:1',
            'operation_date' => 'required|date',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $operation->update($request->all());
        return redirect()->route('operations.index')->with('success', 'Operation updated.');
    }

    public function destroy(Operation $operation)
    {
        $operation->delete();
        return redirect()->route('operations.index')->with('success', 'Operation deleted.');
    }
}