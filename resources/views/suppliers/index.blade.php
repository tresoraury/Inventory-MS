@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Suppliers</h1>
    <a href="{{ route('suppliers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Supplier</a>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Contact</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
                <td class="border px-4 py-2">{{ $supplier->name }}</td>
                <td class="border px-4 py-2">{{ $supplier->contact }}</td>
                <td class="border px-4 py-2">{{ $supplier->email }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $suppliers->links() }}
</div>
@endsection