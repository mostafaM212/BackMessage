<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Resources\ConversationResource;
use App\Model\Conversation;
use Illuminate\Http\Request;

class ConversationUserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('myAuth');
    }
    public function store(AddUserRequest $request , Conversation $conversation){

        $this->authorize('affect',$conversation);

        $conversation->users()->syncWithoutDetaching($request->users) ;

        return new ConversationResource($conversation);
    }
}
