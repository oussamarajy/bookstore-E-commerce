<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use App\Models\Categorie;
use App\Models\Comment;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livres = Livre::latest()->paginate(5);
        return view('list-produits')->with([
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
        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'auteur' => 'required|numeric',
            'categorie' => 'required|numeric',
            'quantity' => 'required|numeric',
            'isbn' => 'required|numeric',
            'prix' => 'required|numeric',
            'nbpages' => 'nullable|numeric',
            'date' => 'nullable|date',
            'imagefile' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('livre.liste')->withErrors($validator)
            ->withInput()->with([
                'fail' => 'pp'
            ]);
        }
        else{
        if($request->has('imagefile')){
            $file = $request->imagefile;
            $image_name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/livres'), $image_name);
        }

        Livre::create([
            'titre' => $request->titre,
            'slug' => Str::slug($request->titre),
            'description' => $request->description,
            'auteur_id' => $request->auteur,
            'categorie_id' => $request->categorie,
            'quantity' => $request->quantity,
            'isbn' => $request->isbn,
            'prix' => $request->prix,
            'nb_pages' => $request->nbpages,
            'date_pub' => $request->date,
            'image' => $image_name
        ]);

        return redirect()->route('livre.liste')->with([
            'successAjou' => 'Livre ajouté avec succes'
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
        //Livre::find($id);
         Livre::find($id)->increment('views');

        $livre = DB::table('livres')
        ->select('livres.*', 'categories.titre_cat', 'auteurs.nom', 'auteurs.id as idauteurliv')
        ->join('categories', 'livres.categorie_id', '=', 'categories.id')
        ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
        ->where('livres.id', $id)
        ->get();

        $livres = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom', 'auteurs.id as idauteur' , 'auteurs.slug as slugauteur')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->where('livres.id', '!=', $livre[0]->id)
       ->where('auteurs.id', $livre[0]->idauteurliv)
       ->orwhere('livres.titre', 'like', $livre[0]->titre)
       ->where('livres.titre', '!=', $livre[0]->titre)
       ->paginate(4);

       $livre_Livree = DB::table('commandes')->select('commande_details.livre_id')
       ->join('users', 'commandes.client_id', '=', 'users.id')
       ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')
       ->where('commandes.statue', 'livrer')
       ->where('users.id', optional(Auth::user())->id)
       ->where('commande_details.livre_id', $id)
       ->get();
       $comments = DB::table('comments')->select('comments.content', 'comments.rating', 'users.nom', 'users.image')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->where('comments.livre_id', $id)
        ->orderByDesc('comments.rating')
        ->get();


        //Comment::all()->where('livre_id', $id);

       return view('view-livre')->with([
           'livre' => $livre,
           'livres' => $livres,
           'livre_Livree' => $livre_Livree,
           'comments' => $comments
       ]);


      // return response()->json($comments);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$where = array('id' => $id);
        //$Livre  = Categorie::where($where)->first();
        $Livre = Livre::find($id);

        return response()->json($Livre);

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
        $livre = Livre::find($id);
        $validator = Validator::make($request->all(), [
            'titre' => 'required',

            'auteur' => 'required|numeric',
            'categorie' => 'required|numeric',
            'quantity' => 'required|numeric',
            'isbn' => 'required|numeric',
            'prix' => 'required|numeric',
            'nbpages' => 'nullable|numeric',   // il faut le supprimer ..
            'date' => 'nullable|date',

        ]);
        if ($validator->fails()) {
            return redirect()->route('livre.liste')->withErrors($validator)
            ->withInput()->with([
                'failmod' => 'pp',
                'idlivre' => $livre->id
            ]);
        }
        else{
        if($request->has('imagefile')){
            File::delete(public_path('images/livres'.'/'.$livre->image));
            $file = $request->imagefile;
            $image_nom = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/livres'), $image_nom);
        }


        else{
            $image_nom = $livre->image;
        }
        $livre->update([
            'titre' => $request->titre,
            'slug' => Str::slug($request->titre),
            'description' => $request->description,
            'auteur_id' => $request->auteur,
            'categorie_id' => $request->categorie,
            'quantity' => $request->quantity,
            'isbn' => $request->isbn,
            'prix' => $request->prix,
            'nb_pages' => $request->nbpages,
            'date_pub' => $request->date,
            'image' => $image_nom
        ]);

        return redirect()->route('livre.liste')->with([
            'successMod' => 'Livre Modifié avec succes'
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
        $livre = Livre::where('id', $id)->first();
        $livre->delete();
        return redirect()->route('livre.liste')->with([
            'successDel' => 'Livre '.$livre->titre.' a été supprimé avec succès'
        ]);
    }

    public function getdata(){
        $cat = Categorie::all()->toArray();
        $aut = Auteur::all()->toArray();

       $jj = array_merge($cat,$aut);
        return response()->json($jj);
    }

    public function search(Request $request){
        $search = $request->search;
        $livres = Livre::where('titre','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
        return view('list-produits')->with([
            'livres' => $livres
        ]);
    }
}
