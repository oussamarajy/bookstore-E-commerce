<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Livreur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CmdDetaiilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $commandes = DB::table('commandes')
        ->select('commandes.id','commandes.statue', 'commandes.deja_vu', 'users.nom', DB::raw('SUM(commande_details.quantity) as totalq'), DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')->groupBy('commandes.id', 'users.nom', 'commandes.statue', 'commandes.deja_vu')->orderByDesc('commandes.created_at')
        ->get();

        $vu = Commande::all()->where('deja_vu', 0);
       // View::share('count', $vu);
        return view('list-commandes')->with([
            'commandes' => $commandes,
            'vu' => $vu
        ]);



    }
    public function cmd_conf()
    {

        $commandes = DB::table('commandes')
        ->select('commandes.id','commandes.statue', 'commandes.deja_vu', 'users.nom', DB::raw('SUM(commande_details.quantity) as totalq'), DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')->groupBy('commandes.id', 'users.nom', 'commandes.statue', 'commandes.deja_vu')->orderByDesc('commandes.created_at')
        ->get();

        $vu = Commande::all()->where('deja_vu', 1);
       // View::share('count', $vu);
        return view('commandes-conf')->with([
            'commandes' => $commandes,
            'vu' => $vu
        ]);



    }
    public function cmd_livree()
    {

        $commandes = DB::table('commandes')
        ->select('commandes.id','commandes.statue', 'commandes.deja_vu', 'users.nom', DB::raw('SUM(commande_details.quantity) as totalq'), DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')->groupBy('commandes.id', 'users.nom', 'commandes.statue', 'commandes.deja_vu')->orderByDesc('commandes.created_at')
        ->get();

        $vu = Commande::all()->where('deja_vu', 1);
       // View::share('count', $vu);
        return view('commandes-livree')->with([
            'commandes' => $commandes,
            'vu' => $vu
        ]);



    }
    public function cmd_annuler()
    {

        $commandes = DB::table('commandes')
        ->select('commandes.id','commandes.statue', 'commandes.deja_vu', 'users.nom', DB::raw('SUM(commande_details.quantity) as totalq'), DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')->groupBy('commandes.id', 'users.nom', 'commandes.statue', 'commandes.deja_vu')->orderByDesc('commandes.created_at')
        ->get();

        $vu = Commande::all()->where('deja_vu', 1);
       // View::share('count', $vu);
        return view('commandes-annuler')->with([
            'commandes' => $commandes,
            'vu' => $vu
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $commande = DB::table('commandes')
        ->select('commandes.id','users.nom','users.email','users.ville', 'users.phone','commandes.ship_nom',
        'commandes.ship_prenom','commandes.shipadresse',
        'commandes.ship_ville','commandes.ship_region', 'commandes.ship_code_postal',
        'commandes.ship_phone','commandes.created_at', DB::raw('SUM(commande_details.quantity) as totalq'),
        DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')
        ->join('livres', 'commande_details.livre_id', '=', 'livres.id')
        ->where('commandes.id', $id)
        ->groupBy('commandes.id', 'users.nom','users.email','users.ville', 'users.phone','commandes.ship_nom',
        'commandes.ship_prenom','commandes.shipadresse',
        'commandes.ship_ville','commandes.ship_region', 'commandes.ship_code_postal',
        'commandes.ship_phone','commandes.created_at')
        ->get();
        DB::table('commandes')
              ->where('id', $id)
              ->update(['deja_vu' => true]);
        $livres = DB::table('commande_details')->select('livres.id', 'livres.image', 'livres.titre', 'commande_details.quantity', 'commande_details.prix_unitaire')
        ->join('livres', 'commande_details.livre_id', '=', 'livres.id')
        ->where('commande_id', $id)->get();

        $livreurs = Livreur::all();



        return view('commande-details')->with([
            'commande' => $commande,
            'livres' => $livres,
            'livreurs' => $livreurs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idcmd, $id)
    {
        $livre = CommandeDetail::where('livre_id', $id)->where('commande_id', $idcmd)->first();
        return response()->json($livre);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idcmd, $id)
    {
        $livre = CommandeDetail::where('livre_id', $id)->where('commande_id', $idcmd)->first();
        $livre->update([
            'quantity' => $request->quantityMod
        ]);
        return redirect()->route('commande.show', $idcmd);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idcmd, $id)
    {
        $commande = Commande::findOrFail($idcmd);
        $livre = CommandeDetail::where('livre_id', $id)->where('commande_id', $idcmd)->first();
        $livre->delete();
        $commandedetail = CommandeDetail::where('commande_id', $idcmd);
        if($commandedetail->exists()){
        return redirect()->route('commande.show', $idcmd)->with([
            'successdele' => 'Le produit a été Supprimé avec succée'
        ]);
    }
    else{
        DB::table('commandes')->where('id', $idcmd)->delete();
        return redirect()->route('listc')->with([
            "successdel" => "La commande a été Supprimé avec succée parce qu'elle n'a aucune produit"
        ]);
    }


    }
}
