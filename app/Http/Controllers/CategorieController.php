<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
//use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::latest()->paginate(10);



       return view('list-categories')->with([
           'categories' => $categories
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
            'titrecat' => 'required|min:3|max:100',
            'description' => 'nullable|required|min:10|max:1000',

        ]);
        if ($validator->fails()) {
            return redirect()->route('categorie.liste')->withErrors($validator)
            ->withInput()->with([
                'fail' => 'pp'
            ]);
        }
        else{
        if($request->has('image')){
            $file = $request->image;
            $image_nom = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/categories'), $image_nom);
        }
        Categorie::create([
            'titre_cat' => $request->titrecat,
            'slug_cat' => Str::slug($request->titrecat),
            'Description' => $request->description,
            'image' => $image_nom

        ]);
        return redirect()->route('categorie.liste')->with([
            'successAjo' => 'La Catégorie '.$request->titrecat.' a été Ajoutée avec succès'
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
       $categorie = Categorie::find($id);

       $livreparcat = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom',
       'auteurs.id as idauteur', 'auteurs.slug as slugauteur')
       ->join('categories', 'livres.categorie_id', '=', 'categories.id')
       ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
       ->where('livres.categorie_id', $id)
       ->get();

       return view('categorie')->with([
           'livreparcat' => $livreparcat,
           'categorie' => $categorie
       ]);


            /*
            // test la requete
                return response()->json($livreparcat);
            */

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
        $categorie  = Categorie::where('id', $id)->first();

        return response()->json($categorie);




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
        $categorie = Categorie::find($id);
        $validator = Validator::make($request->all(), [
            'titrecat' => 'required|min:3|max:100',
            'description' => 'required|min:10|max:1000',

        ]);


        if ($validator->fails()) {
            return redirect()->route('categorie.liste')->withErrors($validator)
            ->withInput()->with([
                'failmod' => 'pp',
                'idcat' => $categorie->id
            ]);
        }
        else{
            if($request->has('image')){
                File::delete(public_path('images/categories'.'/'.$categorie->image));
                $file = $request->image;
                $image_nom = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/categories'), $image_nom);
            }


            else{
                $image_nom = $categorie->image;
            }
            $categorie->update([
                'titre_cat' => $request->titrecat,
                'slug_cat' => Str::slug($request->titrecat),
                'Description' => $request->description,
                'image' => $image_nom
            ]);
            return redirect()->route('categorie.liste')->with([
                'successMod' => 'La Catégorie a été Modifiée avec succès'
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
        $categorie = Categorie::where('id', $id)->first();
        $categorie->delete();
        return redirect()->route('categorie.liste')->with([
            'successDel' => 'La Catégorie '.$categorie->titre_cat.' a été supprimée avec succès'
        ]);
    }
public function search(Request $request){
    $search = $request->search;
    $categories = Categorie::where('titre_cat','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
    return view('list-categories')->with([
        'categories' => $categories
    ]);

}
public function searchHome(Request $request){
    $id = $request->id;
    $categorie = Categorie::find($id);

    $livreparcat = DB::table('livres')->select('livres.id', 'livres.titre','livres.slug','livres.prix','livres.image', 'auteurs.nom')
    ->join('categories', 'livres.categorie_id', '=', 'categories.id')
    ->join('auteurs', 'livres.auteur_id', '=', 'auteurs.id')
    ->where('livres.categorie_id', $id)->where('livres.titre','like','%'.$request->search.'%')
    ->get();

    return view('categorie')->with([
        'livreparcat' => $livreparcat,
        'categorie' => $categorie
    ]);
}


}
