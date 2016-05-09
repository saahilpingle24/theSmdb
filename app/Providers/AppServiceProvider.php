<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('includes.head', function() {
            if(Auth::check()) {   
            dd('sdsa');         
                $feed = Redis::get('feed');
                if(!$feed) {
                    $following = $this->getFollowing(Auth::user()->id);  
                $array = array();
                foreach($following as $key=>$value) {
                    foreach($value as $sub_key=>$sub_value) {
                        array_push($array, $sub_value);    
                    }            
                }                        
                $feed = \DB::table('activity_log')
                    ->select('text')            
                    ->whereIn('user_id',$array)            
                    ->get();

                $array_result = array();
                foreach($feed as $key=>$value) {
                    foreach($value as $sub_key=>$sub_value) {                    
                        array_push($array_result,$sub_value);
                    }
                }   
                Redis::set('feed', json_encode($array_result));    
                }                 
                $feed = Redis::get('feed');                        
            }
            $view->with('feed',$feed);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
