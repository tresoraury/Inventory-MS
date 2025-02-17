@extends('layouts.master')

@section('title')
  Materiaux Edit
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

  .btn-primary, .btn-secondary {
      border-radius: 0.25rem;
      padding: 10px 20px;
  }

  .btn-primary {
      background-color: #4CAF50; /* Button background color */
      border: none;
  }

  .btn-primary:hover {
      background-color: #45a049; /* Darker on hover */
  }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Materiaux - Edit Data</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('materiaux-update/'.$materiaux->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="No_code">No_code:</label>
                            <input type="text" name="No_code" class="form-control" value="{{ $materiaux->No_code }}" required>
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation:</label>
                            <input type="text" name="designation" class="form-control" value="{{ $materiaux->designation }}" required>
                        </div>
                        <div class="form-group">
                            <label for="unite_emploie">Unite Emploie:</label>
                            <input type="text" name="unite_emploie" class="form-control" value="{{ $materiaux->unite_emploie }}" required>
                        </div>
                        <div class="form-group">
                            <label for="rangement">Rangement:</label>
                            <input type="text" name="rangement" class="form-control" value="{{ $materiaux->rangement }}" required>
                        </div>
                        <div class="form-group">
                            <label for="quantite">Quantite:</label>
                            <input type="text" name="quantite" class="form-control" value="{{ $materiaux->quantite }}" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ url('materiaux') }}" class="btn btn-secondary">BACK</a>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection