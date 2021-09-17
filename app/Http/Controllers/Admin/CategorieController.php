<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use Session;

class CategorieController extends Controller
{
    public function index()
    {
    	$categorie = Categories::all();
    	return view('admin.categories.index')
    	->with('categorie',$categorie);
    }

    public function create()
    {
    	return view('admin.categories.create');
    }

    public function store(Request $request)
    {
    	$categorie = new Categories();
    	$categorie->id_categorie = $request->input('id_categorie');
    	$categorie->nom_categorie = $request->input('nom_categorie');
    	$categorie->departement = $request->input('departement');
    	$categorie->rangement = $request->input('rangement');
    	$categorie->type_produit = $request->input('type_produit');
    	$categorie->quantite = $request->input('quantite');
    	$categorie->save();
        
        Session::flash('statuscode','succes');
    	return redirect('/categorie')->with('status','Categorie ajoute');
    }
}
