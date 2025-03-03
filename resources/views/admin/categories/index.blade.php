@extends('layouts.master')

@section('title')
  Categories
@endsection

@section('content')
<style>
  body {
      background-color: #f9f9f9; /* Light background */
      font-family: 'Montserrat', sans-serif;
  }

  .card {
      border-radius: 0.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      background-color: #ffffff;
  }

  .card-header {
      background-color: #4CAF50; /* Card header color */
      color: white;
      padding: 15px;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
  }

  table {
      width: 100%;
      border-collapse: collapse;
  }

  th, td {
      border: 1px solid #e0e0e0;
      padding: 15px;
      text-align: left;
  }

  th {
      background-color: #4CAF50;
      color: white;
      text-transform: uppercase;
  }

  tr:hover {
      background-color: #f2f2f2; /* Highlight on hover */
  }

  .btn {
      border-radius: 0.25rem;
      padding: 10px 15px;
      transition: background-color 0.3s, transform 0.2s;
  }

  .btn-primary {
      background-color: #007bff;
      color: white;
  }

  .btn-primary:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
  }

  .btn-info {
      background-color: #17a2b8;
      color: white;
  }

  .btn-info:hover {
      background-color: #138496;
      transform: translateY(-2px);
  }

  .btn-danger {
      background-color: #dc3545;
      color: white;
  }

  .btn-danger:hover {
      background-color: #c82333;
      transform: translateY(-2px);
  }

  @media (max-width: 768px) {
      th, td {
          padding: 10px;
      }
  }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Categories
                    <a href="{{ url('categorie-create') }}" class="btn btn-primary float-right">Ajouter</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th><strong>ID Categorie</strong></th>
                                <th>Nom Categorie</th>
                                <th>Départment</th>
                                <th>Rangement</th>
                                <th>Type Produit</th>
                                <th>Quantité</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorie as $item)
                            <tr>
                                <td>{{ $item->id_categorie }}</td>
                                <td>{{ $item->nom_categorie }}</td>
                                <td>{{ $item->departement }}</td>
                                <td>{{ $item->rangement }}</td>
                                <td>{{ $item->type_produit }}</td>
                                <td>{{ $item->quantite }}</td>
                                <td>
                                    <a href="{{ url('categorie-edit/'.$item->id_categorie) }}" class="btn btn-info">Edit</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger deletebtn">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#datatable').DataTable();

    $('#datatable').on('click', '.deletebtn', function() {
        // Logic for delete confirmation modal
        // Add your deletion logic here
    });
});
</script>
@endsection