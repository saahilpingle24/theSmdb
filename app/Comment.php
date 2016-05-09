<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;
use Auth;
use App\Collection;

class Comment extends Model implements LogsActivityInterface
{
    use LogsActivity;

    protected $fillable = [
        'comment', 'user_id', 'collection_id'
    ];

    public function collections() {
    	return $this->belongsTo('App\Collection');
    }

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
           $name = Collection::where('id','=',$this->collection_id)->lists('name')->first();
           return Auth::user()->name.' posted a new comment on ' . $name;
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
