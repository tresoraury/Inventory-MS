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

    <form action="{{ route('reports.generate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="report_type">Report Type:</label>
            <select name="report_type" class="form-control" required>
                <option value="product">Product Report</option>
                <option value="operation">Operation Report</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

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

    @if(isset($reports))
        <h2>Generated Report</h2>
        <table class="table">
            <thead>
                <tr>
                    @if($report_type == 'product')
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity Left</th>
                    @else
                        <th>Date</th>
                        <th>Operation Type</th>
                        <th>Issued By</th>
                        <th>Product</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        @if($report_type == 'product')
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->materiel->designation ?? 'N/A' }}</td>
                            <td>{{ $report->quantite }}</td>
                        @else
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->type->name ?? 'N/A' }}
                            <td>{{ $report->partenaire }}</td>
                            <td>{{ $report->materiel->designation ?? 'N/A' }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesTrendsChart').getContext('2d');
    const salesTrends = <?php echo json_encode($salesTrends, 15, 512) ?>;
    const labels = salesTrends.map(trend => trend.date);
    const data = salesTrends.map(trend => trend.total_sales);
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales Trends',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection