@extends('layouts.master')





@section('title')
  Materiaux Edit

@endsection


@section('content')

<div class="row">
  	<div class="col-md-12">
            <div class="card">
              <div class="card-header">
              	<h4 class="card-title"> materiaux - Edit Data</h4>
                
                <form action="{{ url('materiaux-update/'.$materiaux->id) }}" method="POST">
         {{ csrf_field() }}
         {{ method_field('PUT') }}

      <div class="modal-body">
        
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">No_code :</label>
            <input type="text" name="No_code"class="form-control" value="{{ $materiaux->No_code }}">
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">designation :</label>
            <input type="text" name="designation"class="form-control" value="{{ $materiaux->designation }}">
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">unite_emploie :</label>
            <input type="text" name="unite_emploie"class="form-control" value="{{ $materiaux->unite_emploie }}">
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">rangement :</label>
            <input type="text" name="rangement"class="form-control" value="{{ $materiaux->rangement }}">
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">quantite :</label>
            <input type="text" name="quantite"class="form-control" value="{{ $materiaux->quantite }}">
          </div>
          
        <div class="modal-footer">
        	<a href="{{ url('materiaux') }}" class="btn btn-secondary">BACK</a>
        <button type="submit" class="btn btn-primary">UPDATE</button>
      </div>
      </div>
      
      </form>
               
               </div>
           </div>
       </div>
</div>



@endsection



