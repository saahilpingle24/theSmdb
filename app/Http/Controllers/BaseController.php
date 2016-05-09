<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use Auth;
use Redis;
use App\User;

class BaseController extends Controller
{
    public function __construct() {
    	if(Auth::check()) {                        
            $following = User::find(Auth::user()->id)->following()->get()->lists('id');  
            $array = array();            
            foreach($following as $key=>$value) {                
                array_push($array, $value);    
            } 
            $last_logout = User::find(Auth::user()->id)->lists('last_logout')->first();  
            $feed = \DB::table('activity_log')
                ->join('users','users.id','=','activity_log.user_id')
                ->select('activity_log.text')
                ->whereIn('user_id',$array)  
                ->where('activity_log.created_at','>',$last_logout)          
                ->get();            
            $array_result = array();
            foreach($feed as $key=>$value) {
                foreach($value as $sub_key=>$sub_value) {                    
                    array_push($array_result,$sub_value);
                }
            }   
            Redis::set('feed', json_encode($array_result));    
        }                 
        $feed = Redis::get('feed');                    
    	View::share('feed',$feed);                    
    }
}
