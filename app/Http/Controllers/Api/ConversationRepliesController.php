<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyStoreRequest;
use App\Http\Resources\ConversationResource;
use App\Model\Conversation;
use Illuminate\Http\Request;

class ConversationRepliesController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('myAuth') ;
    }

    public function store(ReplyStoreRequest $request,Conversation $conversation){

        $this->authorize('reply',$conversation);
        $reply = new Conversation();

        $reply->body = $request->body ;

        $reply->user()->associate($request->user());

        $conversation->replies()->save($reply) ;
        $conversation->touchLastReplay() ;

        return new ConversationResource($reply);
    }
}
