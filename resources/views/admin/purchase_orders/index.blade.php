@extends('layouts.master')
@section('title', 'Purchase Orders')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Purchase Orders</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-file-invoice mr-1"></i>
                Purchase Orders List
            </div>
            <a href="{{ route('purchase_orders.create') }}" class="btn btn-primary">Create Purchase Order</a>
        </div>
        <div class="card-body">
            @if ($purchaseOrders->isEmpty())
                <p>No purchase orders found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-left">Supplier</th>
                                <th class="text-right">Total Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseOrders as $purchaseOrder)
                                <tr>
                                    <td class="text-center">{{ $purchaseOrder->id }}</td>
                                    <td class="text-left">{{ $purchaseOrder->supplier ? $purchaseOrder->supplier->name : 'N/A' }}</td>
                                    <td class="text-right">{{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                    <td class="text-center">{{ ucfirst($purchaseOrder->status) }}</td>
                                    <td class="text-center">{{ $purchaseOrder->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('purchase_orders.show', $purchaseOrder) }}" class="btn btn-sm btn-info">View</a>
                                        @if ($purchaseOrder->status === 'pending')
                                            <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('purchase_orders.receive', $purchaseOrder) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Receive</button>
                                            </form>
                                            <form action="{{ route('purchase_orders.cancel', $purchaseOrder) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('purchase_orders.destroy', $purchaseOrder) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you certain you want to delete this purchase order?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $purchaseOrders->links() }}
            @endif
        </div>
    </div>
</div>
@endsection