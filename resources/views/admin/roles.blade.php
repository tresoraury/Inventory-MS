@extends('layouts.master')

@section('title', 'Manage Roles')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Manage Roles</h1>
    <form method="POST" action="{{ route('roles.update') }}">
        @csrf
        <div class="roles-container">
            @foreach($roles as $role)
                <div class="role-card">
                    <h3>{{ $role->name }}</h3>
                    <div class="permissions">
                        <label>
                            <input type="checkbox" name="permissions[{{ $role->id }}][view_home]" {{ $role->permissions->contains('name', 'view_home') ? 'checked' : '' }}> View Home Page
                        </label>
                        <label>
                            <input type="checkbox" name="permissions[{{ $role->id }}][view_product]" {{ $role->permissions->contains('name', 'view_product') ? 'checked' : '' }}> View Product Page
                        </label>
                        <label>
                            <input type="checkbox" name="permissions[{{ $role->id }}][add_product]" {{ $role->permissions->contains('name', 'add_product') ? 'checked' : '' }}> Add Product
                        </label>
                        <label>
                            <input type="checkbox" name="permissions[{{ $role->id }}][edit_product]" {{ $role->permissions->contains('name', 'edit_product') ? 'checked' : '' }}> Edit Product
                        </label>
                        <label>
                            <input type="checkbox" name="permissions[{{ $role->id }}][delete_product]" {{ $role->permissions->contains('name', 'delete_product') ? 'checked' : '' }}> Delete Product
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #343a40;
    }

    .roles-container {
        margin-top: 20px;
    }

    .role-card {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: box-shadow 0.3s ease;
    }

    .role-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .permissions label {
        display: block;
        margin: 5px 0;
        color: #495057;
    }

    input[type="checkbox"] {
        width: 20px; 
        height: 20px; 
        accent-color: orange; 
        margin-right: 10px; 
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection