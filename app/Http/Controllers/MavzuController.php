<?php

namespace App\Http\Controllers;

use App\Models\Mavzu;
use App\Models\Cours;
use App\Models\User;
use App\Models\Rool;
use App\Models\Photo;
use App\Models\Catigory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MavzuController extends Controller{
    public function index(){
        //
    }

    public function store(Request $request){
        try{
            $Rool = Rool::where('type_id',Auth::user()->id)->first()->rool;
            if($Rool!='admin'){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Sizning login uchun ruxsatlar mavjud emas",
                    'rool'=>$Rool
                ],401);
            }
            $validateCours = Validator::make($request->all(),[
                'cours_id' => 'required|integer',
                'mavzu_name' => 'required',
                'discription' => 'required',
                'lenth' => 'required',
                'number' => 'required|integer',
                'video' => 'required'
            ]);
            if($validateCours->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateCours->errors()
                ],401);
            }
            $Cours = Cours::find($request->cours_id);
            if(!$Cours){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Cours topilmadi"
                ],401);
            }
            $Mavzu = Mavzu::create([
                'cours_id' => $request->cours_id,
                'mavzu_name' => $request->mavzu_name,
                'discription' => $request->discription,
                'lenth' => $request->lenth,
                'number' => $request->number,
                'video' => $request->video
            ]);
            
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi Mavzu yaratildi",
                'cours_id'=>$Mavzu->id
            ],200);

        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }

    public function show($id){
        //
    }

    public function update(Request $request, $id){
        try{
            $Rool = Rool::where('type_id',Auth::user()->id)->first()->rool;
            if($Rool!='admin'){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Sizning login uchun ruxsatlar mavjud emas",
                    'rool'=>$Rool
                ],401);
            }
            $validateCours = Validator::make($request->all(),[
                'cours_id' => 'required|integer',
                'mavzu_name' => 'required',
                'discription' => 'required',
                'lenth' => 'required',
                'number' => 'required|integer',
                'video' => 'required'
            ]);
            if($validateCours->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateCours->errors()
                ],401);
            }
            $Cours = Cours::find($request->cours_id);
            if(!$Cours){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Cours topilmadi"
                ],401);
            }
            $Mavzu = Mavzu::find($id);
            if(!$Mavzu){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Mavzu topilmadi"
                ],401);
            }
            $Mavzu->cours_id = $request->cours_id;
            $Mavzu->mavzu_name = $request->mavzu_name;
            $Mavzu->discription = $request->discription;
            $Mavzu->lenth = $request->lenth;
            $Mavzu->number = $request->number;
            $Mavzu->video = $request->video;
            $Mavzu->save();
            return response()->json([
                'status'=>true,
                'messege'=>"Mavzu yangilandi",
                'cours_id'=>$Mavzu->id
            ],200);

        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }

    public function destroy(Mavzu $mavzu)
    {
        //
    }
}
