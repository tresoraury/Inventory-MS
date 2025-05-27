@extends('layouts.master')

@section('title', 'Add Sale')
@section('content')
    <div class="container mt-5">
        <h1>Add Sale</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Add to Cart -->
        <form action="{{ route('pos.add-to-cart') }}" method="POST" id="add-to-cart-form" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="product_id">Product</label>
                    <select name="product_id" id="product-search" class="form-control @error('product_id') is-invalid @enderror" required>
                        <option value="">Select Product</option>
                        @foreach (\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }}) - Stock: {{ $product->stock_quantity }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" required min="1">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </div>
            </div>
        </form>

        <!-- Cart Table -->
        <h3>Cart</h3>
        @if ($cartItems->isEmpty())
            <p>No items in cart.</p>
        @else
            <!-- Clear Cart Button -->
            <form action="{{ route('pos.clear-cart') }}" method="POST" id="clear-cart-form" class="mb-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning" onclick="return confirm('Clear all cart items?')">Clear Cart</button>
            </form>

            <!-- Confirm Sale Form -->
            <form id="confirm-sale-form" action="/pos/confirm" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                        <option value="">Select Customer (Optional)</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email ?? 'No Email' }})</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->product ? $item->product->name . ' (' . $item->product->code . ')' : 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->product ? number_format($item->product->price, 2) : 'N/A' }}</td>
                                <td>{{ $item->product ? number_format($item->product->price * $item->quantity, 2) : 'N/A' }}</td>
                                <td>
                                    <!-- Remove button disabled; use Clear Cart instead -->
                                    <!--
                                    <form action="{{ route('pos.remove-from-cart', $item->id) }}" method="POST" class="remove-item-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">Remove</button>
                                    </form>
                                    -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Confirm Sale</button>
                </div>
            </form>
        @endif
    </div>

    <script>
        document.getElementById('confirm-sale-form').addEventListener('submit', function(e) {
            console.log('Confirm Sale form submitted to:', this.action);
            console.log('Form data:', new FormData(this));
        });
    </script>
@endsection