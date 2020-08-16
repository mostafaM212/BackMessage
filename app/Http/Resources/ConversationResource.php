<?php

namespace App\Http\Resources;

use App\Model\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id'=>$this->id ,
            'parent_id'=> $this->parent ? $this->parent->id :null,
            'body'=>$this->body ,
            'created_at'=>$this->created_at->diffForHumans(),
            'last_replay'=>($this->last_replay) ? $this->last_replay->diffForHumans() :null,
            'participate_count'=>$this->usersExceptCurrentlyAuthenticated()->count(),
            'user'=> new UserResource($this->user),
            'users'=>UserResource::collection($this->users)

        ];
    }


}
