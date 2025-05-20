@extends('layouts.master')

@section('title')
    Edit Operation
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Operation</h5>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('operations.update', $operation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $operation->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="operation_type_id" class="form-label">Operation Type</label>
                <select class="form-control" id="operation_type_id" name="operation_type_id" required>
                    <option value="">Select Operation Type</option>
                    @foreach ($operationTypes as $operationType)
                        <option value="{{ $operationType->id }}" {{ old('operation_type_id', $operation->operation_type_id) == $operationType->id ? 'selected' : '' }}>{{ $operationType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier (Optional)</label>
                <select class="form-control" id="supplier_id" name="supplier_id">
                    <option value="">Select Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $operation->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $operation->quantity) }}" required>
            </div>
            <div class="mb-3">
                <label for="operation_date" class="form-label">Operation Date</label>
                <input type="date" class="form-control" id="operation_date" name="operation_date" value="{{ old('operation_date', $operation->operation_date) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('operations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection