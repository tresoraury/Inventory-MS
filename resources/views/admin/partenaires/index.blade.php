@extends('layouts.master')

@section('title')
  Partners
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
      background-color: #4CAF50; /* Header color */
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
                <h4 class="card-title">Partenaire
                    <a href="{{ url('partenaire-create') }}" class="btn btn-primary float-right py-2">Ajouter</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th><strong>ID Partenaire</strong></th>
                                <th>Type Partenaire</th>
                                <th>Nom Partenaire</th>
                                <th>Départment</th>
                                <th>Opération</th>
                                <th>Date Opération</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partenaire as $item)
                            <tr>
                                <td>{{ $item->id_partenaire }}</td>
                                <td>{{ $item->type_partenaire }}</td>
                                <td>{{ $item->nom_partenaire }}</td>
                                <td>{{ $item->departement }}</td>
                                <td>{{ $item->operation }}</td>
                                <td>{{ $item->date_operation }}</td>
                                <td>
                                    <a href="{{ url('partenaire-edit/'.$item->id_partenaire) }}" class="btn btn-info">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ url('partenaire-delete/'.$item->id_partenaire) }}" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
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
});
</script>
@endsection