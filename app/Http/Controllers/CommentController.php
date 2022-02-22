<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'idLivre' => 'required',

            'message' => 'required|min:4|max:150'
        ]);
        if($validate->fails()){
            return response()->json($request);
        }
        else{

            $x = 0;
            if(isset($request->rating1)){
                $x = 1;
            }
            else if(isset($request->rating2)){
                $x = 2;
            }
            else if(isset($request->rating3)){
                $x = 3;
            }
            else if(isset($request->rating4)){
                $x = 4;
            }
            else if(isset($request->rating5)){
                $x = 5;
            }


        Comment::create([
            'livre_id' => $request->idLivre,
            'user_id' => Auth::user()->id,
            'content' => $request->message,
            'rating' => $x

        ]);


        return redirect()->back()->with([
            'success' => 'Comment ajouté avec success'
        ]);


    }
    }


}
