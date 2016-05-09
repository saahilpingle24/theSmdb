<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function collections() {
        return $this->hasMany('App\Collection');        
    }

    public function isThisMe($id) {        
        return $id == Auth::user()->id;
    }
    
    public function alreadyFollows($id) {    
        return $this->isFollowing($id);
    }

    public function isFollowing($id) {          
        return (bool) $this->following->where('id', $id)->count();
    }

    public function following() {
        return $this->belongsToMany('App\User', 'follow_user', 'user_id', 'follows_id');
    }

    public function followers() {
        return $this->belongsToMany('App\User', 'follow_user', 'follows_id', 'user_id');
    }
}
