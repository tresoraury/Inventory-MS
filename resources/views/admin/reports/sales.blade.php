@extends('layouts.master')

@section('content')
<div class="container-fluid printable">
    <h1 class="mt-4 print-title">Sales Report</h1>
    <div class="card mb-4">
        <div class="card-header no-print">
            <i class="fas fa-table mr-1"></i>
            Sales Report from {{ $startDate ?? 'All Time' }} to {{ $endDate ?? 'All Time' }}
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.sales') }}" class="mb-4 no-print">
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
            @if ($saleTransactions->isEmpty())
                <p>No sales recorded for the selected date range.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-report">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saleTransactions as $saleTransaction)
                                <tr>
                                    <td>{{ $saleTransaction->id }}</td>
                                    <td>{{ $saleTransaction->customer ? $saleTransaction->customer->name : 'N/A' }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($saleTransaction->sales as $sale)
                                                <li>
                                                    {{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'N/A' }} 
                                                    - Qty: {{ $sale->quantity }} 
                                                    - Price: {{ number_format($sale->product ? $sale->product->price : 0, 2) }}
                                                    - Total: {{ number_format($sale->price, 2) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ number_format($saleTransaction->total_amount, 2) }}</td>
                                    <td>{{ $saleTransaction->created_at ? $saleTransaction->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <strong>Total Sales Amount: {{ number_format($totalSales, 2) }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection