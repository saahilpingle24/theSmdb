<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Collection;
use Auth;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index() 
    {
    	$profile = User::where('id',Auth::user()->id)->first();
        $collections = Collection::with('comments')->with('movies')->where('user_id',Auth::user()->id)->get();        
    	$allow_creation = "1";
        $user = User::Find(Auth::user()->id);
        $following = $user->following;
        $followers = $user->followers;        
        return view('profile.profile')->with(['followers'=> $followers,'following'=>$following,'allow_creation'=>$allow_creation,'profile'=>$profile,'collections'=>$collections]);
    }

    public function show($id)
    {
        $profile = User::where('id',$id)->first();
        $collections = Collection::with('comments')->with('movies')->where('user_id',$id)->get();
        $id == Auth::user()->id ? $allow_creation = "1" : $allow_creation = "0";
        $user = User::Find($id);
        $following = $user->following;
        $followers = $user->followers;
        return view('profile.show')->with(['followers'=> $followers,'following'=>$following,'allow_creation'=>$allow_creation,'profile'=>$profile,'collections'=>$collections]);
    }  

    public function create() 
    {

    } 

    public function follow(Request $request) {
        $user = User::find($request->id);            
        $request->user()->following()->attach($user);        
        return redirect()->back();      
    }

    public function unfollow(Request $request) {
        $user = User::Find($request->id);
        if(Auth::user()->isFollowing($user->id)) {
            $request->user()->following()->detach($user);    
        }    
        return redirect()->back();      
    } 

    public function getFollowing($id) {
        $following = \DB::table('follow_user')
            ->join('users', 'follow_user.follows_id', '=', 'users.id')
            ->where('follow_user.user_id','=', $id)            
            ->get();    
        
        return view('users.following', ['following' => $following]);
    }

    public function getFollowers($id) {
        $followers = \DB::table('follow_user')
            ->join('users', 'follow_user.user_id', '=', 'users.id')
            ->where('follow_user.follows_id','=', $id)            
            ->get();             
        return view('users.followers', ['followers' => $followers]);
    }
}
