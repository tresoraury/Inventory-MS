@extends('layouts.master')

@section('content')
<div class="container mt-5"> 
    <h1 class="mb-4">Sales</h1> 
    <a href="{{ route('pos.create') }}" class="btn btn-primary mb-3">Make Sale</a>
    <table class="table table-striped"> 
        <thead>
            <tr>
                <th>ID</th>
                <th>Materiaux Name</th>
                <th>Quantity</th>
                <th>Client Name</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->materiaux ? $sale->materiaux->designation : 'N/A' }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->client_name }}</td>
                    <td>{{ $sale->total }}</td>
                    <td>
                        <a href="{{ route('pos.edit', $sale->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pos.destroy', $sale->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection