<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Collection;
use Auth;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;
use Cloudder;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show','getFollowing','getFollowers']);
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
        if(Auth::check()) {
            if($id == Auth::user()->id) {
                $allow_creation = "1";
            }
        }
        $allow_creation = "0";
        $user = User::Find($id);
        $following = $user->following;
        $followers = $user->followers;
        return view('profile.show')->with(['followers'=> $followers,'following'=>$following,'allow_creation'=>$allow_creation,'profile'=>$profile,'collections'=>$collections]);
    }  

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'password' => 'required|min:6|confirmed'
        ]);
    }

    public function edit($id) 
    {
        $user = User::Find(Auth::user()->id);
        $profile_picture = explode('/',$user['profile_picture']);
        $og_profile_picture = $user['profile_picture'];
        $user['profile_picture'] = end($profile_picture);         
        return view('profile.edit')->with(['user'=>$user,'profile_picture'=>$og_profile_picture]);
    } 

    public function update(Request $request, $id) {        
        $data = $request->only(['name','username','email','profile_picture','password','password_confirmation']);        
        $validator = $this->validator($data);
        if($validator->fails()) {               
            return Redirect::back()->withErrors($validator);            
        } else {            
            if($data['profile_picture']==null) {                
                $data['profile_picture'] = Auth::user()->profile_picture;                
            } else {
                if(Input::file('profile_picture')->isValid()) {                    
                    Cloudder::upload($data['profile_picture'], $data['username'], array("width"=>"256", "height"=>"256", "crop"=>"scale"));                    
                    $results = Cloudder::getResult();                       
                    $data['profile_picture'] = $results['url'];
                }   
            }   
            User::where('id', $id)                
                ->update(['name' => $data['name'],
                    'profile_picture'=>$data['profile_picture'],
                    'password'=>bcrypt($data['password'])
                ]);        
            return redirect()->route('profile.index');
        }
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
