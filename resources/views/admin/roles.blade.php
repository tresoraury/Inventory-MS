@extends('layouts.master')

@section('title')
    Roles
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Manage Roles & Permissions</h5>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('roles.update') }}" method="POST">
            @csrf
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Role</th>
                        @foreach ($permissions as $permission)
                            <th>{{ $permission->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            @foreach ($permissions as $permission)
                                <td>
                                    <input type="checkbox"
                                           name="permissions[{{ $role->id }}][]"
                                           value="{{ $permission->id }}"
                                           {{ $role->hasPermissionTo($permission->id) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Update Permissions</button>
        </form>
    </div>
</div>
@endsection