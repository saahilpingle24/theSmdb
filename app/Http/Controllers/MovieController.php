<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Movie;

use Tmdb;

use Redis;

use App\Collection;

use Auth;
class MovieController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        parent::__construct();
    }

    public function index() 
    {

    }
    
    public function show($id) 
    {    	    	
    	$response = (array)json_decode(Redis::get($id));
        
        if($response==null) {
            $response =  Tmdb::getMoviesApi()->getMovie($id);
            $response['poster_path'] = $this->get_poster($response['poster_path']);
            Redis::set($response['id'], json_encode($response));
        }        

    	$reviews = Tmdb::getMoviesApi()->getReviews($id);  
    	$videos = Tmdb::getMoviesApi()->getVideos($id);  
        $credits = Tmdb::getMoviesApi()->getCredits($id); 
        $similar = Tmdb::getMoviesApi()->getSimilar($id); 
        $suggestions = $similar['results'];
        $cast = $credits['cast'];        
        $crew = $credits['crew'];
        if(Auth::user()) {            
            $collections = Collection::with('movies')->where('user_id','=',Auth::user()->id)->get()->toArray();
            return view('movies.show')->with(['suggestions'=>$suggestions,'cast'=>$cast,'crew'=>$crew,'collections'=>$collections,'movie'=>$response, 'reviews'=>$reviews['results'],'videos'=>$videos['results']]);
        } else {
           return view('movies.show')->with(['suggestions'=>$suggestions, 'cast'=>$cast,'crew'=>$crew,'movie'=>$response, 'reviews'=>$reviews['results'],'videos'=>$videos['results']]); 
        }
        
    }

    public function get_poster($poster_path) 
    {         
        $url = "https://image.tmdb.org/t/p/w300/";        
        $answer = $url.$poster_path;
        return $answer;
    }

    public function surprise() 
    {
        $response =  Tmdb::getMoviesApi()->getTopRated();
        $numbers = range(0,19);
        shuffle($numbers);        
        return redirect()->route('movie.show',[$response['results'][$numbers[0]]['id']]);
    }
}
