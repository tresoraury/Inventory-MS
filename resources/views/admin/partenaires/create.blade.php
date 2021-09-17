@extends('layouts.master')


@section('title')
Partenaire | regideso
@endsection


@section('content')


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                <h4 class="card-title"> partenaire - ajouter
                      <a href="{{ url('partenaire') }}" class="btn btn-primary float-right py-2">Back</a>              
                </h4>
                
              </div>
              
              <div class="card-body">
        <form action="{{ url('partenaire-store') }}" method="POST">
                 {{ csrf_field() }}
                 

                 

        <div class="modal-body">
          

          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> NOM PARTENAIRE :</label>
              <input type="text" name="nom_partenaire"class="form-control" placeholder="NOM PARTENAIRE" required>
          </div>
        </div>

            

          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> TYPE DE PARTENAIRE :</label>
              <input type="text" name="type_partenaire"class="form-control" placeholder="TYPE PARTENAIRE" required>
          </div>
        </div>  

          

          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> DEPARTEMENT :</label>
              <input type="text" name="departement"class="form-control" placeholder="DEPARTEMENT" required>
          </div>
        </div>

  
          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> OPERATION :</label>
              <input type="text" name="operation"class="form-control" placeholder="OPERATION" required>
          </div>
        </div>
            

            <div class="col-md-20">
          <div class="form-group">
          <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> DATE_OPERATION :</label>
          <input type="date" name="date_operation"class="form-control" required>
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


             <div class="col-md-12">
          <button type="submit" class="btn btn-info">SAVE</button>
        </div>

              </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection