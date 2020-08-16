<?php

namespace App\Providers;

use App\Model\Conversation;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require base_path('routes/channels.php');

        Broadcast::channel('user.*',function ($user , $userId){

            return (int)$user->id === (int)$userId ;
        });

        Broadcast::channel('conversations.*',function ($user , $conversationId){

            return $user->isInConversation(Conversation::findOrFail($conversationId)) ;
        });
    }
}
