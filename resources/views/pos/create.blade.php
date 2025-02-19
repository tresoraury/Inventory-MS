@extends('layouts.master')

@section('content')
<div class="container mt-5"> 
    <h1 class="mb-4">Add Sale</h1> 
    <form action="{{ route('pos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="materiaux_id">Materiaux</label>
            <select name="materiaux_id" id="materiaux_id" class="form-control">
                @foreach($materiaux as $item)
                    <option value="{{ $item->id }}">{{ $item->designation }}</option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="client_name">Client Name</label>
            <input type="text" name="client_name" id="client_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Submit Sale</button> 
    </form>
</div>
@endsection