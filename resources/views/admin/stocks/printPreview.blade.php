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
  width: 150px;
  height: 70px;
  }
  th {
    background-color: #4CAF50;
    color: white;
    font-size: 1.875em;
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
<h1> NOMBRE DISPONIBLE DES PRODUIT DANS LE STOCK </h1>
<table class="table">
<tr><th>id_stock</th><th>id_materiaux</th><th>quantite</th><th>quantite_detaille</th></tr>
 @foreach($stock as $data)
<tr><td>{{ $data->id_stock }}</td>
<td>{{ $data->id_materiaux }}</td>
<td>{{ $data->quantite }}</td>
<td>{{ $data->quantite_detaille }}</td> </tr>
@endforeach
</center>
