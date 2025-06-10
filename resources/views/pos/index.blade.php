@extends('layouts.master')

@section('title', 'Point of Sale')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Point of Sale</h1>
            <a href="{{ route('pos.create') }}" class="btn btn-primary">Add Sale</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('sale_transaction_id'))
            @php
                $saleTransaction = App\Models\SaleTransaction::with(['sales.product', 'customer'])->find(session('sale_transaction_id'));
            @endphp
            @if ($saleTransaction)
                @include('pos.receipt', ['saleTransaction' => $saleTransaction])
            @else
                <div class="alert alert-warning">Sale transaction not found for receipt.</div>
            @endif
        @endif
        <h3>Recent Sales</h3>
        @if ($saleTransactions->isEmpty())
            <p>No sales recorded.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saleTransactions as $saleTransaction)
                        <tr>
                            <td>{{ $saleTransaction->id }}</td>
                            <td>{{ $saleTransaction->customer ? $saleTransaction->customer->name : 'N/A' }}</td>
                            <td>{{ number_format($saleTransaction->total_amount, 2) }}</td>
                            <td>{{ $saleTransaction->created_at ? $saleTransaction->created_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('pos.view', $saleTransaction) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('pos.edit', $saleTransaction) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('pos.destroy', $saleTransaction) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this sale transaction?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection