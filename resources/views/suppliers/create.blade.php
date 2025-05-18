@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Add Supplier</h1>
    <form action="{{ route('suppliers.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required>
            @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="contact" class="block text-sm font-medium">Contact</label>
            <input type="text" name="contact" id="contact" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium">Address</label>
            <textarea name="address" id="address" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Supplier</button>
    </form>
</div>
@endsection