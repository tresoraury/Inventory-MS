@extends('layouts.master')


@section('title')
STOCKS REEL | regideso
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
        <h5 class="modal-title" id="exampleModalLabel">ACTUALISER LE STOCK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/save-stock" method="POST">
         {{ csrf_field() }}

      <div class="modal-body">
        
        <form id="form" novalidate>

          <div class="form-group">
          <label for="recipient-name" class="col-form-label">id_materiaux:</label>
            <input type="text" name="id_materiaux"class="form-control" id="recipient-name" required>
            <div class="invalid-feedback">
        Veuillez entrer un id
      </div>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">quantite:</label>
            <input type="text" name="quantite"class="form-control" id="recipient-name" required>
            <div class="invalid-feedback">
        Veuillez entrer la quantite
      </div>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">quantite_detaille:</label>
            <input type="text" name="quantite_detaille"class="form-control" id="recipient-name" required>
            <div class="invalid-feedback">
        Veuillez entrer la quantite detaille
      </div>
          </div>
          
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">ajouter</button>
      </div>
    </form>
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
        <h5 class="modal-title" id="exampleModalLabel">Suppression du stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="delete_modal_form" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            
                          
      <div class="modal-body">
        <input type="hidden" id="delete_stock_id_stock">
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
                <h4 class="card-title"> STOCKS REEL
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">ACTUALISER</button>
                 <center>
                 <br>
                   <a href="{{ url('/prnpriview') }}" class="btnprn btn float-right">IMPRIMER</a></center>
                      {{ csrf_field() }}
                </h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                	
                  <table id="datatable" class="table" width="100%" border="1" style=border-collapse:collapse font-family: Trebuchet MS, Arial, Helvetica, sans-serif>
                    <thead class=" text-primary">
                      <th>
                        id_stock
                      </th>
                      <th>
                        id_materiaux
                      </th>
                      <th>
                        quantite
                      </th>
                      <th>
                        quantite_detaille
                      </th>
                      <th>
                        EDIT
                      </th>
                      <th>
                        DELETE
                      </th>
                    </thead>
                    <tbody>
                      @foreach ($stock as $data)
                      <tr>
                        <td>
                          {{ $data->id_stock }}
                        </td>
                        <td>
                          {{ $data->id_materiaux }}
                        </td>
                        <td>
                          {{ $data->quantite }}
                        </td>
                        <td>
                          {{ $data->quantite_detaille }}
                        </td>
                        <td>
                          <a href="{{ url('stock-us/'.$data->id_stock) }}" class="btn btn-success">EDIT</a>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-danger deletebtn">DELETE</a>
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


      $('#delete_stock_id_stock').val(data[0]);

      $('#delete_modal_form').attr('action', '/stock-us-delete/'+data[0]);

      $('#deletemodalpop').modal('show');

       
       
      $(function () {
  $('form').submit(function(event) {
    if (this.checkValidity() == false) {
      event.preventDefault()
      event.stopPropagation()
    }
    $(this).addClass("was-validated");
  });
});





    });

    });
  </script>
@endsection  