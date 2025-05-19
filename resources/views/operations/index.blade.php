@extends('layouts.master')

@section('title')
    Operations
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Operations</h5>
            <a href="{{ route('operations.create') }}" class="btn btn-primary">Add Operation</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operations as $operation)
                    <tr>
                        <td>{{ $operation->product->name }}</td>
                        <td>{{ $operation->operationType->name }}</td>
                        <td>{{ $operation->quantity }}</td>
                        <td>{{ $operation->operation_date }}</td>
                        <td>{{ $operation->supplier ? $operation->supplier->name : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('operations.edit', $operation->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('operations.destroy', $operation->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection