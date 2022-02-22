<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use App\Models\Categorie;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // Ne pas acceder avant auth
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $livres = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom', 'auteurs.id as idauteur' , 'auteurs.slug as slugauteur')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->paginate(8);

       $promotions = DB::table('promotions')
       ->select('livres.id', 'livres.titre','livres.slug', 'livres.image', 'promotions.reduction', 'promotions.citation')
       ->join('livres', 'promotions.id_livre', '=','livres.id')
       ->where('promotions.affichage', '=', 1)
       ->get();

        $categories = Categorie::all()->take(4);
        return view('Home')->with([
            'livres' => $livres,
            'categories' => $categories,
            'promotions' => $promotions
        ]);
    }

    public function showlivres(){
        //$livres = Livre::latest()->paginate(8);

        $livres = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom', 'auteurs.id as idauteur' , 'auteurs.slug as slugauteur')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->paginate(8);

        return view('livres')->with([
            'livres' => $livres
        ]);

    }

    public function showcategories(){
        $categories = Categorie::latest()->paginate(8);
        return view('categories')->with([
           'categories' => $categories
        ]);
    }

    public function showauteurs(){
        $auteurs = Auteur::latest()->paginate(8);
        return view('auteurs')->with([
           'auteurs' => $auteurs
        ]);
    }


    public function searchlivres(Request $request){

       $livres = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom', 'auteurs.id as idauteur' , 'auteurs.slug as slugauteur')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->where('livres.titre','like','%'.$request->search.'%')
       ->paginate(8);

        return view('livres')->with([
            'livres' => $livres
        ]);

    }
    public function searchcategories(Request $request){
        $search = $request->search;
        $categories = Categorie::where('titre_cat','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
        return view('categories')->with([
            'categories' => $categories
        ]);
    }

    public function searchauteurs(Request $request){
        $search = $request->search;
    $auteurs = Auteur::where('nom','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
    return view('auteurs')->with([
        'auteurs' => $auteurs
    ]);
    }
}
