@extends('layouts.master')
@section('title', 'Customer Details')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Customer #{{ $customer->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
            <h6>Sales</h6>
            @if ($customer->sales->isEmpty())
                <p>No sales recorded for this customer.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->sales as $sale)
                            <tr>
                                <td>{{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'Product Not Found' }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>{{ number_format($sale->price, 2) }}</td>
                                <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection