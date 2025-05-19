@extends('layouts.master')

@section('title')
    Point of Sale
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Point of Sale</h5>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('pos.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} ({{ $product->code }}) - Stock: {{ $product->stock_quantity }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="total_price" class="form-label">Total Price</label>
                    <input type="text" id="total_price" class="form-control" readonly>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Record Sale</button>
        </form>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Recent Sales</h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product->name }} ({{ $sale->product->code }})</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($sale->price, 2) }}</td>
                        <td>{{ $sale->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById('product_id').addEventListener('change', updateTotalPrice);
    document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    function updateTotalPrice() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const totalPriceInput = document.getElementById('total_price');

        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
        const quantity = parseInt(quantityInput.value) || 0;

        const total = price * quantity;
        totalPriceInput.value = total.toFixed(2);
    }
</script>
@endsection