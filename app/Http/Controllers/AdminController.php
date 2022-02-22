<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Livre;
use App\Models\Message;
use App\Models\User;
use DateTime;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livres = Livre::all();
        $users = User::all();
        $commandes = Commande::all();
        return view('admin')->with([
           'livres' => $livres,
           'users' => $users,
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

    public function editprofile(){
        return view('edit-profile-admin');
    }


    public function get_users(){
        $users = User::orderBy('isAdmin', 'desc')->latest()->paginate(8);
        return view('list-users')->with([
            'users' => $users
        ]);
    }

    public function show_user($id){
        $user = User::find($id);
        return "user";

    }

    public function search_users(Request $request){
        $search = $request->search;
        $users = User::where('nom','like','%'.$search.'%')->orwhere('id','like','%'.$search.'%')->orderBy('id')->paginate(6);
        return view('list-users')->with([
            'users' => $users
        ]);
    }

    public function make_admin($id){
        $user = User::findOrFail($id);
        $user->update([
            'isAdmin' => true
        ]);
        return redirect()->route('usersAdmin.list')->with([
            'successMake' => 'permission admin ajouté à '.$user->nom
        ]);
    }

    public function remove_admin($id){
        $user = User::findOrFail($id);
        $user->update([
            'isAdmin' => false
        ]);
        return redirect()->route('usersAdmin.list')->with([
            'successdelAdmin' => 'permission admin supprimé de '.$user->nom
        ]);
    }

    public function remove_user($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usersAdmin.list')->with([
            'successdelUser' => 'user '.$user->nom.' supprimé.'
        ]);
    }

    public function reponse_admin_to_user(Request $request){
        $validation = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if($validation->fails()){
            return redirect()->route('listm')->withErrors($validation)
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



            return redirect()->route('listm')->with([
                'success' => 'votre message a été envoyé avec succès à client '.$request->idclient.', Merci'
            ]);

        }

    }

    public function updateprofile_admin(Request $request, $id){
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
            return redirect()->route('admin.profile')->withErrors($validation)
            ->withInput();
        }

        else{
            if($request->has('image')){
                File::delete(public_path('images/users'.'/'.$user->image));
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

           return redirect()->route('admin.profile')->with([
               'success' => 'votre profile a été modifié avec succée'
           ]);
        }
    }
}
