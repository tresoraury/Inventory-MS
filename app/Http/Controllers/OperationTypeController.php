<?php

namespace App\Http\Controllers;

use App\Models\OperationType;
use Illuminate\Http\Request;

class OperationTypeController extends Controller
{
    public function index()
    {
        $operationTypes = OperationType::all();
        return view('operation_types.index', compact('operationTypes'));
    }

    public function create()
    {
        return view('operation_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        OperationType::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('operation_types.index')->with('success', 'Operation Type created successfully.');
    }

    public function edit($id)
    {
        $operationType = OperationType::findOrFail($id);
        return view('operation_types.edit', compact('operationType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $operationType = OperationType::findOrFail($id);
        $operationType->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => now(),
        ]);

        return redirect()->route('operation_types.index')->with('success', 'Operation Type updated successfully.');
    }

    public function destroy($id)
    {
        $operationType = OperationType::findOrFail($id);
        $operationType->delete();

        return redirect()->route('operation_types.index')->with('success', 'Operation Type deleted successfully.');
    }
}