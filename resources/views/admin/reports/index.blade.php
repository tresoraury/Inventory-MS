@extends('layouts.master')

@section('title')
    Reports
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Reports</h5>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ route('reports.products') }}">Products Report</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('reports.operations') }}">Operations Report</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('reports.sales') }}">Sales Report</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('reports.suppliers') }}">Suppliers Report</a>
            </li>
        </ul>
    </div>
</div>
@endsection