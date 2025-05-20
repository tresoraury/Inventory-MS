@extends('layouts.master')
@section('title', 'Create Operation Type')
@section('content')
<div class="container">
    <h1 class="my-4">Create Operation Type</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('operation_types.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('operation_types.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection