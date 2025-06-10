@extends('layouts.master')
@section('title', 'Purchase Order Details')
@section('content')
<div class="container-fluid printable">
    <h1 class="mt-4 print-title">Purchase Order #{{ $purchaseOrder->id }}</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file mr-1"></i>
            Purchase Order Details
        </div>
        <div class="card-body">
            <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier ? $purchaseOrder->supplier->name : 'N/A' }}</p>
            <p><strong>Total Amount:</strong> {{ number_format($purchaseOrder->total_amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($purchaseOrder->status) }}</p>
            <p><strong>Created At:</strong> {{ $purchaseOrder->created_at->format('Y-m-d H:i:s') }}</p>
            <h6>Items</h6>
            @if ($purchaseOrder->items->isEmpty())
                <p>No items found for this purchase order.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-report">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseOrder->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product ? $item->product->name . ' (' . $item->product->code . ')' : 'Product Not Found' }}
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_cost, 2) }}</td>
                                    <td>{{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="mt-3 no-print">
                <a href="{{ route('purchase_orders.index') }}" class="btn btn-secondary">Back</a>
                <button type="button" onclick="window.print()" class="btn btn-primary">Print</button>
            </div>
        </div>
    </div>
</div>
@endsection