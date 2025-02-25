@extends('layouts.master')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Low Stock Items</h1>

    @if ($lowStockItems->isEmpty())
        <p>No items are below the low stock .</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>No_code</th>
                <th>Désignation</th>
                <th>Stock Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lowStockItems as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->No_code }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->stock_level }}</td>
                </tr>
            @endforeach
        </tbody>
</table>
    @endif
</div>
@endsection