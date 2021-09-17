@extends('layouts.master')


@section('title')
Categorie | regideso
@endsection


@section('content')


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                <h4 class="card-title"> categories - ajouter
                      <a href="{{ url('categorie') }}" class="btn btn-primary float-right py-2">Back</a>              
                </h4>
                
              </div>
              
              <div class="card-body">
        <form action="{{ url('categorie-store') }}" method="POST">
                 {{ csrf_field() }}
                 

                 

        <div class="modal-body">
          

          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> NOM CATEGORIE :</label>
              <input type="text" name="nom_categorie"class="form-control" placeholder="NOM CATEGORIE" required>
          </div>
        </div>

            

          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> DEPARTEMENT :</label>
              <input type="text" name="departement"class="form-control" placeholder="NOM DU DEPARTEMENT" required>
          </div>
        </div>  

          

          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> RANGEMENT :</label>
              <input type="text" name="rangement"class="form-control" placeholder="NUMERO DE RANGEMENT" required>
          </div>
        </div>

  
          <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> TYPE PRODUIT :</label>
              <input type="text" name="type_produit"class="form-control" placeholder="NOM DU PARTENAIRE" required>
          </div>
        </div>
            

            <div class="col-md-20">   
            <div class="form-group">
              <label for="recipient-name" class="col-form-label" style= color:black;font-size:120%> QUANTITE :</label>
              <input type="text" name="quantite"class="form-control" placeholder="NOM DU PARTENAIRE" required>
          </div>
        </div>


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