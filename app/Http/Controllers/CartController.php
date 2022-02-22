<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Promotion;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;



class CartController extends Controller
{
    public function cart(){


        $promotions = DB::table('promotions')
       ->select('livres.id', 'livres.titre','livres.slug', 'livres.image', 'promotions.reduction', 'promotions.citation', 'promotions.affichage')
       ->join('livres', 'promotions.id_livre', '=','livres.id')
       ->where('promotions.affichage', '=', 1)
       ->get();
        $livres = Livre::all();
        return view('panier')->with([
            'livres' => $livres,
            'promotions' => $promotions
        ]);


    }

    public function all(){

                $ay = Cart::content();

                return response()->json($ay);




            }


    public function panier(Request $request){

        $livrepanier = Livre::find($request->idlivre);
        $promotions = Promotion::all();
        foreach($promotions as $promo){
            if($promo->id_livre==$request->idlivre){
                $livrepanier->prix = $livrepanier->prix - (($livrepanier->prix * $promo->reduction)/100);
            }
        }
        if(isset($request->submit)){
            Cart::add($livrepanier->id, $livrepanier->titre, $request->q, $livrepanier->prix);
        }
        else{
        Cart::add($livrepanier->id, $livrepanier->titre, 1, $livrepanier->prix);
        }

     return redirect()->back();


    //return response()->json($livrepanier);

    }


    public function remove(Request $request){
        $rowId = $request->idlivrecart;

        Cart::remove($rowId);
        return redirect()->route('panier.show');
    }


    //


    public function update(Request $request){
        $cartLi = $request->quantity;

        $c = 0;
        foreach(Cart::content() as $array){

            $rowIdx = $array->rowId;

            Cart::update($rowIdx, $cartLi[$c]);
            $c += 1;

        }

        return redirect()->route('cmd.create');
    }
}
