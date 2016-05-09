<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Movie;
use App\Collection;
use Redis;
use App\CollectionMovie;

class CollectionMovieController extends Controller
{
    public function store(Request $request)
    {
    	try {
    		if($request->ajax()) {    			
	      		$data = $request->only('collection_id','movie_id');	      		
	      		if(!Movie::where('tmdb_id','=',$data['movie_id'])->exists()) {
	      			$response = (array)json_decode(Redis::get($data['movie_id']));
	      			$movie = Movie::create([
	                	'tmdb_id' => $response['id'],
		                'vote_average' => $response['vote_average'],
		                'popularity' => $response['popularity'],
		                'title' => $response['title'],
		                'original_title' => $response['original_title'],
		                'release_date' => $response['release_date'],
		                'overview' => $response['overview'],
		                'poster_path' => $response['poster_path'],
	            	]);
	      		}
	      		$id = Movie::where('tmdb_id','=',$data['movie_id'])->lists('id')->first();  
	      		CollectionMovie::create([
	                'collection_id' => $data['collection_id'],
	                'movie_id' => $id
	            ]);
	   //    		\DB::table('collection_movie')->insert(
	   //  			['collection_id' => $data['collection_id'], 'movie_id' => $id]
				// );
    			return "Movie added <i class='fa fa-thumbs-o-up' aria-hidden='true'></i>";
    		}    		
    	} catch(\Exception $e) {  
    		 	
    		return "In there already <i class='fa fa-hand-spock-o' aria-hidden='true'></i>";
    	} 	
    }
}
