@extends('layouts.master')

@section('title', 'Point of Sale')
@section('content')
    <div class="container">
        <h1>Point of Sale</h1>
        <a href="{{ route('pos.create') }}" class="btn btn-primary mb-3">Add Sale</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <h3>Recent Sales</h3>
        @if ($sales->isEmpty())
            <p>No sales recorded.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'N/A' }}</td>
                            <td>{{ $sale->customer ? $sale->customer->name : 'N/A' }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ number_format($sale->price, 2) }}</td>
                            <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('pos.edit', $sale) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('pos.destroy', $sale) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this sale?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection