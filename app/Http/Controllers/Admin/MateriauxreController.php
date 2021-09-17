<?php

namespace App\Http\Controllers\Admin;

use App\Models\Materiaux;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class MateriauxreController extends Controller
{
    public function index()
    {
        $materiaux = Materiaux::all();
        return view('admin.materiaux')
            ->with('materiaux',$materiaux);
    }

    public function store(Request $request)
    {
        $materiaux = new Materiaux;
        $materiaux->No_code = $request->input('No_code');
        $materiaux->designation = $request->input('designation');
        $materiaux->unite_emploie = $request->input('unite_emploie');
        $materiaux->rangement = $request->input('rangement');
        $materiaux->quantite = $request->input('quantite');

        $materiaux->save();
        Session::flash('statuscode','success');
        return redirect('/materiaux')->with('status','Materiel a ete enregistre');
    }

    public function edit($id)
    {
    	$materiaux = Materiaux::findOrFail($id);
    	return view('admin.materiaux.edit')
    	->with('materiaux',$materiaux);
    }

    public function update(Request $request, $id)
    {
    	$materiaux = Materiaux::findOrFail($id);
    	$materiaux->No_code = $request->input('No_code');
    	$materiaux->designation = $request->input('designation');
    	$materiaux->unite_emploie = $request->input('unite_emploie');
        $materiaux->rangement = $request->input('rangement');
        $materiaux->quantite = $request->input('quantite');
    	$materiaux->update();

    	Session::flash('statuscode','info');
    	return redirect('materiaux')->with('status','Materiel a ete mise a jour');
    }

    public function delete($id)
    {
    	$materiaux = Materiaux::findOrFail($id);
    	$materiaux->delete();

        Session::flash('statuscode','error');
    	return redirect('materiaux')->with('status','Materiel a ete supprime');
    }

    public function indexx()
    {
        $materiaux = Materiaux::all();
        return view('admin.materiaux.printPreview')->with('materiaux',$materiaux);      
    }

    public function printPreview()
    {
        $materiaux = Materiaux::all();
        return view('printPreview',compact('materiaux'));
    }
}
