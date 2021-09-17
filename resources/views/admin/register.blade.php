@extends('layouts.master')





@section('title')
  Registered Roles | regideso

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
                <h4 class="card-title"> Registered Roles</h4>
               @if (session('status'))
               <div class="alert alert-success" role="alert">
                 {{ session('status') }}
               </div>
               @endif

              </div>
              <div class="card-body">
                <div class="table-responsive">
                	
                  <table id="datatable" class="table" width="100%" border="1" style=border-collapse:collapse font-family: Trebuchet MS, Arial, Helvetica, sans-serif>
                    <thead class=" text-primary">
                      <th>
                        ID
                      </th>
                      <th>
                        Name
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        usertype
                      </th>
                      <th>
                        EDIT
                      </th>
                      <th>
                        DELETE
                      </th>
                    </thead>
                    <tbody>
                      @foreach ($users as $row)                  
                      <tr>
                        <td>
                          {{ $row->id }}
                        </td>
                        <td>
                          {{ $row->name }}
                        </td>
                        <td>
                          {{ $row->email }}
                        </td>
                        <td>
                          {{ $row->usertype }}
                        </td>                        
                        <td>
                          <a href="/role-edit/{{ $row->id }}" class="btn btn-sucess">EDIT</a>
                        </td>
                        <td>
                          <form action="/role-delete/{{ $row->id }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger">DELETE</button>
                        </form> 
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
} );
 </script>

@endsection