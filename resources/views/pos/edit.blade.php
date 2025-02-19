@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Edit Sale</h1>
    <form action="{{ route('pos.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="materiaux_id">Materiaux</label>
            <select name="materiaux_id" id="materiaux_id" class="form-control" required>
                @foreach($materiaux as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $sale->materiaux_id ? 'selected' : '' }}>
                        {{ $item->designation }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $sale->quantity }}" required min="1">
        </div>

        <div class="form-group">
            <label for="client_name">Client Name</label>
            <input type="text" name="client_name" id="client_name" class="form-control" value="{{ $sale->client_name }}" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Sale</button>
        <a href="{{ route('pos.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection