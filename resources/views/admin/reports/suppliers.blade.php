@extends('layouts.master')

@section('title')
    Suppliers Report
@endsection

@section('content')
<div class="container-fluid printable">
    <h1 class="mt-4 print-title">Suppliers Report</h1>
    <div class="card mb-4">
        <div class="card-header no-print">
            <i class="fas fa-table mr-1"></i>
            Suppliers Report from {{ $startDate ?? 'All Time' }} to {{ $endDate ?? 'All Time' }}
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.suppliers') }}" class="mb-4 no-print">
                <div class="row">
                    <div class="col-md-4">
                        <label for="supplier_id">Select Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                            <option value="">-- Select Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $selectedSupplier && $selectedSupplier->id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}" required>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
                    </div>
                </div>
            </form>
            @if ($selectedSupplier)
                <h6 class="mt-4">Products Supplied by {{ $selectedSupplier->name }}</h6>
                @if ($startDate && $endDate)
                    <p>Showing results from {{ $startDate }} to {{ $endDate }}</p>
                @endif
                @if ($products->isEmpty())
                    <p>No products found for this supplier.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-report">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Stock Quantity</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->stock_quantity }}</td>
                                        <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection