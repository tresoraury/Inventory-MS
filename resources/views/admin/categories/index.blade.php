@extends('layouts.master')


@section('title')
Categorie | regideso
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
                <h4 class="card-title"> categories
                  <a href="{{ url('categorie-create') }}" class="btn btn-primary float-right py-2">ajouter</a>                 
                </h4>
            </div>
                <div class="card-body">
				<div class="table-responsive">

					<table id="datatable" class="table" width="100%" border="1" style=border-collapse:collapse font-family: Trebuchet MS, Arial, Helvetica, sans-serif>
					<thead class=" text-primary">
						<tr>							
							<th><strong>id_categorie</strong></th>
							<th>nom_categorie</th>
							<th>departement</th>
							<th>rangement</th>
							<th>type_produit</th>
							<th>quantite</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categorie as $item)


						<tr>							
							<td>{{ $item->id_categorie }}</td>
							<td>{{ $item->nom_categorie }}</td>
							<td>{{ $item->departement }}</td>
							<td>{{ $item->rangement }}</td>
							<td>{{ $item->type_produit }}</td>
							<td>{{ $item->quantite }}</td>
							<td>
								<a href="" class="btn btn-info">Edit</a>
							</td>
							<td>
								<a href="" class="btn btn-danger">Delete</a>
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

@endsection


@section('scripts')
    <script>
   $(document).ready( function () {
    $('#datatable').DataTable();
    });
  </script>
@endsection