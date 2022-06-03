<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\userResource;
use App\Http\Resources\v1\videoCollection;
use App\Http\Resources\v1\videoResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\FileStorageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    use FileStorageTrait;
    public $user;
    public function __construct(User $user){
        $this->user = $user;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(Request $request){
        $request->validate([
            'email' => 'required|min:6|max:25|unique:users',
            'name' => 'required',
            'password' => 'required|min:3|max:20',
            'passwordAgain' => 'required'
        ]);
        if($request->password == $request->passwordAgain){
            $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            );
            $data['image_path'] = $this->storageFile($request,'image','video','image');
            $newUser = $this->user->create($data);
            
            return response()->json([
                'code' => 200,
                'data' => new userResource($newUser)
            ],200);
        }else{
            return response()->json([
                'code' => 400,
                'message' => 'password incorrect'
            ],400);
        }

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $existUser = $this->user->where('email',$request->email)->first();
        if($existUser){
            if(! $token = auth()->attempt(['email' => $request->email,'password' => $request->password])){

                return response()->json([
                    'code' => 400,
                    'message' => 'password incorrect !'
                ],400);
            }
            return $this->createNewToken($token);
            
        }else{
            return response()->json([
                'code' => 400,
                'message' => 'email not exist !'
            ],400);
        }

    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // *60 = 1h
            'expires_in' => Auth::factory()->getTTL() * 60* 2,
            'user' => auth()->user()
        ]);
    }
    public function logout(Request $request){
        Auth::logout();
        return response()->json([
            'code' => 200,
            'message' => 'logout success !'
        ],200);
    }
    public function userProfile(Request $request){
        return response()->json([
            'code' => 200,
            'message' => new userResource(auth()->user())
        ],200);
    }
    public function userVideo(){
        return new videoCollection(auth()->user()->userVideo);
    }
}
