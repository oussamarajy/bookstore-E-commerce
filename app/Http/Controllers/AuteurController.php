<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

//use Validator;

class AuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auteurs = Auteur::latest()->paginate(10);



       return view('list-auteurs')->with([
           'auteurs' => $auteurs
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


        $validator = Validator::make($request->all(), [
            'nomauteur' => 'required|min:3|max:100',
            'bio' => 'required|min:10|max:1000',
            'imagefile' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('auteur.liste')->withErrors($validator)
            ->withInput()->with([
                'fail' => 'pp'
            ]);
        }
        else{
        if($request->has('imagefile')){
            $file = $request->imagefile;
            $image_nom = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/auteurs'), $image_nom);
        }
        Auteur::create([
            'nom' => $request->nomauteur,
            'slug' => Str::slug($request->nomauteur),
            'bio' => $request->bio,
            'image' => $image_nom

        ]);
        return redirect()->route('auteur.liste')->with([
            'successAjo' => 'Auteur '.$request->nomauteur.' a été Ajoutée avec succès'
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
        $auteur = Auteur::find($id);

       $livreparaut = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom',
       'auteurs.id as idauteur', 'auteurs.slug as slugauteur')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->where('livres.auteur_id', $id)
       ->get();

       return view('auteur')->with([
           'livreparaut' => $livreparaut,
           'auteur' => $auteur,

       ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $auteur  = Auteur::where($where)->first();

        return response()->json($auteur);




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
        $auteur = Auteur::find($id);
        $validator = Validator::make($request->all(), [
            'nomauteur' => 'required|min:3|max:100',
            'bio' => 'required|min:10|max:1000',

        ]);


        if ($validator->fails()) {
            return redirect()->route('auteur.liste')->withErrors($validator)
            ->withInput()->with([
                'failmod' => 'pp',
                'idaut' => $auteur->id
            ]);
        }
        else{
            if($request->has('imagefile')){
                File::delete(public_path('images/auteurs'.'/'.$auteur->image));
                $file = $request->imagefile;
                $image_nom = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/auteurs'), $image_nom);
            }


            else{
                $image_nom = $auteur->image;
            }
            $auteur->update([
                'nom' => $request->nomauteur,
                'slug' => Str::slug($request->nomauteur),
                'bio' => $request->bio,
                'image' => $image_nom
            ]);
            return redirect()->route('auteur.liste')->with([
                'successMod' => 'Auteur a été Modifiée avec succès'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auteur = Auteur::where('id', $id)->first();
        $auteur->delete();
        return redirect()->route('auteur.liste')->with([
            'successDel' => 'Auteur '.$auteur->nom.' a été supprimé avec succès'
        ]);
    }
public function search(Request $request){
    $search = $request->search;
    $auteurs = Auteur::where('nom','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
    return view('list-auteurs')->with([
        'auteurs' => $auteurs
    ]);

}
public function searchHome(Request $request){
    $id = $request->id;
    $auteur = Auteur::find($id);

       $livreparaut = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->where('livres.auteur_id', $id)->where('livres.titre','like','%'.$request->search.'%')
       ->get();

       return view('auteur')->with([
           'livreparaut' => $livreparaut,
           'auteur' => $auteur,

       ]);

}



}
