@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Montserrat', sans-serif;
        color: #333;
    }
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: transform 0.3s;
        background-color: #fff;
    }
    .card:hover {
        transform: scale(1.02);
    }
    .card-header {
        background-color: #f96332;
        color: #fff;
        padding: 15px;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .card-title {
        margin: 0;
        color: black;
    }
    .card-category {
        color: #333;
        font-size: 14px;
    }
    .btn {
        border-radius: 0.25rem;
        padding: 12px 20px;
        transition: background-color 0.3s, transform 0.2s;
    }
    .btn-info {
        background-color: #2CA8FF;
        color: white;
    }
    .btn-info:hover {
        background-color: #1a7cb1;
        transform: translateY(-2px);
    }
    .chart-area {
        height: 250px;
    }
    .list-group-item {
        border: none;
        padding: 15px;
        background-color: #f9f9f9;
        transition: background-color 0.3s;
    }
    .list-group-item:hover {
        background-color: #e8e8e8;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total Products</h5>
                    <p>{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Low Stock</h5>
                    <p>{{ $lowStock }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <canvas id="stockChart"></canvas>
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
                backgroundColor: ['#36a2eb', '#ff6384']
            }]
        }
    });
</script>
@endsection