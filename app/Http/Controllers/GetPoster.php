<?php
namespace App\Http\Controllers;

trait GetPoster {
	
	public function get_poster($poster_path) 
    {         
        $url = "https://image.tmdb.org/t/p/w300";        
        $answer = $url.$poster_path;
        return $answer;
    }

    public function get_backdrop($backdrop_path) 
    {
        $url = "https://image.tmdb.org/t/p/w780/";    
        $answer = $url.$backdrop_path;
        return $answer;
    }
}

?>