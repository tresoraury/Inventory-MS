<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stocks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class StocksController extends Controller
{
    public function index()
    {
    	$stock = Stocks::all();
    	return view('admin.stock')
    	  ->with('stock',$stock);
    }

    public function store(Request $request)
    {
        $stock = new Stocks;

        $stock->id_materiaux = $request->input('id_materiaux');
        $stock->quantite = $request->input('quantite');
        $stock->quantite_detaille = $request->input('quantite_detaille');

        $stock->save();
        Session::flash('statuscode','success');
        return redirect('/stock')->with('status','Le stock a ete actualise');
    }

    public function edit($id_stock)
    {
        $stock = Stocks::findOrfail($id_stock);
        return view('admin.stocks.edit')->with('stock',$stock);
    }

    public function update(Request $request, $id_stock)
    {
        $stock = Stocks::findOrfail($id_stock);
        $stock->id_materiaux = $request->input('id_materiaux');
        $stock->quantite = $request->input('quantite');
        $stock->quantite_detaille = $request->input('quantite_detaille');
        $stock->update();

        return redirect('stock')->with('status','le stock a ete modifie');
    }

    public function delete($id_stock)
    {
        $stock = Stocks::findOrfail($id_stock);
        $stock->delete();

        return redirect('stock')->with('status','le stock a ete supprime');
    }

    public function indexx()
    {
        $stock = Stocks::all();
        return view('admin.stocks.printPreview')->with('stock',$stock);      
    }

    public function printPreview()
    {
        $stock = Stocks::all();
        return view('printPreview',compact('stocks'));
    }
    
}
