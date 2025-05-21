@extends('layouts.master')

@section('title')
    Operations Report
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Operations Report</h5>
        <form method="GET" action="{{ route('reports.operations') }}" class="mb-4 no-print">
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

        @if ($operations->isEmpty())
            <p>No operations found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Operation Type</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operations as $operation)
                        <tr>
                            <td>{{ $operation->product ? $operation->product->name : 'N/A' }}</td>
                            <td>{{ $operation->operationType ? $operation->operationType->name : 'N/A' }}</td>
                            <td>{{ $operation->supplier ? $operation->supplier->name : 'N/A' }}</td>
                            <td>{{ $operation->quantity }}</td>
                            <td>{{ $operation->operation_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection