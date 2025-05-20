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
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'operation_date' => 'required|date',
        ]);

        Operation::create($request->all());

        return redirect()->route('operations.index')->with('success', 'Operation created successfully.');
    }

    public function edit($id)
    {
        $operation = Operation::findOrFail($id);
        $products = Product::all();
        $operationTypes = OperationType::all();
        $suppliers = Supplier::all();
        return view('operations.edit', compact('operation', 'products', 'operationTypes', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'operation_type_id' => 'required|exists:operation_types,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'operation_date' => 'required|date',
        ]);

        $operation = Operation::findOrFail($id);
        $operation->update($request->all());

        return redirect()->route('operations.index')->with('success', 'Operation updated successfully.');
    }

    public function destroy($id)
    {
        $operation = Operation::findOrFail($id);
        $operation->delete();

        return redirect()->route('operations.index')->with('success', 'Operation deleted successfully.');
    }
}