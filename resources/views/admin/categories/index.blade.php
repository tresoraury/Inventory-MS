@extends('layouts.master')

@section('title')
  Category
@endsection

@section('content')

<style>
  body {
      background-color: #f5f5f5; /* Light background */
      font-family: 'Montserrat', sans-serif;
  }

  .card {
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
  }

  .card-header {
      background-color: #4CAF50; /* Card header color */
      color: white;
  }

  table {
      width: 100%;
      border-collapse: collapse;
  }

  th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
  }

  th {
      background-color: #4CAF50;
      color: white;
  }

  tr:hover {
      background-color: #f1f1f1; /* Highlight on hover */
  }

  .btn-primary, .btn-info, .btn-danger {
      border-radius: 0.25rem;
      padding: 10px 15px;
  }
</style>

<!-- Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Categories
                    <a href="{{ url('categorie-create') }}" class="btn btn-primary float-right py-2">Ajouter</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class=" text-primary">
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