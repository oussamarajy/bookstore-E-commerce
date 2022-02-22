<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = DB::table('commandes')
        ->select('commandes.id','commandes.statue', 'commandes.deja_vu', 'commandes.created_at', 'users.nom', DB::raw('SUM(commande_details.quantity) as totalq'), DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')
        ->where('commandes.client_id', Auth::user()->id)
        ->groupBy('commandes.id', 'users.nom', 'commandes.statue', 'commandes.deja_vu', 'commandes.created_at')->orderByDesc('commandes.created_at')
        ->get();




        return view('profile-user')->with([
            'commandes' => $commandes
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('usersAdmin.list')->withErrors($validator)
            ->withInput()->with([
                'fail' => 'pp'
            ]);
        }
        else{
            if($request->checkadmin){
                $val = 1;
            }
            else{
                $val = 0;
            }

       $user =  User::create([
            'nom' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'isAdmin' => $val

        ]);

        return redirect()->route('usersAdmin.list')->with([
            'success' => 'user ajouté.'
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
        //
    }

    public function commandesUser(){

    }

    public function messagesUser(){
        $messages = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.from_id')
        ->where('messages.to_id', Auth::user()->id)
        ->orderByDesc('statue')
        ->paginate(10);

        return view('messages-user')->with([
            'messages' => $messages
        ]);
    }

    public function msg_user_env(){
        $messages = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.to_id')
        ->where('messages.from_id', Auth::user()->id)
        ->get();

        return view('messages-env-user')->with([
            'messages' => $messages
        ]);
    }
    public function showMessage_user($id)
    {


        $message = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.from_id')
        ->where('messages.id', $id)->where('messages.to_id', Auth::user()->id)
        ->get();

        return response()->json($message);
    }

    public function showMessage_user_env($id)
    {
        $message = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.to_id')
        ->where('messages.id', $id)->where('messages.from_id', Auth::user()->id)
        ->get();

        return response()->json($message);
    }

    public function reponse_user_to_admin(Request $request){
        $validation = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if($validation->fails()){
            return redirect()->route('user.messages')->withErrors($validation)
            ->withInput();
        }

        else{
          DB::table('messages')->insert([
              'titre' => $request->titre,
              'email' => Auth::user()->email,
              'to_id' => $request->idclient,
              'from_id' => Auth::user()->id,
              'contenu' => $request->message,
              'created_at' => now()
          ]);

          DB::table('messages')
              ->where('id', $request->idmsg)
              ->update(['statue' => true]);



            return redirect()->route('user.messages')->with([
                'success' => 'votre message a été envoyé avec succès à client '.$request->idclient.', Merci'
            ]);

        }

    }


    public function show_commande_user($id){
        $commande = DB::table('commandes')
        ->select('commandes.id','users.nom','users.email','users.ville', 'users.phone','commandes.ship_nom',
        'commandes.ship_prenom','commandes.shipadresse',
        'commandes.ship_ville','commandes.ship_region', 'commandes.ship_code_postal',
        'commandes.ship_phone','commandes.created_at','commandes.client_id', DB::raw('SUM(commande_details.quantity) as totalq'),
        DB::raw('SUM(commande_details.quantity*commande_details.prix_unitaire) as totalr'))
        ->join('users', 'commandes.client_id', '=', 'users.id')
        ->join('commande_details', 'commandes.id', '=', 'commande_details.commande_id')
        ->join('livres', 'commande_details.livre_id', '=', 'livres.id')
        ->where('commandes.id', $id)->where('commandes.client_id', Auth::user()->id)
        ->groupBy('commandes.id', 'users.nom','users.email','users.ville', 'users.phone','commandes.ship_nom',
        'commandes.ship_prenom','commandes.shipadresse',
        'commandes.ship_ville','commandes.ship_region', 'commandes.ship_code_postal',
        'commandes.ship_phone','commandes.created_at', 'commandes.client_id')
        ->get();

        $livres = DB::table('commande_details')->select('livres.id', 'livres.image', 'livres.titre', 'commande_details.quantity',
         'commande_details.prix_unitaire', 'commandes.client_id')
        ->join('livres', 'commande_details.livre_id', '=', 'livres.id')
        ->join('commandes', 'commandes.id', '=', 'commande_details.commande_id')
        ->where('commandes.client_id', Auth::user()->id)
        ->where('commande_id', $id)->get();
         $checkuser = false;
        foreach($commande as $cmd){
        if($cmd->client_id == Auth::user()->id){
        $checkuser = true;

    }

    }

    if($checkuser){
    return view('show-commande-user')->with([
        'commande' => $commande,
        'livres' => $livres,

    ]);
}
else{
    return redirect()->back();
}

    }


    public function editprofile(){
        return view('edit-profile-user');
    }

    public function updateprofile_user(Request $request, $id){
        $user = User::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::user()->id, 'id')

            ],
            'phone' => ['required', 'numeric'],
            'password' => ['nullable','string', 'min:8', 'confirmed'],
        ]);

        if($validation->fails()){
            return redirect()->route('user.profile-edit')->withErrors($validation)
            ->withInput();
        }

        else{
            if($request->has('image')){
                FacadesFile::delete(public_path('images/users'.'/'.$user->image));
                $file = $request->image;
                $image_nom = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/users'), $image_nom);
            }


            else{
                $image_nom = $user->image;
            }
            if($request->has('password')){
                $password = Hash::make($request->pass);
            }
            else{
                $password = $user->password;
            }
            $user->update([
                'nom' => $request->nom,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $password,
                'ville' => $request->ville,
                'region' => $request->region,
                'code_postal' => $request->codepostal,
                'pays' => $request->pays,
                'image' => $image_nom
            ]);

           return redirect()->route('user.profile-edit')->with([
               'success' => 'votre profile a été modifié avec succée'
           ]);
        }
    }
}
