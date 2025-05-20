@extends('layouts.master')

@section('title')
    Create Operation
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create Operation</h5>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('operations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="operation_type_id" class="form-label">Operation Type</label>
                <select class="form-control" id="operation_type_id" name="operation_type_id" required>
                    <option value="">Select Operation Type</option>
                    @foreach ($operationTypes as $operationType)
                        <option value="{{ $operationType->id }}">{{ $operationType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier (Optional)</label>
                <select class="form-control" id="supplier_id" name="supplier_id">
                    <option value="">Select Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
            </div>
            <div class="mb-3">
                <label for="operation_date" class="form-label">Operation Date</label>
                <input type="date" class="form-control" id="operation_date" name="operation_date" value="{{ old('operation_date') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('operations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection