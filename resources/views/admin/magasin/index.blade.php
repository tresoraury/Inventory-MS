@extends('layouts.master')

@section('title')
  Operations 
@endsection

@section('content')

<style>
  body {
      background-color: #f9f9f9; 
      font-family: 'Montserrat', sans-serif;
  }

  .card {
      border-radius: 0.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      background-color: #ffffff;
  }

  .card-header {
      background-color: #4CAF50; 
      color: white;
      padding: 15px;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
  }

  table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
  }

  th, td {
      border: 1px solid #e0e0e0;
      padding: 12px;
      text-align: left;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
  }

  th {
      background-color: #4CAF50;
      color: white;
      text-transform: uppercase;
  }

  tr:hover {
      background-color: #f2f2f2; 
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
      table {
          font-size: 12px;
      }
      th, td {
          padding: 10px;
      }
  }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Liste des Operations
                    <a href="{{ url('produit-create') }}" class="btn btn-primary float-right">Effectuer une Operation</a>
                    <a href="{{ url('/print-preview/magasin') }}" class="btn btn-info float-right mr-2 hidden-print">Imprimer la Fiche</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th><strong>ID Operation</strong></th>
                                <th>Product</th>
                                <th>Type Operation</th>
                                <th>Désignation</th>
                                <th>Issued By</th>
                                <th>Date Operation</th>
                                <th>Quantité</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($magasin as $item)
                            <tr>
                                <td>{{ $item->id_operation }}</td>
                                <td>{{ $item->materiel->designation ?? 'N/A' }}</td>
                                <td>{{ $item->type->name ?? 'N/A' }}</td> 
                                <td>{{ $item->designation }}</td>
                                <td>{{ $item->partenaire }}</td>
                                <td>{{ $item->date_operation }}</td>
                                <td>{{ $item->quantite }}</td>
                                <td>
                                    <a href="{{ url('magasin-edit/'.$item->id_operation) }}" class="btn btn-info">Edit</a>
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

<div class="modal fade" id="deletemodalpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #4CAF50; color: white;">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this operation?
            </div>
            <div class="modal-footer">
                <form id="delete_modal_form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
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

        $('#delete_modal_form').attr('action', '/magasin-delete/' + data[0]);
        $('#deletemodalpop').modal('show');
    });
});
</script>
@endsection