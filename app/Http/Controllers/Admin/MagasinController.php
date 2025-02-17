<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OperationType;
use App\Models\Produits;
use App\Models\Materiaux;
use Session;

class MagasinController extends Controller
{
    public function index()
    {
    	$materiaux = Materiaux::all();
    	$magasin = Produits::with(['materiel', 'type'])->get();
    	return view('admin.magasin.index')
        ->with('materiaux',$materiaux)
        ->with('magasin',$magasin);
    }
    public function create()
    {
        $materiaux = Materiaux::all(); // Retrieve all products
        $operationTypes = OperationType::all();
        return view('admin.magasin.create')
        ->with('materiaux', $materiaux)
        ->with('operationTypes', $operationTypes);
    }
    
    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'materiel_id' => 'required|exists:materiaux,id',
            'type_operation' => 'required',
            'designation' => 'required',
            'partenaire' => 'required',
            'date_operation' => 'required|date',
            'quantite' => 'required|integer|min:1',
        ]);

        // New Product
        $produit = new Produits();
        $produit->materiel_id = $request->input('materiel_id'); 
        $produit->type_operation = $request->input('type_operation');
        $produit->designation = $request->input('designation');
        $produit->partenaire = $request->input('partenaire');
        $produit->date_operation = $request->input('date_operation');
        $produit->quantite = $request->input('quantite');
        $produit->save();

        // Quantity Update
        $materiel = Materiaux::find($request->input('materiel_id'));
        if ($materiel) {
            $materiel->quantite -= $produit->quantite;
            $materiel->save();
        }

        if ($request->input('type_operation') === 'entree') {
            InputOperation::create([
                'materiel_id' => $request->input('materiel_id'),
                'quantite' => $produit->quantite
            ]);
        }
        
        Session::flash('statuscode', 'success');
        return redirect('/magasin')->with('status', 'OPERATION EFFECTUE AVEC SUCCES');
    }
    public function indexx()
    {
        $magasin = Produits::with(['materiel', 'type'])->get();
        return view('admin.magasin.printPreview')->with('magasin',$magasin);      
    }

    public function printPreview()
    {
        $magasin = Produits::all();
        return view('printPreview',compact('magasin'));
    }

    public function edit($id_operation)
    {
        $magasin = Produits::findOrfail($id_operation);
        return view('admin.magasin.edit')->with('magasin',$magasin);
    }

    public function update(Request $request, $id_operation)
    {
        $magasin = Produits::findOrfail($id_operation);
        $magasin->materiel_id = $request->input('materiel_id');
        $magasin->type_operation = $request->input('type_operation');
        $magasin->designation = $request->input('designation');
        $magasin->partenaire = $request->input('partenaire');
        $magasin->date_operation = $request->input('date_operation');
        $magasin->quantite = $request->input('quantite');
        $magasin->update();

        session::flash('statuscode','success');
        return redirect('magasin')->with('status','operation modifie');
    }

    public function delete($id_operation)
    {
        $magasin = Produits::findOrfail($id_operation);
        $magasin->delete();
        return redirect('magasin')->with('status','operation a ete supprime');
    }
}
