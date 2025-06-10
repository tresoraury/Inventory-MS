@extends('layouts.master')

@section('content')
<div class="container-fluid printable">
    <h1 class="mt-4 print-title">Purchase Orders Report</h1>
    <div class="card mb-4">
        <div class="card-header no-print">
            <i class="fas fa-table mr-1"></i>
            Purchase Orders Report from {{ $startDate ?? 'All Time' }} to {{ $endDate ?? 'All Time' }}
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.purchase-orders') }}" class="mb-4 no-print">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" required>
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
                    </div>
                </div>
            </form>
            @if ($purchaseOrders->isEmpty())
                <p>No purchase orders recorded for the selected date range.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-report">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Supplier</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseOrders as $purchaseOrder)
                                <tr>
                                    <td>{{ $purchaseOrder->id }}</td>
                                    <td>{{ $purchaseOrder->supplier ? $purchaseOrder->supplier->name : 'N/A' }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($purchaseOrder->items as $item)
                                                <li>
                                                    {{ $item->product ? $item->product->name . ' (' . $item->product->code . ')' : 'N/A' }} 
                                                    - Qty: {{ $item->quantity }} 
                                                    - Unit Cost: {{ number_format($item->unit_cost, 2) }}
                                                    - Total: {{ number_format($item->quantity * $item->unit_cost, 2) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                    <td>{{ $purchaseOrder->status }}</td>
                                    <td>{{ $purchaseOrder->created_at ? $purchaseOrder->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <strong>Total Purchase Orders Amount: {{ number_format($totalPurchaseOrders, 2) }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection