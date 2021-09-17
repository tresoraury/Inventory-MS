@extends('layouts.master')


@section('title')
STOCKS REEL Modifier | regideso
@endsection


@section('content')

<div class="row">
  	<div class="col-md-12">
            <div class="card">
              <div class="card-header">
              	<h4 class="card-title"> stock - Modifier Data</h4>
                
                <form action="{{ url('stock-update/'.$stock->id_stock) }}" method="POST">
         {{ csrf_field() }}
         {{ method_field('PUT') }}

      <div class="modal-body">
        
        <div class="form-group">
          <label for="recipient-name" class="col-form-label">id_materiaux:</label>
            <input type="text" name="id_materiaux"class="form-control" id="recipient-name" value="{{ $stock->id_materiaux }}">
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">quantite:</label>
            <input type="text" name="quantite"class="form-control" id="recipient-name" value="{{ $stock->quantite }}">
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">quantite_detaille:</label>
            <input type="text" name="quantite_detaille"class="form-control" id="recipient-name" value="{{ $stock->quantite_detaille }}">
          </div>
          
        <div class="modal-footer">
        <a href="{{ url('stock') }}" class="btn btn-secondary">BACK</a>
        <button type="submit" class="btn btn-primary">MODIFIER</button>
      </div>
  </form>
</div>
</div>
</div>
</div>



@endsection