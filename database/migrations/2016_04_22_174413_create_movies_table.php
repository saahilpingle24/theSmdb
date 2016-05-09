<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('tmdb_id')->unsigned();       
            $table->float('vote_average');
            $table->float('popularity');
            $table->string('title');
            $table->string('original_title');
            $table->string('release_date');
            $table->text('overview'); 
            $table->string('poster_path');            
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
        Schema::drop('movies');
    }
}
