@extends('layouts.master')





@section('title')
  Magasin | regideso

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




<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                <h4 class="card-title"> Liste des Operations
                  <a href="{{ url('produit-create') }}" class="btn btn-primary float-right py-2">EFFECTUER UNE OPERATION</a>
                  <br>
                  <a href="{{ url('/prnpriview') }}" class="btn btn-primary float-right hidden-print">IMPRIMER LA FICHE</a>
                   {{ csrf_field() }}
                   
                </h4>
                
              
			<div class="card-body">
				<div class="table-responsive">

					<table id="datatable" class="table" width="100%" border="1" style=border-collapse:collapse font-family: Trebuchet MS, Arial, Helvetica, sans-serif>
					<thead class=" text-primary">
						<tr>							
							<th><strong>id_operation</strong></th>
							<th>materiel_id</th>
							<th>type_operation</th>
							<th>designation</th>
							<th>partenaire</th>
							<th>date_operation</th>
							<th>quantite</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach($magasin as $item)


						<tr>
													
							<td>{{ $item->id_operation }}</td>
							<td>{{ $item->id_name }}</td>
							<td>{{ $item->materiel_id }}</td>
							<td>{{ $item->type_operation }}</td>
							<td>{{ $item->designation }}</td>
							<td>{{ $item->partenaire }}</td>
							<td>{{ $item->date_operation }}</td>
							<td>{{ $item->quantite }}</td>
							<td>
								<a href="{{ url('magasin-edit/'.$item->id_operation) }}" class="btn btn-info">Edit</a>
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
</div>



@endsection

@section('scripts')

    <script>
   $(document).ready( function () {
    $('#datatable').DataTable();
    });


   $('#datatable').on('click','.deletebtn', function(){
      $tr = $(this).closest('tr');

      var data = $tr.children("td").map(function (){
        return $(this).text();
      }).get();

      //console.log(data);


      $('#delete_magasin_id_operation').val(data[0]);

      $('#delete_modal_form').attr('action', '/magasin-delete/'+data[0]);

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
   
  </script>

  
@endsection