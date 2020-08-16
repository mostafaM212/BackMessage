<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function __construct(){

        $this->middleware('myAuth')->only('user') ;
    }
    public function register(RegisterRequest $request){

        $user = User::create($request->only(['name','email','password']));

        if ($token = Auth::attempt($request->only(['email','password']))){

            $user =Auth::user();
            return (new UserResource($user))->additional([
                'meta'=>[
                    'token'=>$token
                ]
            ]) ;
        }else{
            return response('given email and password was invalid' ,401) ;
        }

    }

    public function login(LoginRequest  $request){

        if ($token = Auth::attempt($request->only(['email','password']))){

            $user =Auth::user();
            return (new UserResource($user))->additional([
                'meta'=>[
                    'token'=>$token
                ]
            ]) ;
        }else{
            return response('given email and password was invalid' ,401) ;
        }
    }

    public function user(Request $request){

        return new UserResource($request->user());
    }

    public function logout(Request $request){
        Auth::logout();
        return response()->json(null,200);
    }
}
