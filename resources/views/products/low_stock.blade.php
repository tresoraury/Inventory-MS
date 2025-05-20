@extends('layouts.master')

@section('title')
    Low Stock Products
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Low Stock Products</h5>
        @if ($products->isEmpty())
            <div class="alert alert-info">No products are currently low on stock.</div>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Stock Quantity</th>
                        <th>Minimum Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->minimum_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection