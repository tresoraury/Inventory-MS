@extends('layouts.master')





@section('title')
  ACCEUIL ...

@endsection


@section('content')


<style>
  .button {
  color: red;
}

.card .card-chart{
      color: blue;
}

b{
  text-align: right;
   top: 200px;
   right: 200px;
}
.card-category{
  color: blue;
}
.card_image{
                 width: 130px;
                 height: 130px;
                 }
</style>
  <div class="row">
 

<div class="col-lg-4 col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">STOCK MANAGEMENT</h5>
                <h4 class="card-title">Tout les produit du stock</h4>
                                              
                <div class="dropdown">
                  <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                    <i class="now-ui-icons loader_gear"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="http://localhost:8000/materiaux">Les materiaux</a>
                    <a class="dropdown-item" href="http://localhost:8000/stock">les quantite reel</a>
                    <a class="dropdown-item" href="http://localhost:8000/magasin">Les operations</a>
                    
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-12 col-md-2">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">STOCK MANAGEMENT</h5>
                <h4 class="card-title">Image de quelques produits en stock</h4>
                <div class="card">
        <img class="card_image" src="ampoule.jpg" width="10px">
        <img class="card_image" src="cash.jpg" width="10px">
        <img class="card_image" src="tangit.jpg" width="10px">
        <img class="card_image" src="tuyeau.jpg" width="10px">
        <img class="card_image" src="detecteur.jpg" width="10px">
        <img class="card_image" src="disjoncteur.jpg" width="10px">
        <img class="card_image" src="vanne.jpg" width="10px">
        <img class="card_image" src="vanne2.jpg" width="10px">
        <img class="card_image" src="fonte.jpg" width="10px">
        <img class="card_image" src="cabel.jpg" width="10px">
    </div>                
                <div class="dropdown">
                  <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                    <i class="now-ui-icons loader_gear"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="http://localhost:8000/materiaux">Les materiaux</a>
                    <a class="dropdown-item" href="http://localhost:8000/stock">les quantite reel</a>
                    <a class="dropdown-item" href="http://localhost:8000/magasin">Les operations</a>
                    
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                </div>
              </div>
            </div>
          </div>

          <b> PRODUITS D'UN STOCK </b>
</div>
         

         <button class="btn btn-info btn-lg"><span class="fas fa-history fa-5x" style= height:100px;width:100px></span><br>HISTORIQUE</button>
        


<div class="card text-center">
  <div class="card-header card-header-rose">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="https://www.regideso.bi/index.php/actualites">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.regideso.bi/index.php/qui-sommes-nous/mission">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
  </div>
</div>





@endsection


@section('scripts')


@endsection