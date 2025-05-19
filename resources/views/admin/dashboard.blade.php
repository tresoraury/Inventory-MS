@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <p class="card-text display-4">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Low Stock</h5>
                <p class="card-text display-4">{{ $lowStock }}</p>
                <a href="{{ route('low_stock') }}" class="btn btn-outline-primary btn-sm">View Details</a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Stock Status</h5>
        <div class="chart-container">
            <canvas id="stockChart"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stockChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['In Stock', 'Low Stock'],
            datasets: [{
                label: 'Stock Status',
                data: [{{ $totalProducts }}, {{ $lowStock }}],
                backgroundColor: ['#36a2eb', '#ff6384'],
                borderRadius: 5
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection