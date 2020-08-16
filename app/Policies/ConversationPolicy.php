<?php

namespace App\Policies;

use App\Model\Conversation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function reply(User $user ,Conversation $conversation){

        return $this->affect($user,$conversation) ;
    }
    public function show(User $user ,Conversation $conversation){

        return $this->affect($user,$conversation) ;
    }

    public function affect(User $user , Conversation  $conversation){

        return $user->isInConversation($conversation) ;
    }
}
