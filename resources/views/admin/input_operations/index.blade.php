@extends('layouts.master')

@section('title', 'Input Operations')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Liste des Entrées</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Materiel</th>
                    <th>Quantité</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inputOperations as $operation)
                <tr>
                    <td>{{ $operation->id }}</td>
                    <td>{{ $operation->materiel->designation }}</td>
                    <td>{{ $operation->quantite }}</td>
                    <td>{{ $operation->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection