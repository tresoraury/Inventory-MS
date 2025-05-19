@extends('layouts.master')

@section('title')
    Point of Sale
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Point of Sale</h5>
        <form action="{{ route('pos.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add to Sale</button>
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
                    <th>Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product->name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($sale->price, 2) }}</td>
                        <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection