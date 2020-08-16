<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    //
    protected $fillable = ['body','user_id','last_replay','parent_id'];
    protected $dates = ['last_replay'];

    public function user(){
        return $this->belongsTo(User::class) ;
    }

    public function users(){

        return $this->belongsToMany(User::class) ;
    }

    public function usersExceptCurrentlyAuthenticated(){

        return $this->users()->where('user_id','!=',Auth::user()->id);
    }

    public function replies(){
        return $this->hasMany(Conversation::class,'parent_id')->lastestFirst() ;
    }

    public function parent(){
        return $this->belongsTo(Conversation::class,'parent_id');
    }

    public function touchLastReplay(){

        $this->last_replay = Carbon::now();
        $this->save();
    }

    public function isReply(){
        return $this->parent_id !== null ;
    }

    public function scopeLastestFirst( $query){

        return $query->orderBy('created_at','desc');
    }
}
