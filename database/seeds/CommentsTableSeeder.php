<?php

use Illuminate\Database\Seeder;
use App\Collection;
use App\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();        
        $collections = Collection::lists('id')->all();
        $users = User::lists('id')->all();
        $limit=5;
        foreach($collections as $collection) {  
        shuffle($users);          
            for($i = 0; $i < $limit; $i++) {
                DB::table('comments')->insert([
                    'comment' => $faker->sentence,
                    'collection_id' => $collection,
                    'user_id' => $users[$i]
                ]);
            }    
        }        
                
    }
}
