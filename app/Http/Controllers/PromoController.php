<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livres = Livre::all();
        $promotions = DB::table('promotions')
        ->select('promotions.id', 'livres.titre', 'promotions.reduction', 'promotions.created_at')
        ->join('livres', 'promotions.id_livre', '=', 'livres.id')
        ->get();
        return view('parameter')->with([
            'livres' => $livres,
            'promotions' => $promotions
        ]);



    }

    public function listpromo(){
        $livres = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom', 'auteurs.id as idauteur' , 'auteurs.slug as slugauteur', 'promotions.reduction')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->join('promotions', 'livres.id', '=', 'promotions.id_livre')
       ->paginate(8);

       return view('list-promo')->with([
           'livres' => $livres
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
        $promotions = DB::table('promotions')
        ->select('promotions.id', 'livres.titre', 'promotions.reduction', 'promotions.created_at')
        ->join('livres', 'promotions.id_livre', '=', 'livres.id')
        ->get();
        $livres = Livre::all();

        $validate = Validator::make($request->all(), [
            'taux' => 'required|numeric',
            'citation' => 'required|min:10|max:500'

        ]);

        if ($validate->fails()) {
            return redirect()->route('parameter')->withErrors($validate)
            ->withInput()->with([
                'fail' => 'cc'
            ]);
        }

        if($request->affichage == 1){
            $val = 1;
        }
        else{
            $val = 0;
        }
        Promotion::create([
            'id_livre' => $request->choixLivre,
            'reduction' => $request->taux,
            'citation' => $request->citation,
            'affichage' => $val
        ]);

        return redirect()->route('parameter')->with([
            'success' => "La promotion a été ajouté avec succès",
            'livres' => $livres,
            'promotions' => $promotions
        ]);

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
        $promotion  = Promotion::where('id', $id)->first();

        return response()->json($promotion);
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
        $promotion = Promotion::find($id);
        $promotions = DB::table('promotions')
        ->select('promotions.id', 'livres.titre', 'promotions.reduction', 'promotions.created_at')
        ->join('livres', 'promotions.id_livre', '=', 'livres.id')
        ->get();
        $livres = Livre::all();

        $validate = Validator::make($request->all(), [
            'tauxMod' => 'required|numeric',
            'citationMod' => 'required|min:10|max:500'

        ]);

        if ($validate->fails()) {
            return redirect()->route('parameter')->withErrors($validate)
            ->withInput()->with([
                'failmod' => 'pp',
                'idpromo' => $promotion->id
            ]);
        }

        if($request->affichageMod == 1){
            $val = 1;
        }
        else{
            $val = 0;
        }
        $promotion->update([

            'reduction' => $request->tauxMod,
            'citation' => $request->citationMod,
            'affichage' => $val
        ]);

        return redirect()->route('parameter')->with([
            'successMod' => "La promotion a été modifié avec succès",
            'livres' => $livres,
            'promotions' => $promotions
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return redirect()->route('parameter')->with([
            'successDel' => 'La promotion a été supprimé avec succès'
        ]);
    }
}
