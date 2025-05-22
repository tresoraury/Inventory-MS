@extends('layouts.master')
@section('title', 'Purchase Order Details')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Purchase Order #{{ $purchaseOrder->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($purchaseOrder->status) }}</p>
            <p><strong>Created At:</strong> {{ $purchaseOrder->created_at->format('Y-m-d') }}</p>
            <h6>Items</h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseOrder->items as $item)
                        <tr>
                            <td>{{ $item->product->name }} ({{ $item->product->code }})</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('purchase_orders.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection