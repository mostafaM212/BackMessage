<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('myAuth');
    }

    public function index(){
        $users = User::all() ;

        return UserResource::collection($users) ;
    }
}
