<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopularMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popular_movies', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('movie_id')->unsigned();
            $table->integer('tmdb_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('popular_movies');
    }
}
