<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Product;
use App\Models\Sale;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $sales = Sale::with('product', 'customer')->latest()->take(10)->get();
        return view('pos.index', compact('products', 'sales'));
    }

    public function view(Sale $sale)
    {
        $sale->load('product', 'customer');
        return view('pos.view', compact('sale'));
    }

    public function create()
    {
        $customers = Customer::all();
        $cartItems = CartItem::where('session_id', Session::getId())->with('product')->get();
        return view('pos.create', compact('customers', 'cartItems'));
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $limit = $request->input('limit', null);
        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', "%{$query}%")
                     ->orWhere('code', 'LIKE', "%{$query}%");
        })
        ->select('id', 'name', 'code', 'price', 'stock_quantity')
        ->get();
        return response()->json($products);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return redirect()->route('pos.create')->with('error', 'Insufficient stock for ' . $product->name);
        }

        $sessionId = Session::getId();
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock_quantity < $newQuantity) {
                return redirect()->route('pos.create')->with('error', 'Insufficient stock for ' . $product->name);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('pos.create')->with('success', 'Product added to cart.');
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::where('session_id', Session::getId())->where('id', $id)->firstOrFail();
        $cartItem->delete();
        return redirect()->route('pos.create')->with('success', 'Product removed from cart.');
    }

    public function clearCart()
    {
        CartItem::where('session_id', Session::getId())->delete();
        return redirect()->route('pos.create')->with('success', 'Cart cleared.');
    }

    public function confirmSale(Request $request)
    {
        try {
            $request->validate([
                'customer_id' => 'nullable|exists:customers,id',
            ]);

            $cartItems = CartItem::where('session_id', Session::getId())->with('product')->get();
            if ($cartItems->isEmpty()) {
                return redirect()->route('pos.create')->with('error', 'Cart is empty.');
            }

            $sales = [];
            $operationType = OperationType::where('name', 'stock-out')->first();

            foreach ($cartItems as $item) {
                $product = $item->product;
                if ($product->stock_quantity < $item->quantity) {
                    return redirect()->route('pos.create')->with('error', 'Insufficient stock for ' . $product->name);
                }

                $totalPrice = $product->price * $item->quantity;
                if ($totalPrice > 99999999.99) {
                    return redirect()->route('pos.create')->with('error', 'Total price exceeds maximum for ' . $product->name);
                }

                $sale = Sale::create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $totalPrice,
                    'customer_id' => $request->customer_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $product->stock_quantity -= $item->quantity;
                $product->save();

                if ($operationType) {
                    Operation::create([
                        'product_id' => $product->id,
                        'operation_type_id' => $operationType->id,
                        'quantity' => $item->quantity,
                        'operation_date' => now(),
                    ]);
                } else {
                    Log::warning('OperationType "stock-out" not found. Operation not recorded for sale ID: ' . $sale->id);
                }

                $sales[] = $sale->id;
            }

            CartItem::where('session_id', Session::getId())->delete();

            return redirect()->route('pos.index')
                ->with('success', 'Sale confirmed successfully.')
                ->with('sale_ids', $sales);
        } catch (\Exception $e) {
            Log::error('Sale confirmation failed: ' . $e->getMessage());
            return redirect()->route('pos.create')->with('error', 'Failed to confirm sale: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
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

            $sale = Sale::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $totalPrice,
                'customer_id' => $request->customer_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $product->stock_quantity -= $request->quantity;
            $product->save();

            $operationType = OperationType::where('name', 'stock-out')->first();
            if ($operationType) {
                Operation::create([
                    'product_id' => $product->id,
                    'operation_type_id' => $operationType->id,
                    'quantity' => $request->quantity,
                    'operation_date' => now(),
                ]);
            } else {
                Log::warning('OperationType "stock-out" not found. Operation not recorded for sale ID: ' . $sale->id);
            }

            return redirect()->route('pos.index')
                ->with('success', 'Sale recorded successfully.')
                ->with('sale_id', $sale->id);
        } catch (\Exception $e) {
            Log::error('Sale store failed: ' . $e->getMessage());
            return redirect()->route('pos.index')
                ->with('error', 'Failed to record sale: ' . $e->getMessage())
                ->with('sale_id', isset($sale) ? $sale->id : null);
        }
    }

    public function edit(Sale $sale)
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('pos.edit', compact('sale', 'products', 'customers'));
    }

    public function update(Request $request, Sale $sale)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'customer_id' => 'nullable|exists:customers,id',
            ]);

            $product = Product::findOrFail($request->product_id);

            $oldProduct = $sale->product;
            $oldProduct->stock_quantity += $sale->quantity;
            $oldProduct->save();

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

            $product->stock_quantity -= $request->quantity;
            $product->save();

            $operationType = OperationType::where('name', 'stock-out')->first();
            if ($operationType) {
                Operation::where('product_id', $sale->product_id)
                    ->where('operation_type_id', $operationType->id)
                    ->where('quantity', $sale->quantity)
                    ->update([
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'operation_date' => now(),
                    ]);
            } else {
                Log::warning('OperationType "stock-out" not found. Operation not updated for sale ID: ' . $sale->id);
            }

            return redirect()->route('pos.index')->with('success', 'Sale updated successfully.');
        } catch (\Exception $e) {
            Log::error('Sale update failed: ' . $e->getMessage());
            return redirect()->route('pos.index')->with('error', 'Failed to update sale: ' . $e->getMessage());
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $product = $sale->product;
            $product->stock_quantity += $sale->quantity;
            $product->save();

            $sale->delete();

            return redirect()->route('pos.index')->with('success', 'Sale deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Sale delete failed: ' . $e->getMessage());
            return redirect()->route('pos.index')->with('error', 'Failed to delete sale: ' . $e->getMessage());
        }
    }
}