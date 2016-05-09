<?php

use Illuminate\Database\Seeder;
use App\User;

class CollectionsTableSeeder extends Seeder
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
        $users = User::lists('id')->all();        
        for($i = 0; $i < $limit; $i++) {
            $id = $faker->unique()->randomElement($users);
            for($j=0; $j<5; $j++) {
                DB::table('collections')->insert([
                'name' => $faker->word,
                'user_id' => $id,
                'description' => $faker->text($maxNbChars = 255),
            ]);
            }        	
        }
    }
}
