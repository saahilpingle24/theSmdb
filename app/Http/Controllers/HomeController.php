<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Tmdb;
use App\Movie;
use Redis;
use Cloudder;
use View;

class HomeController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');         
        parent::__construct();       
    }

    public function index()
    {           
        
        if(Redis::exists('set_time')) {            
            $set_time = Redis::get('set_time');                         
            $now = strtotime(date('Y-m-d H:i:s'));
            $difference = ($now-$set_time)/(60*60);
            if((int)$difference>10) {
                Redis::flushall();
                $fetch_new = true;
            } else {
                $fetch_new = false;
            }
        } else {
            $fetch_new = true;
        }
        
        if($fetch_new) {
            $movies =  Tmdb::getMoviesApi()->getPopular();
            foreach($movies['results'] as $movie) {
                $movie['poster_path'] = $this->get_poster($movie['poster_path']);
                Redis::set($movie['id'], json_encode($movie));
            }
            Redis::set('set_time', strtotime(date('Y-m-d H:i:s'))); 
        }           
        
        $movies = array();
        $keys = Redis::keys('*');
        if(($key = array_search('feed', $keys)) !== false) {
            unset($keys[$key]);
        }
        if(($key = array_search('set_time', $keys)) !== false) {
            unset($keys[$key]);
        }   
        $featured_movie = $this->get_featured_movie(); 
        shuffle($keys);
        $keys = array_slice($keys,0, 20);        
        foreach($keys as $tmdb_id) {
            $response = Redis::get($tmdb_id);
            $response = json_decode($response);
            $movies[$tmdb_id] = $response;
        }                
        return view('welcome')->with(['movies'=>$movies,'featured'=>$featured_movie]);
    }

    public function store_to_db($movies) {         
        foreach($movies as $movie) {               
            if (Movie::where('tmdb_id', '=', $movie['id'])->exists()) {
                if(\DB::table('popular_movies')->where('tmdb_id', $movie['id'])->exists()) {

                } else {
                    $movie_id = Movie::where('tmdb_id', '=', $movie['id'])->lists('id')->first();
                    \DB::table('popular_movies')->insert([                    
                        'movie_id' => $movie_id,
                        'tmdb_id' => $movie['id'],                    
                    ]);    
                }                
            } else {
                $poster_path = $this->get_poster($movie['poster_path']);                
                Movie::create([
                    'title' => $movie['title'],
                    'original_title' => $movie['original_title'],
                    'vote_average' => $movie['vote_average'],
                    'popularity' => $movie['popularity'],
                    'tmdb_id' => $movie['id'],
                    'overview' => $movie['overview'],
                    'poster_path' => $poster_path,
                    'release_date' => $movie['release_date']
                ]);                            
            }
        }                
    }

    public function get_featured_movie()
    {
        $numbers = range(0, 19);
        shuffle($numbers);        
        $featured_movie = Tmdb::getMoviesApi()->getNowPlaying()['results'][$numbers[0]];
        
        while($featured_movie['backdrop_path'] == null) {
            shuffle($numbers);        
            $featured_movie = Tmdb::getMoviesApi()->getNowPlaying()['results'][$numbers[0]];    
        }

        $featured_movie['backdrop_path'] = $this->get_backdrop($featured_movie['backdrop_path']); 

        return $featured_movie;
    }

    public function get_poster($poster_path) 
    {         
        $url = "https://image.tmdb.org/t/p/w300/";        
        $answer = $url.$poster_path;
        return $answer;
    }

    public function get_backdrop($backdrop_path) 
    {
        $url = "https://image.tmdb.org/t/p/w780/";    
        $answer = $url.$backdrop_path;
        return $answer;
    }

    public function getFollowing($id) {
        $following = \DB::table('follow_user')
            ->select('follows_id')
            ->join('users', 'follow_user.follows_id', '=', 'users.id')
            ->where('follow_user.user_id','=', $id)            
            ->get();
        return $following;
    }
}
