<?php

namespace App\Http\Controllers;

use App\Models\Livreur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivreurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livreurs = Livreur::all();
        return view('list-livreurs')->with([
            'livreurs' => $livreurs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'nomS' => 'required',
            'phone' => 'required|numeric'
        ]);

        if($validation->fails()){
            return redirect()->route('livreurs.list')->with([
                'fail' => 'pp'
            ]);
        }

        else{

            Livreur::create([
                'nom_societe' => $request->nomS,
                'phone' => $request->phone
            ]);

            return redirect()->route('livreurs.list')->with([
                'success' => 'Livreur Ajouté.'
            ]);


        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $livreur = Livreur::findOrFail($id);
        $livreur->delete();
        return redirect()->route('livreurs.list')->with([
            'successdel' => 'Livreur Supprimé.'
        ]);
    }

    public function search(Request $request){
        $search = $request->search;
        $livreurs = Livreur::where('nom_societe','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
        return view('list-livreurs')->with([
            'livreurs' => $livreurs
        ]);
    }
}
