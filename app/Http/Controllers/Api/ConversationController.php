<?php

namespace App\Http\Controllers\Api;

use App\Events\ConversationCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationStoreRequest;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ShowConversationResource;
use App\Model\Conversation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    //
    public function __construct(){

        $this->middleware('myAuth');
    }

    public function index(Request $request){
        //
        $conversations = $request->user()->conversations()->get();

        return ConversationResource::collection($conversations);
    }

    public function show(Conversation $conversation){

        $this->authorize('show',$conversation);
        if ($conversation->isReply()){
            abort(404);
        }
        return new ShowConversationResource($conversation) ;
    }

    public function store(ConversationStoreRequest  $request){

        $conversation = Conversation::create([
            'body'=>$request->body ,
            'parent_id'=>null,
            'user_id'=>$request->user()->id,
            'last_replay'=>Carbon::now(),

        ]);
        $conversation->touchLastReplay();
        $conversation->users()->syncWithoutDetaching(array_merge($request->users,[$request->user()->id]));
        $conversation->load('users');
        broadcast(new ConversationCreated($conversation))->toOthers();
        return new ConversationResource($conversation) ;
    }
}
