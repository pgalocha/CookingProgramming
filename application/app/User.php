<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','contact','avatar','password',
    ];

    protected $appends=['chunk_email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function comments(){
        return $this->hasManyThrough('App\Comment','App\Post');
}
    public function getChunkEmailAttribute($value){
        $arrayEmail= explode("@",$this->email);
        if(count($arrayEmail)!=2) return $value;
        $chunkEmail1= substr($arrayEmail[0],0,2);
        $chunkEmail2= $arrayEmail[1];
        return $chunkEmail1 . "...@" . $chunkEmail2;
    }

}
