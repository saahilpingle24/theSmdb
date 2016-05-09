<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;
use Auth;
use App\Collection;
Use App\Movie;

class CollectionMovie extends Model implements LogsActivityInterface
{
    use LogsActivity;

    protected $table = "collection_movie";

    protected $fillable = [
        'collection_id', 'movie_id'
    ];

    public function collections()
    {
    	return $this->belongsTo('App\Collection');
    }

    public function getActivityDescriptionForEvent($eventName)
    {
        
        if ($eventName == 'created')
        {
        	$collection_name = Collection::where('id','=',$this->collection_id)->lists('name')->first();
        	$movie_name = Movie::where('id','=',$this->movie_id)->lists('title')->first();        	
            return Auth::user()->name.' added the movie ' . $movie_name.' to the collection '.$collection_name;
        }

        return '';
    }
}
