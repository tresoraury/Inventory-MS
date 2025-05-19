@extends('layouts.master')

@section('title')
    Create Operation
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create Operation</h5>
        <form action="{{ route('operations.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="operation_type_id" class="form-label">Operation Type</label>
                    <select name="operation_type_id" id="operation_type_id" class="form-select" required>
                        <option value="">Select Type</option>
                        @foreach ($operationTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('operation_type_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="operation_date" class="form-label">Date</label>
                    <input type="date" name="operation_date" id="operation_date" class="form-control" required>
                    @error('operation_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-select">
                    <option value="">None</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            <button type="submit" class="btn btn-primary">Create Operation</button>
            <a href="{{ route('operations.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection