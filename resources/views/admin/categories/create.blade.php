@extends('layouts.master')

@section('title')
  Categorie | regideso
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
                <h4 class="card-title">Categories - Ajouter
                    <a href="{{ url('categorie') }}" class="btn btn-primary float-right back-button">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('categorie-store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nom_categorie">NOM CATEGORIE:</label>
                            <input type="text" name="nom_categorie" class="form-control" placeholder="NOM CATEGORIE" required>
                        </div>

                        <div class="form-group">
                            <label for="departement">DEPARTEMENT:</label>
                            <input type="text" name="departement" class="form-control" placeholder="NOM DU DEPARTEMENT" required>
                        </div>

                        <div class="form-group">
                            <label for="rangement">RANGEMENT:</label>
                            <input type="text" name="rangement" class="form-control" placeholder="NUMERO DE RANGEMENT" required>
                        </div>

                        <div class="form-group">
                            <label for="type_produit">TYPE PRODUIT:</label>
                            <input type="text" name="type_produit" class="form-control" placeholder="NOM DU PARTENAIRE" required>
                        </div>

                        <div class="form-group">
                            <label for="quantite">QUANTITE:</label>
                            <input type="text" name="quantite" class="form-control" placeholder="QUANTITE" required>
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