<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'original_title', 'overview', 'tmdb_id', 'popularity', 'vote_average', 'poster_path', 'release_date'
    ];

    public function collections() {
    	return $this->belongsToMany('App\Collection');
    }
}
