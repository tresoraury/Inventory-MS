@extends('layouts.master')





@section('title')
  Magasin | regideso

@endsection


@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                <h4 class="card-title"> OPERATIONS - MODIFIER 

                <a href="{{ url('magasin') }}" class="btn btn-primary float-right py-2 ">Back</a>            
                </h4>
                
              </div>
			<div class="card-body">
				<form action="{{ url('magasin-update/'.$magasin->id_operation) }}" method="POST">
                 {{ csrf_field() }}
                 {{ method_field('PUT') }}
                 

                 

				<div class="modal-body">
					

					<div class="col-md-5">		
						<div class="form-group">
							<label for="select" class="col-form-label" style= color:black;font-size:120%> MATERIEL_ID :</label>
							 <input type="text" name="materiel_id"class="form-control" value="{{ $magasin->materiel_id }}">
							 


							 
							
							

							

					</div>
				</div>


					<div class="col-md-15">
						<div class="form-group">
					<label for="select" style= color:black;font-size:120%> TYPE D'OPERATION :</label>
  <select id="select" name="type_operation"class="form-control">{{ $magasin->type_operation}}>
    <option>ENTREE</option>
    <option>SORTIE</option>
    <option>TRANSFERT</option>
    <option>VENTE</option>
    <option>REQUISITION</option>
    <option>PRET</option>	
  </select>
</div>
</div>
				
				
						
						<div class="col-md-15">		
						<div class="form-group">
							<label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> DESIGNATION :</label>
							<input type="text" name="designation"class="form-control" value="{{ $magasin->designation }}">
					</div>
				</div>
				
				<div class="col-md-15">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> PARTENAIRE :</label>
							<input type="text" name="partenaire"class="form-control" value="{{ $magasin->partenaire }}">
					</div>
				</div>
				<div class="col-md-15">
					<div class="form-group">
					<label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> DATE_OPERATION :</label>
					<input type="date" name="date_operation"class="form-control" value="{{ $magasin->date_operation }}">
                </div>
            </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker10').datetimepicker({
                viewMode: 'years',
                format: 'YYYY/MM'
            });
        });
    </script>

				<div class="col-md-15">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> QUANTITE :</label>
							<input type="text" name="quantite"class="form-control" value="{{ $magasin->quantite }}">
					</div>
				</div> 
				
				<div class="col-md-12">
					<button type="submit" class="btn btn-info">Modifier </button>
				</div>
			</div>
		</form>
		
</div>
</div>
</div>
</div>



@endsection