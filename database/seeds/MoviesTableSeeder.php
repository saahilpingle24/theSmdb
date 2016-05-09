<?php

use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 10;
        for($i = 0; $i < $limit; $i++) {
        	DB::table('movies')->insert([
        		'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        		'original_title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'tmdb_id' => $faker->numberBetween($min = 1000, $max = 9000),
                'vote_average' => $faker->randomFloat($nbMaxDecimals = 1, $min = 1, $max =10.0),
                'popularity' => $faker->randomFloat($nbMaxDecimals = 1, $min = 1, $max =100.0),
                'release_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'overview' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'poster_path' => 'https://image.tmdb.org/t/p/w300//rpo9njGpJVLPqRrdM6R7wIqiQ7K.jpg'
        	]);
        }
    }
}
