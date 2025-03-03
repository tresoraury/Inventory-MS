@extends('layouts.master')

@section('title')
  ACCEUIL ...
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
      color: black; /* Set title color to black */
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

<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Total Stock Value</h4>
            </div>
            <div class="card-body">
                <h2 style="color: black;">5000</h2>
                <p class="card-category" style="color: black;">Current total value of stock</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Products in Stock</h4>
            </div>
            <div class="card-body">
                <h2 style="color: black;">10</h2>
                <p class="card-category" style="color: black;">Total products available</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Low Stock Alerts</h4>
            </div>
            <div class="card-body">
                <h2 style="color: black;">5</h2>
                <p class="card-category" style="color: black;">Products running low on stock</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header" style="background-color: #f96332; color: #fff;">
                <h4 class="card-title">Recent Activity</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Added new product: computers</li>
                    <li class="list-group-item">Updated stock for tanks</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <button class="btn btn-info btn-lg" onclick="window.location.href='http://localhost:8000/materiaux';">
            <span class="fas fa-plus-circle"></span><br>Add New Products
        </button>
        <button class="btn btn-info btn-lg" onclick="window.location.href='http://localhost:8000/reports';">
            <span class="fas fa-edit"></span><br>Generate Reports
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script>
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