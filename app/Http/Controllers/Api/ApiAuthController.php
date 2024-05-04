<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rool;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller{
    // User delete
    public function userDelete($id){
        try{
            $Rool = Rool::where('type_id',Auth::user()->id)->first()->rool;
            if($Rool!='admin'){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Sizning login uchun ruxsatlar mavjud emas",
                    'rool'=>$Rool
                ],401);
            }
            $User = User::find($id);
            if(!$User){
                return response()->json([
                    'status'=>false,
                    'messege'=>"User topilmadi",
                    'rool'=>$Rool
                ],401);
            }
            $Rool = Rool::where('type_id',$id)->first();
            $Photo = Photo::where('type_id',$id)->first();
            $User->delete();
            $Rool->delete();
            $Photo->delete();
            return response()->json([
                'status'=>true,
                'messege'=>'User Delete',
            ],500);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
    // User Show
    public function user($id){
        try{
            return response()->json(
                User::join('rools','users.id','=','rools.type_id')
                ->join('photos','users.id','=','photos.type_id')
                ->where('users.id',$id)
                ->first()
            );
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
    // All Techer
    public function techer(){
        try{
            return response()->json(
                User::join('rools','users.id','=','rools.type_id')
                ->join('photos','users.id','=','photos.type_id')
                ->where('rools.rool','techer')
                ->get());
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
    // All Admin
    public function admin(){
        try{
            return response()->json(
                User::join('rools','users.id','=','rools.type_id')
                ->join('photos','users.id','=','photos.type_id')
                ->where('rools.rool','admin')
                ->get());
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
    // All Users
    public function student(){
        try{
            return response()->json(
                User::join('rools','users.id','=','rools.type_id')
                ->join('photos','users.id','=','photos.type_id')
                ->where('rools.rool','student')
                ->get());
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],500);
        }
    }
    // Register Techer
    public function registerTecher(Request $request){
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
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required|unique:users,phone',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateUser->errors()
                ],401);
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $type_id = $user->id;
            Photo::create([
                'type_id'=>$type_id,
                'image'=>'avatar.png'
            ]);
            Rool::create([
                'type_id'=>$type_id,
                'rool'=>'techer'
            ]);
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi o'qituvchi yaratildi",
                'token'=>$user->createToken('API TOKEN')->plainTextToken
            ],200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    // Register Admin
    public function registerAdmin(Request $request){
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
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required|unique:users,phone',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateUser->errors()
                ],401);
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $type_id = $user->id;
            Photo::create([
                'type_id'=>$type_id,
                'image'=>'avatar.png'
            ]);
            Rool::create([
                'type_id'=>$type_id,
                'rool'=>'admin'
            ]);
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi admin yaratildi",
                'token'=>$user->createToken('API TOKEN')->plainTextToken
            ],200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    //Register User
    public function register(Request $request){
        try{
            $validateUser = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required|unique:users,phone',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateUser->errors()
                ],401);
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $type_id = $user->id;
            Photo::create([
                'type_id'=>$type_id,
                'image'=>'avatar.png'
            ]);
            Rool::create([
                'type_id'=>$type_id,
                'rool'=>'student'
            ]);
            return response()->json([
                'status'=>true,
                'messege'=>"Yangi foydalanuvchi yaratildi",
                'token'=>$user->createToken('API TOKEN')->plainTextToken
            ],200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    //Login
    public function login(Request $request){
        try{
            $validateUser = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Malumotlar to'liq emas",
                    'errors'=>$validateUser->errors()
                ],401);
            }
            if(!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status'=>false,
                    'messege'=>"Email yoki parol xato qaytadan urinib ko'ring"
                ],401);
            }
            $user = User::where('email',$request->email)->first();
            return response()->json([
                'status'=>true,
                'messege'=>"Sizning Email va parol to'g'ri",
                'token'=>$user->createToken('API TOKEN')->plainTextToken
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    //Profile
    public function profel(Request $request){
        try{
            $userData = Auth::user();
            $date = User::where('users.id',$userData->id)
            ->join('photos','users.id','=','photos.type_id')
            ->join('rools','users.id','=','rools.type_id')
            ->first();
            return response()->json([
                'status'=>true,
                'messege'=>"Sizning malumotlaringiz",
                'data'=>$date
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }
    //Logout
    public function logout(){
        try{
            Auth()->user()->tokens()->delete();
            return response()->json([
                'status'=>true,
                'messege'=>"Logindan chiqildi",
                'data'=>[],
            ],200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'messege'=>$th->getMessege(),
            ],200);
        }
    }

}
