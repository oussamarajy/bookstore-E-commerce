<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.from_id')
        ->where('messages.to_id', Auth::user()->id)
        ->orderByDesc('statue')
        ->paginate(10);

        return view('list-messages')->with([
            'messages' => $messages
        ]);

    }

    public function msg_env(){
        $messages = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.to_id')
        ->where('messages.from_id', Auth::user()->id)
        ->get();

        return view('list-messages-env')->with([
            'messages' => $messages
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
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'titre' => 'required',
            'message' => 'required'
        ]);

        if($validation->fails()){
            return redirect()->route('contact')->withErrors($validation)
            ->withInput();
        }

        else{
            $admin = User::all()->where('isAdmin', 1)->first();
            Message::create([
                'from_id' => Auth::user()->id,
                'to_id' => $admin->id,
                'email' => $request->email,
                'titre' => $request->titre,
                'contenu' => $request->message


            ]);

            return redirect()->route('contact')->with([
                'success' => 'votre message a été envoyé avec succès, Merci'
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


        $message = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.from_id')
        ->where('messages.id', $id)
        ->get();

        /*
        $messagytest = Message::find($id);

        $reponse = DB::table('messages')->select('contenu')
        ->where('to_id', $messagytest->from_id)->get();
        */
        return response()->json($message);
    }
    public function showenv($id)
    {
        $message = DB::table('messages')->select('messages.*', 'users.nom')
        ->join('users', 'users.id', '=', 'messages.to_id')
        ->where('messages.id', $id)
        ->get();

        return response()->json($message);
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
        $message = Message::findOrFail($id);
        $message->delete();
        return redirect()->route('listm');
    }


    public function view_msg_update($id, Request $request){
        $message = DB::table('messages')->where('id', $id)->get();

        $message->update([
            'statue' => $request->statue
        ]);


        return response()->json($message);
    }
}
