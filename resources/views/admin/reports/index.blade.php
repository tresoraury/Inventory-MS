@extends('layouts.master')

@section('title')
    Reports
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Reports</h1>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-box fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Products Report</h5>
                        <a href="{{ route('reports.products', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}" class="btn btn-outline-primary">View Report</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-exchange-alt fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Operations Report</h5>
                        <a href="{{ route('reports.operations', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}" class="btn btn-outline-primary">View Report</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Sales Report</h5>
                        <a href="{{ route('reports.sales', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}" class="btn btn-outline-primary">View Report</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Suppliers Report</h5>
                        <a href="{{ route('reports.suppliers', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}" class="btn btn-outline-primary">View Report</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-invoice fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Purchase Orders Report</h5>
                        <a href="{{ route('reports.purchase-orders', ['start_date' => request()->query('start_date'), 'end_date' => request()->query('end_date')]) }}" class="btn btn-outline-primary">View Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection