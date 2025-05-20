@extends('layouts.master')
@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Operation Types</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('operation_types.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add Operation Type</a>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Name</th>
                <th class="border border-gray-300 px-4 py-2">Description</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($operationTypes as $operationType)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $operationType->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $operationType->description ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('operation_types.edit', $operationType->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                        <form action="{{ route('operation_types.destroy', $operationType->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection