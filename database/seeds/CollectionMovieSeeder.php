<?php

use Illuminate\Database\Seeder;
use App\Collection;
use App\Movie;

class CollectionMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $collections = Collection::get();
        $movies = Movie::lists('id')->all();      
        foreach ($collections as $collection){             
            shuffle($movies);
            $collection->movies()->attach($movies[0]);
            $collection->movies()->attach($movies[2]);
            $collection->movies()->attach($movies[4]);            
        }
    }
}
