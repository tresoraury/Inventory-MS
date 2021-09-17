@extends('layouts.master')





@section('title')
  Materiaux | regideso

@endsection


@section('content')


<style>
  td {
    
    border: 1px solid #ddd;
  padding: 8px;
  }
  th {
    background-color: #4CAF50;
    color: white;
  }
</style>


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
            <label for="recipient-name" class="col-form-label">No_code:</label>
            <input type="text" name="No_code"class="form-control" id="recipient-name" required>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">designation:</label>
            <input type="text" name="designation"class="form-control" id="recipient-name" required>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">unite_emploie:</label>
            <input type="text" name="unite_emploie"class="form-control" id="recipient-name" required>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">rangement:</label>
            <input type="text" name="rangement"class="form-control" id="recipient-name" required>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">quantite:</label>
            <input type="text" name="quantite"class="form-control" id="recipient-name" required>
          </div>
          
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">ajouter</button>
      </div>
      </div>
      
      </form>
    </div>
  </div>
</div>

{{-- Delete - model --}}
<!-- Model -->

<!-- Modal -->
<div class="modal fade" id="deletemodalpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="delete_modal_form" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            
                          
      <div class="modal-body">
        <input type="hidden" id="delete_materiaux_id">
        <h5>Etes-vous sur de vouloir supprimer cette donnee.?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Yes, Delete It</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- end - delete model --}}


 <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Materiaux
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">AJOUTER</button>
                  <a href="{{ url('/prnpriview') }}" class="btn btn-primary float-right hidden-print">IMPRIMER LA FICHE</a>
                  <form action="http://localhost:8000/produit-create">
          <button  type="submit" class="btn btn-info">DISPONIBILITE DU MATERIEL</button required>
        </form>
                </h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                	
                  <table id="datatable" class="table" width="100%" border="1" style=border-collapse:collapse font-family: Trebuchet MS, Arial, Helvetica, sans-serif>
                    <thead class=" text-primary">
                      <th>
                        id
                      </th>
                      <th>
                        No_code
                      </th>
                      <th>
                        designation
                      </th>
                      <th>
                        unite_emploie
                      </th>
                      <th>
                        rangement
                      </th>
                      <th>
                        quantite
                      </th>
                      <th>
                        EDIT
                      </th>
                      <th>
                        DELETE
                      </th>
                    </thead>
                    <tbody>
                      @foreach ($materiaux as $data)
                      <tr>
                        <td>
                          {{ $data->id }}
                        </td>
                        <td>
                          {{ $data->No_code }}
                        </td>
                        <td>
                          {{ $data->designation }}
                        </td>
                        <td>
                          {{ $data->unite_emploie }}
                        </td>
                        <td>
                          {{ $data->rangement }}
                        </td>
                        <td>
                          {{ $data->quantite }}
                        </td>
                        <td>
                          <a href="{{ url('materiaux-us/'.$data->id) }}" class="btn btn-success">EDIT</a>
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
   $(document).ready( function () {
    $('#datatable').DataTable();


    $('#datatable').on('click','.deletebtn', function(){
      $tr = $(this).closest('tr');

      var data = $tr.children("td").map(function (){
        return $(this).text();
      }).get();

      //console.log(data);


      $('#delete_materiaux_id').val(data[0]);

      $('#delete_modal_form').attr('action', '/materiaux-delete/'+data[0]);

      $('#deletemodalpop').modal('show');
    });
} );
 </script>

@endsection