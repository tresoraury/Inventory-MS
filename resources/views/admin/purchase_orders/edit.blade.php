@extends('layouts.master')
@section('title', 'Edit Purchase Order')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Purchase Order #{{ $purchaseOrder->id }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('purchase_orders.update', $purchaseOrder) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $purchaseOrder->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="products">
                    @foreach ($purchaseOrder->items as $index => $item)
                        <div class="row mb-3 product-row">
                            <div class="col-md-6">
                                <label class="form-label">Product</label>
                                <select name="products[{{ $index }}][id]" class="form-control product-select" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-product" class="btn btn-secondary mb-3">Add Product</button>
                <button type="submit" class="btn btn-primary">Update Purchase Order</button>
            </form>
        </div>
    </div>
    <script>
        let productIndex = {{ count($purchaseOrder->items) }};
        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products');
            const row = document.createElement('div');
            row.className = 'row mb-3 product-row';
            row.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label">Product</label>
                    <select name="products[${productIndex}][id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
                </div>
            `;
            container.appendChild(row);
            productIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-row').remove();
            }
        });
    </script>
@endsection