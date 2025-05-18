@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <div class="card">
            <div class="card-body">
                <h5>Total Products: {{ $totalProducts }}</h5>
                <h5>Low Stock Products: {{ $lowStock }}</h5>
            </div>
        </div>
    </div>
@endsection