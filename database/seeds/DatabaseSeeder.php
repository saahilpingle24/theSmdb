<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UsersTableSeeder::class);
        $this->call(CollectionsTableSeeder::class);
        $this->call(MoviesTableSeeder::class);
        $this->call(CollectionMovieSeeder::class);        
        $this->call(CommentsTableSeeder::class);
        Model::reguard();
    }
}