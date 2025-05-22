@extends('layouts.master')

@section('title', 'Add Sale')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Add Sale</h1>
        <form action="{{ route('pos.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="product_id">Product</label>
                <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }}) - Stock: {{ $product->stock_quantity }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
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
            <div class="form-group mb-3">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required min="1">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit Sale</button>
            <a href="{{ route('pos.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection