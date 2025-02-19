<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Materiaux;
use App\Models\Sale;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        $sales = Sale::with('materiaux')->get();
        return view('pos.index', compact('sales'));
    }

    public function create()
    {
        $materiaux = Materiaux::all(); 
        return view('pos.create', compact('materiaux'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'materiaux_id' => 'required|exists:materiaux,id',
            'quantity' => 'required|integer|min:1',
            'client_name' => 'required|string|max:255',
        ]);

        $materiaux = Materiaux::find($validated['materiaux_id']);
        $total = $materiaux->price * $validated['quantity'];

        Sale::create([
            'materiaux_id' => $validated['materiaux_id'],
            'quantity' => $validated['quantity'],
            'client_name' => $validated['client_name'],
            'total' => $total,
        ]);

        return redirect()->route('pos.index')->with('success', 'Sale added successfully');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'materiaux_id' => 'required|exists:materiaux,id',
            'quantity' => 'required|integer|min:1',
            'client_name' => 'required|string|max:255',
        ]);

        $sale = Sale::findOrFail($id);
        $materiaux = Materiaux::find($validated['materiaux_id']);
        $total = $materiaux->price * $validated['quantity'];

        $sale->update([
            'materiaux_id' => $validated['materiaux_id'],
            'quantity' => $validated['quantity'],
            'client_name' => $validated['client_name'],
            'total' => $total,
        ]);

        return redirect()->route('pos.index')->with('success', 'Sale updated successfully');
    }

    public function edit($id)
    {
        $sale = Sale::with('materiaux')->findOrFail($id);
        $materiaux = Materiaux::all(); 
        return view('pos.edit', compact('sale', 'materiaux')); 
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        
        return redirect()->route('pos.index')->with('success', 'Sale deleted successfully');
    }
}