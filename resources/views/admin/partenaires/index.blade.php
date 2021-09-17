@extends('layouts.master')


@section('title')
Partenaire | regideso
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
                <h4 class="card-title"> partenaire
                  <a href="{{ url('partenaire-create') }}" class="btn btn-primary float-right py-2">ajouter</a>                 
                </h4>
            </div>
                <div class="card-body">
				<div class="table-responsive">

					<table id="datatable" class="table" width="100%" border="1" style=border-collapse:collapse font-family: Trebuchet MS, Arial, Helvetica, sans-serif>
					<thead class=" text-primary">
						<tr>							
							<th><strong>id_partenaire</strong></th>
							<th>type_partenaire</th>
							<th>nom_partenaire</th>
							<th>departement</th>
							<th>operation</th>
							<th>date_operation</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach($partenaire as $item)


						<tr>							
							<td>{{ $item->id_partenaire }}</td>
							<td>{{ $item->type_partenaire }}</td>
							<td>{{ $item->nom_partenaire }}</td>
							<td>{{ $item->departement }}</td>
							<td>{{ $item->operation }}</td>
							<td>{{ $item->date_operation }}</td>
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