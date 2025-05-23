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

        <!-- Product Search and Add to Cart -->
        <form action="{{ route('pos.add-to-cart') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="product_id">Product</label>
                    <select name="product_id" id="product-search" class="form-control @error('product_id') is-invalid @enderror" required>
                        <option value="">Select Product</option>
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
            <form action="{{ route('pos.confirm') }}" method="POST">
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
                                    <a href="{{ route('pos.remove-from-cart', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3">
                    <a href="{{ route('pos.clear-cart') }}" class="btn btn-warning" onclick="return confirm('Clear cart?')">Clear Cart</a>
                    <button type="submit" class="btn btn-success">Confirm Sale</button>
                </div>
            </form>
        @endif
    </div>

    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#product-search').select2({
                placeholder: 'Select or search for a product',
                ajax: {
                    url: '{{ route('pos.search-products') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term || ''
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name + ' (' + item.code + ') - Stock: ' + item.stock_quantity
                                };
                            })
                        };
                    },
                    cache: true
                },
                allowClear: true
            });

            // Load initial products (limited to 50)
            $.ajax({
                url: '{{ route('pos.search-products') }}',
                data: { limit: 50 },
                dataType: 'json',
                success: function(data) {
                    data.forEach(function(item) {
                        var option = new Option(
                            item.name + ' (' + item.code + ') - Stock: ' + item.stock_quantity,
                            item.id,
                            false,
                            false
                        );
                        $('#product-search').append(option);
                    });
                    $('#product-search').trigger('change');
                }
            });
        });
    </script>
@endsection