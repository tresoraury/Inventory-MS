@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Product</h1>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection