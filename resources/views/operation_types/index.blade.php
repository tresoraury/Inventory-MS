@extends('layouts.master')

@section('title')
    Operation Types
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Operation Types</h5>
            <a href="{{ route('operation_types.create') }}" class="btn btn-primary">Add Operation Type</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operationTypes as $operationType)
                    <tr>
                        <td>{{ $operationType->name }}</td>
                        <td>{{ $operationType->description ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('operation_types.edit', $operationType->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('operation_types.destroy', $operationType->id) }}" method="POST" class="d-inline">
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