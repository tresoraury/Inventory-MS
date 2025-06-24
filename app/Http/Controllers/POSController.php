<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleTransaction;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class POSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage sales', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy', 'confirmSale', 'addToCart', 'removeFromCart', 'view', 'searchProducts', 'clearCart']]);
    }

    public function index()
    {
        
        $saleTransactions = SaleTransaction::with(['sales.product', 'customer'])->latest()->take(10)->get();
        return view('pos.index', compact('saleTransactions'));
    }

    public function view(SaleTransaction $saleTransaction)
    {
        if (!$saleTransaction->exists) {
            Log::error('SaleTransaction not found', ['id' => request()->route('saleTransaction')]);
            return redirect()->route('pos.index')->with('error', 'Sale transaction not found.');
        }

        $saleTransaction->load(['sales.product', 'customer']);
        Log::info('SaleTransaction loaded for view', ['id' => $saleTransaction->id, 'data' => $saleTransaction->toArray()]);
        return view('pos.view', compact('saleTransaction'));
    }

    public function create()
    {
        $this->cleanupCart();
        Log::info('Current session ID in create', ['session_id' => Session::getId()]);
        $customers = Customer::all();
        $cartItems = CartItem::where('session_id', Session::getId())->with('product')->get();
        Log::info('Cart items loaded', ['cart_items' => $cartItems->toArray()]);
        return view('pos.create', compact('customers', 'cartItems'));
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', "%{$query}%")
                     ->orWhere('code', 'LIKE', "%{$query}%");
        })
        ->select('id', 'name', 'code', 'price', 'stock_quantity')
        ->get();
        Log::info('searchProducts called', ['query' => $query, 'results' => $products->toArray()]);
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
            Log::warning('addToCart: Insufficient stock', ['product_id' => $request->product_id, 'requested' => $request->quantity, 'available' => $product->stock_quantity]);
            return redirect()->route('pos.create')->with('error', 'Insufficient stock for ' . $product->name);
        }

        $sessionId = Session::getId();
        Log::info('addToCart called', ['session_id' => $sessionId, 'product_id' => $request->product_id, 'quantity' => $request->quantity]);

        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock_quantity < $newQuantity) {
                Log::warning('addToCart: Insufficient stock for update', ['product_id' => $request->product_id, 'new_quantity' => $newQuantity, 'available' => $product->stock_quantity]);
                return redirect()->route('pos.create')->with('error', 'Insufficient stock for ' . $product->name);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cartItem = CartItem::create([
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
            Log::info('New cart item created', ['cart_item_id' => $cartItem->id]);
        }

        return redirect()->route('pos.create')->with('success', 'Product added to cart.');
    }

    public function removeFromCart($id)
    {
        $sessionId = Session::getId();
        Log::info('removeFromCart called', ['id' => $id, 'session_id' => $sessionId]);
        
        try {
            $cartItem = CartItem::where('session_id', $sessionId)
                                ->where('id', $id)
                                ->first();
            
            if (!$cartItem) {
                Log::warning('Cart item not found', ['id' => $id, 'session_id' => $sessionId]);
                $allCartItems = CartItem::all()->toArray();
                Log::info('All cart items in database', ['cart_items' => $allCartItems]);
                return redirect()->route('pos.create')->with('error', 'Cart item not found.');
            }
            
            $cartItem->delete();
            Log::info('Cart item removed successfully', ['id' => $id]);
            return redirect()->route('pos.create')->with('success', 'Product removed from cart.');
        } catch (\Exception $e) {
            Log::error('removeFromCart failed', ['id' => $id, 'session_id' => $sessionId, 'error' => $e->getMessage()]);
            return redirect()->route('pos.create')->with('error', 'Failed to remove product: ' . $e->getMessage());
        }
    }

    public function clearCart()
    {
        try {
            $sessionId = Session::getId();
            Log::info('clearCart called', ['session_id' => $sessionId]);
            CartItem::where('session_id', $sessionId)->delete();
            Log::info('All cart items cleared for session', ['session_id' => $sessionId]);
            return redirect()->route('pos.create')->with('success', 'Cart cleared successfully.');
        } catch (\Exception $e) {
            Log::error('clearCart failed', ['session_id' => $sessionId, 'error' => $e->getMessage()]);
            return redirect()->route('pos.create')->with('error', 'Failed to clear cart: ' . $e->getMessage());
        }
    }

    public function confirmSale(Request $request)
    {
        $sessionId = Session::getId();
        Log::info('confirmSale method reached', ['session_id' => $sessionId, 'input' => $request->all()]);

        try {
            $request->validate([
                'customer_id' => 'nullable|exists:customers,id',
            ]);

            $cartItems = CartItem::where('session_id', $sessionId)->with('product')->get();
            Log::info('Cart items for confirmSale', ['cart_items' => $cartItems->toArray()]);

            if ($cartItems->isEmpty()) {
                Log::warning('confirmSale: Cart is empty', ['session_id' => $sessionId]);
                return redirect()->route('pos.create')->with('error', 'Cart is empty.');
            }

            // total amount for the transaction
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item->product->price * $item->quantity;
            }

            if ($totalAmount > 99999999.99) {
                Log::warning('confirmSale: Total transaction amount exceeds max', ['total_amount' => $totalAmount]);
                return redirect()->route('pos.create')->with('error', 'Total transaction amount exceeds maximum allowed value.');
            }

            // Create new SaleTransaction
            $saleTransaction = SaleTransaction::create([
                'customer_id' => $request->customer_id,
                'total_amount' => $totalAmount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $saleIds = [];
            $operationType = OperationType::where('name', 'stock-out')->first();

            foreach ($cartItems as $item) {
                $product = $item->product;
                if (!$product) {
                    Log::warning('confirmSale: Product not found', ['product_id' => $item->product_id, 'cart_item_id' => $item->id]);
                    return redirect()->route('pos.create')->with('error', 'Product not found for cart item ID ' . $item->id);
                }

                if ($product->stock_quantity < $item->quantity) {
                    Log::warning('confirmSale: Insufficient stock', ['product_id' => $item->product_id, 'requested' => $item->quantity, 'available' => $product->stock_quantity]);
                    return redirect()->route('pos.create')->with('error', 'Insufficient stock for ' . $product->name);
                }

                $totalPrice = $product->price * $item->quantity;
                if ($totalPrice > 99999999.99) {
                    Log::warning('confirmSale: Price exceeds max', ['product_id' => $item->product_id, 'total_price' => $totalPrice]);
                    return redirect()->route('pos.create')->with('error', 'Total price exceeds maximum for ' . $product->name);
                }

                $sale = Sale::create([
                    'sale_transaction_id' => $saleTransaction->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $totalPrice,
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
                    Log::warning('confirmSale: OperationType "stock-out" not found', ['sale_id' => $sale->id]);
                }

                $saleIds[] = $sale->id;
            }

            CartItem::where('session_id', $sessionId)->delete();
            Log::info('confirmSale: Sale confirmed', ['session_id' => $sessionId, 'sale_transaction_id' => $saleTransaction->id, 'sale_ids' => $saleIds]);

            return redirect()->route('pos.index')
                ->with('success', 'Sale confirmed successfully.')
                ->with('sale_transaction_id', $saleTransaction->id);
        } catch (\Exception $e) {
            Log::error('confirmSale failed', ['session_id' => $sessionId, 'error' => $e->getMessage()]);
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
                Log::warning('store: Insufficient stock', ['product_id' => $request->product_id, 'requested' => $request->quantity, 'available' => $product->stock_quantity]);
                return redirect()->route('pos.index')->with('error', 'Insufficient stock for ' . $product->name);
            }

            $totalPrice = $product->price * $request->quantity;

            if ($totalPrice > 99999999.99) {
                Log::warning('store: Price exceeds max', ['product_id' => $request->product_id, 'total_price' => $totalPrice]);
                return redirect()->route('pos.index')->with('error', 'Total price exceeds maximum allowed value.');
            }

            // Create SaleTransaction for a single product sale
            $saleTransaction = SaleTransaction::create([
                'customer_id' => $request->customer_id,
                'total_amount' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sale = Sale::create([
                'sale_transaction_id' => $saleTransaction->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $totalPrice,
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
                Log::warning('store: OperationType "stock-out" not found', ['sale_id' => $sale->id]);
            }

            return redirect()->route('pos.index')
                ->with('success', 'Sale recorded successfully.')
                ->with('sale_transaction_id', $saleTransaction->id);
        } catch (\Exception $e) {
            Log::error('store failed', ['error' => $e->getMessage()]);
            return redirect()->route('pos.index')
                ->with('error', 'Failed to record sale: ' . $e->getMessage());
        }
    }

    public function edit(SaleTransaction $saleTransaction)
    {
        if (!$saleTransaction->exists) {
            Log::error('SaleTransaction not found for edit', ['id' => request()->route('saleTransaction')]);
            return redirect()->route('pos.index')->with('error', 'Sale transaction not found.');
        }

        $products = Product::all();
        $customers = Customer::all();
        $saleTransaction->load('sales.product');
        Log::info('SaleTransaction loaded for edit', ['id' => $saleTransaction->id, 'data' => $saleTransaction->toArray()]);
        return view('pos.edit', compact('saleTransaction', 'products', 'customers'));
    }

    public function update(Request $request, SaleTransaction $saleTransaction)
    {
        try {
            $request->validate([
                'product_ids' => 'required|array',
                'product_ids.*' => 'exists:products,id',
                'quantities' => 'required|array',
                'quantities.*' => 'integer|min:1',
                'customer_id' => 'nullable|exists:customers,id',
            ]);

            
            foreach ($saleTransaction->sales as $sale) {
                $product = $sale->product;
                $product->stock_quantity += $sale->quantity;
                $product->save();
            }

            // Delete existing sale items
            $saleTransaction->sales()->delete();

            // Create new sale items
            $totalAmount = 0;
            $saleIds = [];
            $operationType = OperationType::where('name', 'stock-out')->first();

            foreach ($request->product_ids as $index => $product_id) {
                $product = Product::findOrFail($product_id);
                $quantity = $request->quantities[$index];

                if ($product->stock_quantity < $quantity) {
                    Log::warning('update: Insufficient stock', ['product_id' => $product_id, 'requested' => $quantity, 'available' => $product->stock_quantity]);
                    return redirect()->route('pos.index')->with('error', 'Insufficient stock for ' . $product->name);
                }

                $totalPrice = $product->price * $quantity;
                if ($totalPrice > 99999999.99) {
                    Log::warning('update: Price exceeds max', ['product_id' => $product_id, 'total_price' => $totalPrice]);
                    return redirect()->route('pos.index')->with('error', 'Total price exceeds maximum for ' . $product->name);
                }

                $totalAmount += $totalPrice;

                $sale = Sale::create([
                    'sale_transaction_id' => $saleTransaction->id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $totalPrice,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $product->stock_quantity -= $quantity;
                $product->save();

                if ($operationType) {
                    Operation::create([
                        'product_id' => $product->id,
                        'operation_type_id' => $operationType->id,
                        'quantity' => $quantity,
                        'operation_date' => now(),
                    ]);
                }

                $saleIds[] = $sale->id;
            }

            
            $saleTransaction->update([
                'customer_id' => $request->customer_id,
                'total_amount' => $totalAmount,
                'updated_at' => now(),
            ]);

            return redirect()->route('pos.index')
                ->with('success', 'Sale updated successfully.')
                ->with('sale_transaction_id', $saleTransaction->id);
        } catch (\Exception $e) {
            Log::error('update failed', ['error' => $e->getMessage()]);
            return redirect()->route('pos.index')->with('error', 'Failed to update sale: ' . $e->getMessage());
        }
    }

    public function destroy(SaleTransaction $saleTransaction)
    {
        try {
            foreach ($saleTransaction->sales as $sale) {
                $product = $sale->product;
                $product->stock_quantity += $sale->quantity;
                $product->save();
            }

            $saleTransaction->sales()->delete();
            $saleTransaction->delete();

            return redirect()->route('pos.index')->with('success', 'Sale transaction deleted successfully.');
        } catch (\Exception $e) {
            Log::error('destroy failed', ['error' => $e->getMessage()]);
            return redirect()->route('pos.index')->with('error', 'Failed to delete sale transaction: ' . $e->getMessage());
        }
    }

    public function cleanupCart()
    {
        try {
            $sessionId = Session::getId();
            CartItem::where('session_id', '!=', $sessionId)->delete();
            Log::info('Cleared cart items with non-matching session IDs', ['current_session_id' => $sessionId]);
            $expiredTime = now()->subHours(24);
            CartItem::where('updated_at', '<', $expiredTime)->delete();
            Log::info('Cleared stale cart items older than 24 hours');
        } catch (\Exception $e) {
            Log::error('Failed to clean up cart items', ['error' => $e->getMessage()]);
        }
    }
}