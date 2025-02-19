@extends('layouts.master')

@section('title')
  Materiaux | regideso
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

  .btn-primary, .btn-info {
      border-radius: 0.25rem;
      padding: 10px 15px;
  }

  .modal-header {
      background-color: #4CAF50; /* Modal header color */
      color: white;
  }
</style>

<!-- Add Material Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouveau materiel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/save-materiaux" method="POST">
         {{ csrf_field() }}
      <div class="modal-body">
          <div class="form-group">
            <label for="No_code" class="col-form-label">No_code:</label>
            <input type="text" name="No_code" class="form-control" id="No_code" required>
          </div>
          <div class="form-group">
            <label for="designation" class="col-form-label">Designation:</label>
            <input type="text" name="designation" class="form-control" id="designation" required>
          </div>
          <div class="form-group">
            <label for="category_id" class="col-form-label">Catégorie:</label>
            <select name="category_id" class="form-control" id="category_id" required>
              @foreach($categories as $category)
                <option value="{{ $category->id_categorie }}">{{ $category->nom_categorie }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="unite_emploie" class="col-form-label">Unite Emploi:</label>
            <input type="text" name="unite_emploie" class="form-control" id="unite_emploie" required>
          </div>
          <div class="form-group">
            <label for="rangement" class="col-form-label">Rangement:</label>
            <input type="text" name="rangement" class="form-control" id="rangement" required>
          </div>
          <div class="form-group">
            <label for="quantite" class="col-form-label">Quantite:</label>
            <input type="number" name="quantite" class="form-control" id="quantite" required>
          </div>
          <div class="form-group">
            <label for="price" class="col-form-label">Prix:</label>
            <input type="number" name="price" class="form-control" id="price" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletemodalpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="delete_modal_form" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <div class="modal-body">
            <input type="hidden" id="delete_materiaux_id">
            <h5>Etes-vous sûr de vouloir supprimer cette donnée?</h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Oui, Supprimer</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Materiaux
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">Ajouter</button>
                    <a href="{{ url('/print-preview/materiaux') }}" class="btn btn-info float-right hidden-print mr-2">Imprimer la Fiche</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>No_code</th>
                                <th>Désignation</th>
                                <th>Unité Emploi</th>
                                <th>Rangement</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Catégorie</th>
                                <th>Éditer</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materiaux as $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->No_code }}</td>
                                <td>{{ $data->designation }}</td>
                                <td>{{ $data->unite_emploie }}</td>
                                <td>{{ $data->rangement }}</td>
                                <td>{{ $data->quantite }}</td>
                                <td>{{ $data->price }}</td>
                                <td>{{ $data->category ? $data->category->nom_categorie : 'N/A' }}</td>
                                <td>
                                    <a href="{{ url('materiaux-us/'.$data->id) }}" class="btn btn-success">Éditer</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger deletebtn">Supprimer</a>
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
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#delete_materiaux_id').val(data[0]);
        $('#delete_modal_form').attr('action', '/materiaux-delete/' + data[0]);
        $('#deletemodalpop').modal('show');
    });
});
</script>
@endsection