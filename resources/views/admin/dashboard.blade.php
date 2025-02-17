@extends('layouts.master')

@section('title')
  ACCEUIL ...
@endsection

@section('content')

<style>
  /* General Styles */
  body {
      background-color: #f5f5f5;
      font-family: 'Montserrat', sans-serif;
      color: #333;
  }

  .card {
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
  }

  .card-header {
    background-color: #f96332; /* Card header background */
    color: #fff; /* White text */
    padding: 10px; /* Add padding for better spacing */
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

  .card-title, .card-category {
      margin: 0;
     
  }

  .btn {
      border-radius: 0.25rem;
      padding: 10px 20px;
      transition: background-color 0.3s;
  }

  .btn-info {
      background-color: #2CA8FF;
      color: white;
  }

  .btn-info:hover {
      background-color: #1a7cb1;
  }

  /* Layout Styles */
  .chart-area {
      height: 250px; /* Define a specific height for charts */
  }
</style>

<div class="row">
    <!-- Overview Cards -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Total Stock Value</h4>
            </div>
            <div class="card-body">
                <h2>$12,345</h2>
                <p class="card-category">Current total value of stock</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Products in Stock</h4>
            </div>
            <div class="card-body">
                <h2>150</h2>
                <p class="card-category">Total products available</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Low Stock Alerts</h4>
            </div>
            <div class="card-body">
                <h2>5</h2>
                <p class="card-category">Products running low on stock</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Feed -->
<!-- Recent Activity Feed -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header" style="background-color: #f96332; color: #fff;">
                <h4 class="card-title">Recent Activity</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Added new product: Tangit</li>
                    <li class="list-group-item">Updated stock for Ampoule</li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section 
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Stock Trends</h4>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="stockTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-12 text-center">
        <button class="btn btn-info btn-lg" onclick="window.location.href='http://localhost:8000/materiaux';">
            <span class="fas fa-plus-circle"></span><br>Add New Material
        </button>
        <button class="btn btn-info btn-lg" onclick="window.location.href='http://localhost:8000/stock';">
            <span class="fas fa-edit"></span><br>Manage Stock
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script>
// JavaScript to render the stock trend chart
var ctx = document.getElementById('stockTrendChart').getContext('2d');
var stockTrendChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Stock Value',
            data: [12000, 19000, 15000, 25000, 22000],
            borderColor: '#f96332',
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
    });
</script>
@endsection