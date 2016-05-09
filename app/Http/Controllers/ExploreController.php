<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Tmdb;


class ExploreController extends BaseController
{
    use GetPoster;

    public function __construct()
    {            
        parent::__construct();       
    }

    public function index() 
    { 
    	$response = array(); 
    	for($i=1; $i<10; $i++) {
    		$top_rated = Tmdb::getMoviesApi()->getTopRated(['page'=>$i]);    	
	    	foreach($top_rated['results'] as $latest_movie) {
	    		if($latest_movie['poster_path']!=null) {
	    			$latest_movie['poster_path'] = $this->get_poster($latest_movie['poster_path']);	    			
		    		array_push($response,$latest_movie);	    	
	    		}    		
	    	}
    	}    	    	   
    	$currentPage = LengthAwarePaginator::resolveCurrentPage();    	
    	$path = LengthAwarePaginator::resolveCurrentPath();  
    	$collection = new Collection($response);
    	$perPage = 8;
    	$currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();
    	$paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage, Paginator::resolveCurrentPage(), [
    		'path' => Paginator::resolveCurrentPath()
		]);    	
    	return view('explore.movies', ['movies' => $paginatedSearchResults]);    	
    } 

    public function collections()
    {
        $collections = \DB::table('collections')            
            ->join('users','collections.user_id','=', 'users.id')
            ->select('users.id as user_id','users.name as user_name','collections.id as collection_id','collections.name','collections.description')
            ->get();               
        $currentPage = LengthAwarePaginator::resolveCurrentPage();      
        $path = LengthAwarePaginator::resolveCurrentPath();  
        $collection = new Collection($collections);        
        $shuffled = $collection->shuffle();        
        $perPage = 4;
        $currentPageSearchResults = $shuffled->slice(($currentPage * $perPage)-1, $perPage)->all();        
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($shuffled), $perPage, Paginator::resolveCurrentPage(), [
            'path' => Paginator::resolveCurrentPath()
        ]);    
            
        return view('explore.lists', ['collections' => $paginatedSearchResults]);        
    }
}
