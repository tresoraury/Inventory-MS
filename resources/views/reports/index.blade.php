@extends('layouts.master')

@section('content')
<style>
    .container {
        margin-top: 30px; 
    }

    h1 {
        margin-bottom: 20px; 
    }

    table {
        width: 100%; 
        border-collapse: collapse; 
    }

    th, td {
        padding: 12px; 
        text-align: left; 
        border-bottom: 1px solid #ddd; 
    }

    th {
        background-color: #f2f2f2; 
    }

    tr:hover {
        background-color: #f1f1f1; 
    }

    p {
        font-size: 18px; 
        color: #555; 
    }
</style>

<div class="container">
    <h1>Inventory Reports</h1>

    <h2>Inventory Levels</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Stock Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventoryLevels as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->stock_level }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Sales Trends</h2>
    <canvas id="salesTrendsChart"></canvas>

    <h2>Best Selling Products</h2>
    <ul>
        @foreach ($bestSellingProducts as $product)
            <li>Product ID: {{ $product->product_id }} - Sold: {{ $product->count }}</li>
        @endforeach
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesTrendsChart').getContext('2d');
    const salesTrends = @json($salesTrends);
    const labels = salesTrends.map(trend => trend.date);
    const data = salesTrends.map(trend => trend.total_sales);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales Trend',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection