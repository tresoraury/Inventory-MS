@extends('layouts.master')

@section('title')
  Magasin | regideso
@endsection

@section('content')

<style>
  body {
      background-color: #f5f5f5; 
      font-family: 'Montserrat', sans-serif;
  }

  .card {
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
  }

  .card-header {
      background-color: #4CAF50; 
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
      background-color: #f1f1f1; 
  }

  .btn-primary, .btn-info, .btn-danger {
      border-radius: 0.25rem;
      padding: 10px 15px;
  }

  .modal-header {
      background-color: #4CAF50; 
      color: white;
  }
</style>

<!-- Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Liste des Operations
                    <a href="{{ url('produit-create') }}" class="btn btn-primary float-right py-2">Effectuer une Operation</a>
                    <a href="{{ url('/print-preview/magasin') }}" class="btn btn-info float-right hidden-print mr-2">Imprimer la Fiche</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th><strong>ID Operation</strong></th>
                                <th>Product </th>
                                <th>Type Operation</th>
                                <th>Désignation</th>
                                <th>Issues By</th>
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

        $('#delete_magasin_id_operation').val(data[0]);
        $('#delete_modal_form').attr('action', '/magasin-delete/' + data[0]);
        $('#deletemodalpop').modal('show');
    });
});
</script>
@endsection