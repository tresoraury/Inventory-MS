@extends('layouts.master')

@section('title', 'Create Input Operation')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ajouter une Opération d'Entrée</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('input.operations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="materiel_id">Materiel</label>
                <select name="materiel_id" id="materiel_id" class="form-control" required>
                    @foreach($materiaux as $materiel)
                        <option value="{{ $materiel->id }}">{{ $materiel->designation }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" name="quantite" id="quantite" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection