@extends('layouts.master')

@section('title')
    Edit Operation
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Operation</h5>
        <form action="{{ route('operations.update', $operation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $operation->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->code }})</option>
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
                            <option value="{{ $type->id }}" {{ old('operation_type_id', $operation->operation_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
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
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', $operation->quantity) }}" required>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="operation_date" class="form-label">Date</label>
                    <input type="date" name="operation_date" id="operation_date" class="form-control" value="{{ old('operation_date', $operation->operation_date) }}" required>
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
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $operation->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            <button type="submit" class="btn btn-primary">Update Operation</button>
            <a href="{{ route('operations.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection