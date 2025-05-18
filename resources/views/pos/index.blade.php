@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Point of Sale</h1>
        <form action="{{ route('pos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Product</label>
                <select name="product_id" class="form-control" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock_quantity }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Record Sale</button>
        </form>
    </div>
@endsection