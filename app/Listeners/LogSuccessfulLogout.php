<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Auth;

class LogSuccessfulLogout
{    
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle($event)
    {               
        User::where('id',$event->user->id)
            ->update(['last_logout'=>  date("Y-m-d H:i:s")]);
    }
}
