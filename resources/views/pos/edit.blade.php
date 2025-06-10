@extends('layouts.master')

@section('title', 'Edit Sale Transaction')
@section('content')
    <div class="container">
        <h1>Edit Sale Transaction</h1>
        <a href="{{ route('pos.index') }}" class="btn btn-secondary mb-3">Back to POS</a>
        <form action="{{ route('pos.update', $saleTransaction) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" class="form-control">
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $saleTransaction->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Products</label>
                <div id="product-list">
                    @foreach ($saleTransaction->sales as $index => $sale)
                        <div class="row mb-2 product-row">
                            <div class="col-md-5">
                                <select name="product_ids[]" class="form-control">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $sale->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="quantities[]" class="form-control" value="{{ $sale->quantity }}" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-product">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary mt-2" id="add-product">Add Product</button>
            </div>
            <button type="submit" class="btn btn-success">Update Sale</button>
        </form>
    </div>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            const productList = document.getElementById('product-list');
            const productRow = document.createElement('div');
            productRow.className = 'row mb-2 product-row';
            productRow.innerHTML = `
                <div class="col-md-5">
                    <select name="product_ids[]" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="number" name="quantities[]" class="form-control" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            `;
            productList.appendChild(productRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-row').remove();
            }
        });
    </script>
@endsection