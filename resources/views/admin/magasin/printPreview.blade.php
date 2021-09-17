<center>
<br><br>
<style>
	.card_image{
                 width: 100px;
                 height: 100px;
                 top: 150px;
                 right: 300px;
             }
    td {
    
    border: 1px solid #ddd;
  padding: 15px;
  width: 20px;
  height: 50px;
  }
  th {
    background-color: #4CAF50;
    color: white;
    font-size: 1em;
      }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://www.position-absolute.com/creation/print/jquery.printPage.js"></script>
<a href="{{ url('/prnpriview') }}" class="btnprn btn">Print Preview</a></center>
{{ csrf_field() }}
<script type="text/javascript">
$(document).ready(function(){
$('.btnprn').printPage();
});
</script>
<div class="card">
        <img class="card_image" src="photo.jpg" width="200px">
    </div>
<center>
<h1> OPERATION EFFECTUEES </h1>
<table class="table">
<tr><th>id_operation</th><th>materiel_id</th><th>type_operation</th><th>designation</th><th>partenaire</th><th>date_operation</th><th>quantite</th></tr>
 @foreach($magasin as $item)
<tr><td>{{ $item->id_operation }}</td>
<td>{{ $item->materiel_id }}</td>
<td>{{ $item->type_operation }}</td>
<td>{{ $item->designation }}</td>
<td>{{ $item->partenaire }}</td>
<td>{{ $item->date_operation }}</td>
<td>{{ $item->quantite }}</td>
</tr>
@endforeach
</center>