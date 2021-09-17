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
<h1> Produits du stocks </h1>
<table class="table">
<tr><th>No_code</th><th>designation</th><th>unite_emploie</th><th>rangement</th><th>quantite</th></tr>
 @foreach($materiaux as $data)
<tr><td>{{ $data->No_code }}</td>
<td>{{ $data->designation }}</td>
<td>{{ $data->unite_emploie }}</td>
<td>{{ $data->rangement }}</td>
<td>{{ $data->partenaire }}</td>
<td>{{ $data->quantite }}</td>
</tr>
@endforeach
</center>