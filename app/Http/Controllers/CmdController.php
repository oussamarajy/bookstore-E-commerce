<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeDetail;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Cart::content()->count()>= 1){
        return view('finalisation-cmd');
        }
        else{
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cmd = Commande::create([
            'client_id' => Auth::user()->id,
            'ship_nom' => $request->shipnom,
            'ship_prenom' => $request->shipprenom,
            'shipadresse' => $request->adresse .'/info sup : '.$request->infosup,
            'ship_ville' => $request->ville,
            'ship_region' => $request->region,
            'ship_code_postal' => $request->zip,
            'ship_phone' => $request->phone
        ]);

        foreach(Cart::content() as $array){
            CommandeDetail::create([
                'commande_id' => $cmd->id,
                'livre_id' => $array->id,
                'quantity' => $array->qty,
                'prix_unitaire' => $array->price
            ]);
        }
        Cart::destroy();

        return redirect()->route('cmd.success')->with([
            'nbcmd' => $cmd->id
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
        $cmd =  Commande::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'shipnom' => 'required',
            'shipprenom' => 'required',
            'adresse' => 'required',
            'ville' => 'required',
            'region' => 'required',
            'phone' => 'required|numeric'

        ]);
        if ($validator->fails()) {
            return redirect()->route('commande.show', $cmd->id)->withErrors($validator)
            ->withInput()->with([
                'fail' => 'pp'
            ]);
        }
        else{
        $cmd->update([
            'ship_nom' => $request->shipnom,
            'ship_prenom' => $request->shipprenom,
            'shipadresse' => $request->adresse,
            'ship_ville' => $request->ville,
            'ship_region' => $request->region,
            'ship_code_postal' => $request->zip,
            'ship_phone' => $request->phone
        ]);

        return redirect()->route('commande.show', $cmd->id)->with([
            'successmodify' => 'les informations ont été modifié avec succée'
        ]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        DB::table('commandes')->where('id', $id)->delete();
        $verify = $request->page;
        if($verify=="pageconf"){
        return redirect()->route('listconf')->with([
            'successdele' => 'La commande Supprimé avec succée'
        ]);
    }
    else{
        return redirect()->route('listannuler')->with([
            'successdele' => 'La commande Supprimé avec succée'
        ]);
    }
    }

    public function annuler($id){
        $cmd =  Commande::findOrFail($id);
        DB::table('commandes')->where('id', $id)->update([
            'statue' => 'annuler',

        ]);

        return redirect()->route('listc', $cmd->id)->with([
            'successAnnuler' => 'La commande '.$cmd->id.' a été annulée'
        ]);
    }

    public function confirmer(Request $request, $id){
        $cmd =  Commande::findOrFail($id);
        DB::table('commandes')->where('id', $id)->update([
            'statue' => 'confirmer',
            'livreur_id' => $request->choixliv

        ]);

        return redirect()->route('listc', $cmd->id)->with([
            'successAnnuler' => 'La commande '.$cmd->id.' a été confirmée'
        ]);


/*
        return redirect()->route('listc', $cmd->id)->with([
            'successConfirmer' => 'La commande '.$cmd->id.' a été confirmée'
        ]);
        */
        return response()->json($cmd);


    }
public function livree($id){
        $cmd =  Commande::findOrFail($id);
        DB::table('commandes')->where('id', $id)->update([
            'statue' => 'livrer',

        ]);


        return redirect()->route('listconf')->with([
            'successlivree' => 'vous avez confirmé que La commande '.$cmd->id.' a été livrée'
        ]);

    }

}
