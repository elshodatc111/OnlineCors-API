<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Cours;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller{
    public function store(Request $request){
        try{
            $validateComment = Validator::make($request->all(),[
                'cours_id' => 'required|integer',
                'user_id' => 'required|user_id',
                'comment' => 'required|comment'
            ]);

            $Cours = Cours::find($request->cours_id);
            if(!$Cours){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Cours topilmadi"
                ],401);
            }
            $User = User::find($request->user_id);
            if(!$User){
                return response()->json([
                    'status'=>false,
                    'messege'=>"User topilmadi"
                ],401);
            }
            $Comment = Comment::create([
                'cours_id' => $request->cours_id,
                'user_id' => $request->user_id,
                'comment' => $request->comment
            ]);
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi Comment yaratildi",
                'cours_id'=>$Comment->id
            ],200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
    public function destroy($id){

        $Comment = Comment::find($id);
        if(!$Comment){
            return response()->json([
                'status'=>false,
                'messege'=>"Comment topilmadi"
            ],401);
        }

        $Comment = Comment::find($id);
        $Comment->delete();
        return response()->json([
            'status'=>true,
            'messege'=>"Comment o'chirildi",
            'cours_id'=>$id
        ],200);
    }
}
