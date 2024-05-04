<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\User;
use App\Models\Rool;
use App\Models\Photo;
use App\Models\Mavzu;
use App\Models\Catigory;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CoursController extends Controller{
    public function index(){
        try{
            $Cours = Cours::join('users','users.id','=','cours.techer_id')
                ->join('photos','cours.techer_id','=','photos.type_id')
                ->join('catigories','catigories.id','=','cours.catigorie_id')
                ->select(
                    'cours.id',
                    'cours.cours_name',
                    'cours.title',
                    'cours.discription',
                    'cours.price',
                    'cours.price_crm',
                    'cours.length',
                    'cours.days',
                    'cours.image',
                    'cours.video',
                    'catigories.catigory',
                    'users.first_name as techer_name',
                    'users.last_name as techer_family',
                    'photos.image as techer_image')
                ->get();
                $Catigory = Catigory::get();
            return response()->json([
                'status'=>true,
                'cours'=>$Cours,
                'catigory'=>$Catigory,
                'messege'=>'Barcha kurslar'
            ], 200);
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
            $validateCours = Validator::make($request->all(),[
                'techer_id' => 'required',
                'catigorie_id' => 'required',
                'cours_name' => 'required',
                'title' => 'required',
                'discription' => 'required',
                'price' => 'required|integer',
                'price_crm' => 'required|integer',
                'length' => 'required',
                'days' => 'required|integer',
                'image' => 'required',
                'video' => 'required'
            ]);
            if($validateCours->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateCours->errors()
                ],401);
            }
            $Techers = count(Rool::where('type_id',$request->techer_id)->where('rool','techer')->get());
            if($Techers==0){
                return response()->json([
                    'status'=>false,
                    'messege'=>"O'qituvchi topilmadi"
                ],401);
            }
            $Catigory = Catigory::find($request->catigorie_id);
            if(!$Catigory){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Catigore topilmadi"
                ],401);
            }
            $Cours = Cours::create([
                'techer_id' => $request->techer_id,
                'catigorie_id' => $request->catigorie_id,
                'cours_name' => $request->cours_name,
                'title' => $request->title,
                'discription' => $request->discription,
                'price' => $request->price,
                'price_crm' => $request->price_crm,
                'length' => $request->length,
                'days' => $request->days,
                'image' => $request->image,
                'video' => $request->video,
            ]);
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi Kurs yaratildi",
                'cours_id'=>$Cours->id
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
            $Cours = Cours::join('users','users.id','=','cours.techer_id')->where('cours.id',$id)
                ->join('photos','cours.techer_id','=','photos.type_id')
                ->join('catigories','catigories.id','=','cours.catigorie_id')
                ->select(
                    'cours.id',
                    'cours.cours_name',
                    'cours.title',
                    'cours.discription',
                    'cours.price',
                    'cours.price_crm',
                    'cours.length',
                    'cours.days',
                    'cours.image',
                    'cours.video',
                    'catigories.catigory',
                    'users.first_name as techer_name',
                    'users.last_name as techer_family',
                    'photos.image as techer_image')
                ->first();
            $Mavzu = Mavzu::where('cours_id',$id)->get();
            $Comment = Comment::where('comments.cours_id',$id)
                ->join('users','comments.user_id','=','users.id')
                ->join('photos','comments.user_id','=','photos.type_id')
                ->select('comments.comment','comments.created_at','users.first_name','users.last_name','photos.image')
                ->get();
            return response()->json([
                'status'=>true,
                'cours'=>$Cours,
                'mavzu'=>$Mavzu,
                'comment'=>$Comment,
                'messege'=>'Cours Haqida'
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
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
            $validateCours = Validator::make($request->all(),[
                'techer_id' => 'required',
                'catigorie_id' => 'required',
                'cours_name' => 'required',
                'title' => 'required',
                'discription' => 'required',
                'price' => 'required|integer',
                'price_crm' => 'required|integer',
                'length' => 'required',
                'days' => 'required|integer',
                'image' => 'required',
                'video' => 'required'
            ]);
            if($validateCours->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateCours->errors()
                ],401);
            }
            
            $Techers = count(Rool::where('type_id',$request->techer_id)->where('rool','techer')->get());
            if($Techers==0){
                return response()->json([
                    'status'=>false,
                    'messege'=>"O'qituvchi topilmadi"
                ],401);
            }
            $Catigory = Catigory::find($request->catigorie_id);
            if(!$Catigory){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Catigore topilmadi"
                ],401);
            }
            $Cours = Cours::find($id);
            if(!$Cours){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Cours topilmadi"
                ],401);
            }
            $Cours->techer_id = $request->techer_id;
            $Cours->catigorie_id = $request->catigorie_id;
            $Cours->cours_name = $request->cours_name;
            $Cours->title = $request->title;
            $Cours->discription = $request->discription;
            $Cours->price = $request->price;
            $Cours->price_crm = $request->price_crm;
            $Cours->length = $request->length;
            $Cours->days = $request->days;
            $Cours->image = $request->image;
            $Cours->video = $request->video;
            $Cours->save();
            return response()->json([
                'status'=>true,
                'messege'=>"Kurs taxrirlandi",
                'cours_id'=>$id
            ],200);
            
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }

    public function destroy(Cours $cours){
        try{
            $Rool = Rool::where('type_id',Auth::user()->id)->first()->rool;
            if($Rool!='admin'){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Sizning login uchun ruxsatlar mavjud emas",
                    'rool'=>$Rool
                ],401);
            }
            
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
}
