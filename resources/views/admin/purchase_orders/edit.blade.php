@extends('layouts.master')
@section('title', 'Edit Purchase Order')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Edit Purchase Order #{{ $purchaseOrder->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchase_orders.index') }}">Purchase Orders</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-invoice mr-1"></i>
            Edit Purchase Order Details
        </div>
        <div class="card-body">
            <form action="{{ route('purchase_orders.update', $purchaseOrder) }}" method="POST" id="purchase-order-form">
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
                            <div class="col-md-4">
                                <label class="form-label">Product</label>
                                <select name="products[{{ $index }}][id]" class="form-control product-select" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-unit-cost="{{ $product->price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="products[{{ $index }}][quantity]" class="form-control quantity" value="{{ $item->quantity }}" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Unit Cost</label>
                                <input type="number" class="form-control unit-cost" value="{{ $item->unit_cost > 0 ? $item->unit_cost : '' }}" min="0" step="0.01" readonly>
                                <input type="hidden" name="products[{{ $index }}][unit_cost]" value="{{ $item->unit_cost > 0 ? $item->unit_cost : '0' }}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="text" id="total_amount" class="form-control" value="{{ number_format($purchaseOrder->total_amount, 2) }}" readonly>
                </div>
                <button type="button" id="add-product" class="btn btn-secondary mb-3">Add Product</button>
                <button type="submit" class="btn btn-primary">Update Purchase Order</button>
            </form>
        </div>
    </div>
</div>
<script>
    let productIndex = {{ count($purchaseOrder->items) }};

    function updateTotalAmount() {
        let total = 0;
        document.querySelectorAll('.product-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitCost = parseFloat(row.querySelector('.unit-cost').value) || 0;
            total += quantity * unitCost;
        });
        document.getElementById('total_amount').value = total.toFixed(2);
    }

    function setUnitCost(row) {
        const select = row.querySelector('.product-select');
        const unitCostInput = row.querySelector('.unit-cost');
        const hiddenInput = row.querySelector('input[name$="[unit_cost]"]');
        const selectedOption = select.selectedOptions[0];
        if (selectedOption && selectedOption.dataset.unitCost) {
            const unitCost = parseFloat(selectedOption.dataset.unitCost).toFixed(2);
            unitCostInput.value = unitCost;
            hiddenInput.value = unitCost; // Update hidden input
            console.log(`Set unit cost for product ${select.value}: ${unitCost}`); // Debug
        }
        updateTotalAmount();
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
                <input type="number" class="form-control unit-cost" value="0.00" min="0" step="0.01" readonly>
                <input type="hidden" name="products[${productIndex}][unit_cost]" value="0">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
            </div>
        `;
        container.appendChild(row);

        row.querySelector('.product-select').addEventListener('change', function() {
            setUnitCost(row);
        });

        row.querySelector('.quantity').addEventListener('input', updateTotalAmount);

        productIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
            updateTotalAmount();
        }
    });

    document.querySelectorAll('.product-select').forEach(select => {
        select.addEventListener('change', function() {
            const row = this.closest('.product-row');
            setUnitCost(row);
        });
    });

    document.querySelectorAll('.quantity').forEach(input => {
        input.addEventListener('input', updateTotalAmount);
    });

    // Initialize unit costs on page load
    document.querySelectorAll('.product-row').forEach(row => {
        if (row.querySelector('.product-select').value) {
            setUnitCost(row);
        }
    });

    // Debug form submission
    document.getElementById('purchase-order-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Debug
        document.querySelectorAll('.product-row').forEach(row => {
            if (row.querySelector('.product-select').value) {
                setUnitCost(row);
            }
        });
        const formData = new FormData(this);
        console.log('Form data:', Object.fromEntries(formData)); // Debug
        setTimeout(() => this.submit(), 100); // Delay submission
    });
</script>
@endsection