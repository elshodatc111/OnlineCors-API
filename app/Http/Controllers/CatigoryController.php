<?php

namespace App\Http\Controllers;

use App\Models\Catigory;
use App\Models\Rool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CatigoryController extends Controller{
    public function index(){
        try{
            return response()->json(Catigory::all());
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
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
            $validateUser = Validator::make($request->all(),[
                'catigory' => 'required|string',
                'number' => 'required|integer'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateUser->errors()
                ],401);
            }
            $Catigory = Catigory::create([
                'catigory' => $request->catigory,
                'number' => $request->number
            ]);
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi categoriya qo'shildi.",
                'catigory_id' => $Catigory->id
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    public function show($id){
        try{
            return response()->json(Catigory::find($id));
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    public function update(Request $request,$id){
        try{
            $Rool = Rool::where('type_id',Auth::user()->id)->first()->rool;
            if($Rool!='admin'){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Sizning login uchun ruxsatlar mavjud emas",
                    'rool'=>$Rool
                ],401);
            }
            $validated = $request->validate([
                'catigory' => 'required|string',
                'number' => 'required|integer'
            ]);
            $Catigory = Catigory::find($id);
            if(!$Catigory){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Catigoriya topilmadi"
                ],401);
            }
            $Catigory->catigory = $request->catigory;
            $Catigory->number = $request->number;
            $Catigory->save();
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi categoriya yangilandi.",
                'catigory_id' => $id
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    public function destroy($id){
        try{
        $Rool = Rool::where('type_id',Auth::user()->id)->first()->rool;
            if($Rool!='admin'){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Sizning login uchun ruxsatlar mavjud emas",
                    'rool'=>$Rool
                ],401);
            }
            $Catigory = Catigory::find($id);
            if(!$Catigory){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Catigoriya topilmadi"
                ],401);
            }
            $Catigory->delete();
            return response()->json([
                'status'=>true,
                'messege'=>"Katigoriya o'chirildi."
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
}
