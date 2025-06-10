@extends('layouts.master')
@section('title', 'Create Purchase Order')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Create Purchase Order</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-invoice mr-1"></i>
            New Purchase Order
        </div>
        <div class="card-body">
            <form action="{{ route('purchase_orders.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="products">
                    <div class="row mb-3 product-row">
                        <div class="col-md-4">
                            <label class="form-label">Product</label>
                            <select name="products[0][id]" class="form-control product-select" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-unit-cost="{{ $product->price }}">{{ $product->name }} ({{ $product->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="products[0][quantity]" class="form-control quantity" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Unit Cost</label>
                            <input type="number" name="products[0][unit_cost]" class="form-control unit-cost" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="text" id="total_amount" class="form-control" value="0.00" readonly>
                </div>
                <button type="button" id="add-product" class="btn btn-secondary mb-3">Add Product</button>
                <button type="submit" class="btn btn-primary">Create Purchase Order</button>
            </form>
        </div>
    </div>
</div>
<script>
    let productIndex = 1;

    function updateTotalAmount() {
        let total = 0;
        document.querySelectorAll('.product-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitCost = parseFloat(row.querySelector('.unit-cost').value) || 0;
            total += quantity * unitCost;
        });
        document.getElementById('total_amount').value = total.toFixed(2);
    }

    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('products');
        const row = document.createElement('div');
        row.className = 'row mb-3 product-row';
        row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select name="products[${productIndex}][id]" class="form-control product-select" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-unit-cost="{{ $product->price }}">{{ $product->name }} ({{ $product->code }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Unit Cost</label>
                <input type="number" name="products[${productIndex}][unit_cost]" class="form-control unit-cost" min="0" step="0.01" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
            </div>
        `;
        container.appendChild(row);

        // Auto-fill unit_cost from selected product
        row.querySelector('.product-select').addEventListener('change', function() {
            const selectedOption = this.selectedOptions[0];
            const unitCost = selectedOption.dataset.unitCost || 0;
            row.querySelector('.unit-cost').value = parseFloat(unitCost).toFixed(2);
            updateTotalAmount();
        });

        // Update total on quantity or unit cost change
        row.querySelector('.quantity').addEventListener('input', updateTotalAmount);
        row.querySelector('.unit-cost').addEventListener('input', updateTotalAmount);

        productIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
            updateTotalAmount();
        }
    });

    // Initialize unit cost and total amount for the first row
    document.querySelectorAll('.product-select').forEach(select => {
        select.addEventListener('change', function() {
            const row = this.closest('.product-row');
            const selectedOption = this.selectedOptions[0];
            const unitCost = selectedOption.dataset.unitCost || 0;
            row.querySelector('.unit-cost').value = parseFloat(unitCost).toFixed(2);
            updateTotalAmount();
        });
    });

    document.querySelectorAll('.quantity, .unit-cost').forEach(input => {
        input.addEventListener('input', updateTotalAmount);
    });

    // Initial total calculation
    updateTotalAmount();
</script>
@endsection