<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;
use Auth;

class Collection extends Model implements LogsActivityInterface
{
    
    use LogsActivity;    

    protected $fillable = [
        'name', 'description'
    ];

    public function users() {
    	return $this->belongsTo('App\User');
    }

    public function movies() {
    	return $this->belongsToMany('App\Movie');
    }   

    public function comments() {
    	return $this->hasMany('App\Comment');
    }

    public function getActivityDescriptionForEvent($eventName)
    {
        
        if ($eventName == 'created')
        {
            return Auth::user()->name.' created a new collection called ' . $this->name;
        }

        if ($eventName == 'updated')
        {
            return 'Collection "' . $this->name . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Collection "' . $this->name . '" was deleted';
        }

        return '';
    }
}
