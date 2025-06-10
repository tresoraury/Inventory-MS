@extends('layouts.master')

@section('title')
    Products Report
@endsection

@section('content')
<div class="container-fluid printable">
    <h1 class="mt-4 print-title">Inventory Report</h1>
    <div class="card mb-4">
        <div class="card-header no-print">
            <i class="fas fa-table mr-1"></i>
            Products Report from {{ $startDate ?? 'All Time' }} to {{ $endDate ?? 'All Time' }}
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.products') }}" class="mb-4 no-print">
                <div class="row">
                    <div class="col-md-4">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}" required>
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
                    </div>
                </div>
            </form>
            @if ($startDate && $endDate)
                <p>Showing results from {{ $startDate }} to {{ $endDate }}</p>
            @endif
            @if ($products->isEmpty())
                <p>No products found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-report">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Stock Quantity</th>
                                <th>Minimum Quantity</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>{{ $product->minimum_quantity }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                    <td>{{ $product->supplier ? $product->supplier->name : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection