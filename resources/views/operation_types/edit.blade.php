@extends('layouts.master')

@section('title')
    Edit Operation Type
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Operation Type</h5>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('operation_types.update', $operationType->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $operationType->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $operationType->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('operation_types.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection