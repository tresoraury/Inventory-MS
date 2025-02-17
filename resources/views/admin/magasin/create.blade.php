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

  .form-group label {
      font-size: 1.1rem;
      color: #333;
  }

  .form-control {
      border-radius: 0.25rem;
      border: 1px solid #ddd;
      padding: 10px;
      transition: border-color 0.2s;
  }

  .form-control:focus {
      border-color: #4CAF50;
      box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
  }

  .btn-info {
      border-radius: 0.25rem;
      padding: 10px 20px;
      background-color: #4CAF50;
      border: none;
  }

  .btn-info:hover {
      background-color: #45a049;
  }

  .back-button {
      margin-top: 15px;
  }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Operations
                    <a href="{{ url('magasin') }}" class="btn btn-primary float-right back-button">Back</a>
                </h4>
            </div>

            <form action="{{ url('product-store') }}" method="POST">
                {{ csrf_field() }}

                <div class="card-body">
                    <div class="modal-body">

                        <div class="col-md-5">		
                            <div class="form-group">
                                <label for="materiel_id">MATERIEL :</label>
                                <select name="materiel_id" class="form-control" required>
                                    <option value="">Sélectionner un produit...</option>
                                    @foreach($materiaux as $materiel)
                                        <option value="{{ $materiel->id }}">{{ $materiel->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="type_operation">TYPE D'OPERATION:</label>
                                <select id="type_operation" name="type_operation" class="form-control" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($operationTypes as $operationType)
                                        <option value="{{ $operationType->id }}">{{ $operationType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">		
                            <div class="form-group">
                                <label for="designation">DESIGNATION:</label>
                                <input type="text" name="designation" class="form-control" placeholder="DESIGNATION" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="partenaire">PARTENAIRE:</label>
                                <input type="text" name="partenaire" class="form-control" placeholder="PARTENAIRE" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="date_operation">DATE OPERATION:</label>
                                <input type="date" name="date_operation" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="quantite">QUANTITE:</label>
                                <input type="text" name="quantite" class="form-control" placeholder="LA QUANTITE" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info">SAVE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection