<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partenaires;
use Session; 

class PartenaireController extends Controller
{
    public function index()
    {
    	$partenaire = Partenaires::all();
    	return view('admin.partenaires.index')
    	->with('partenaire',$partenaire);
    }

    public function create()
    {
    	return view('admin.partenaires.create');
    }

    public function store(Request $request)
    {
    	$partenaire = new Partenaires();
    	$partenaire->id_partenaire = $request->input('id_partenaire');
    	$partenaire->type_partenaire = $request->input('type_partenaire');
    	$partenaire->nom_partenaire = $request->input('nom_partenaire');
    	$partenaire->departement = $request->input('departement');
    	$partenaire->operation = $request->input('operation');
    	$partenaire->date_operation = $request->input('date_operation');
    	$partenaire->save();
        
        Session::flash('statuscode','succes');
    	return redirect('/partenaire')->with('status','Partenaire ajoute');
    }
}
