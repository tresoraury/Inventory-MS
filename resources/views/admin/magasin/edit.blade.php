@extends('layouts.master')

@section('title')
  Magasin | regideso
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

  .form-group label {
      font-size: 1.1rem; /* Label font size */
      color: #333; /* Darker text for better readability */
  }

  .form-control {
      border-radius: 0.25rem;
      border: 1px solid #ddd;
      padding: 10px;
      transition: border-color 0.2s;
  }

  .form-control:focus {
      border-color: #4CAF50; /* Change border color on focus */
      box-shadow: 0 0 5px rgba(76, 175, 80, 0.5); /* Focus shadow */
  }

  .btn-info {
      border-radius: 0.25rem;
      padding: 10px 20px;
      background-color: #4CAF50; /* Button background color */
      border: none;
  }

  .btn-info:hover {
      background-color: #45a049; /* Darker on hover */
  }

  .back-button {
      margin-top: 15px;
  }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">OPERATIONS - MODIFIER
                    <a href="{{ url('magasin') }}" class="btn btn-primary float-right back-button">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('magasin-update/'.$magasin->id_operation) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="modal-body">
                        <div class="col-md-5">		
                            <div class="form-group">
								<label for="materiel_id">MATERIEL:</label>
        						<select name="materiel_id" class="form-control" required>
            						<option value="">Sélectionner un produit...</option>
            						@foreach($materiaux as $materiel)
                						<option value="{{ $materiel->id }}" {{ $magasin->materiel_id == 		$materiel->id ? 'selected' : '' }}>
                    					{{ $materiel->designation }}
               						 	</option>
            						@endforeach
       						 	</select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="type_operation">TYPE D'OPERATION:</label>
                                <select id="type_operation" name="type_operation" class="form-control" required>
                                    <option value="{{ $magasin->type_operation }}" selected>{{ $magasin->type_operation }}</option>
                                    <option>ENTREE</option>
                                    <option>SORTIE</option>
                                    <option>TRANSFERT</option>
                                    <option>VENTE</option>
                                    <option>REQUISITION</option>
                                    <option>PRET</option>	
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">		
                            <div class="form-group">
                                <label for="designation">DESIGNATION:</label>
                                <input type="text" name="designation" class="form-control" value="{{ $magasin->designation }}" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="partenaire">PARTENAIRE:</label>
                                <input type="text" name="partenaire" class="form-control" value="{{ $magasin->partenaire }}" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="date_operation">DATE OPERATION:</label>
                                <input type="date" name="date_operation" class="form-control" value="{{ $magasin->date_operation }}" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="quantite">QUANTITE:</label>
                                <input type="text" name="quantite" class="form-control" value="{{ $magasin->quantite }}" required>
                            </div>
                        </div> 
                        
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection