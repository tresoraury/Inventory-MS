@extends('layouts.master')

@section('title')
    Reports
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Reports</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Reports</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar mr-1"></i>
                Generate Reports
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ route('reports.products', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}">Products Report</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('reports.operations', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}">Operations Report</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('reports.sales', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}">Sales Report</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('reports.suppliers', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}">Suppliers Report</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('reports.purchase-orders', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}">Purchase Orders Report</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection