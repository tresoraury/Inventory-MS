@extends('layouts.master')
@section('title', 'Purchase Orders')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Purchase Orders</h5>
            <a href="{{ route('purchase_orders.create') }}" class="btn btn-primary float-end">Create Purchase Order</a>
        </div>
        <div class="card-body">
            @if ($purchaseOrders->isEmpty())
                <p>No purchase orders found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrders as $purchaseOrder)
                            <tr>
                                <td>{{ $purchaseOrder->id }}</td>
                                <td>{{ $purchaseOrder->supplier->name }}</td>
                                <td>{{ ucfirst($purchaseOrder->status) }}</td>
                                <td>{{ $purchaseOrder->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('purchase_orders.show', $purchaseOrder) }}" class="btn btn-sm btn-info">View</a>
                                    @if ($purchaseOrder->status === 'pending')
                                        <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('purchase_orders.receive', $purchaseOrder) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Receive</button>
                                        </form>
                                        <form action="{{ route('purchase_orders.cancel', $purchaseOrder) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $purchaseOrders->links() }}
            @endif
        </div>
    </div>
@endsection